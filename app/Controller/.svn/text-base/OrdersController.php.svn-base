<?php
App::uses('AppController', 'Controller');
/**
 * Orders Controller
 *
 * @property Order $Order
 */
class OrdersController extends AppController {

	public $uses = array('Order','Depot','DepotVoucher','Category','DepotLog');

	public $components = array('DepotHelper','DepotOrder');

	public function sell_index(){
		$this->UserAuth->hasPurview('sell_ticket');

		$conditions = array(
			'Category.consume_mode'=>'only_one'
		);
		$this->Order->cache = false;
		$this->Order->recursive = -1;
	    $this->paginate = array(
			'fields'=>array('Depot.ticket_no','Depot.voucher_total','Order.*','Category.*'),
			'joins'=>array(
                array(
                    'table' => 'depots',
                    'alias' => 'Depot',
                    'type' => 'inner',
                    'conditions' => 'Order.depot_id=Depot.id'
                ),
                array(
                    'table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'inner',
                    'conditions' => 'Depot.category_id=Category.id'
                ),
			),
			'order'=>'Order.created desc',
			'limit'=>'15',
			'conditions' => $conditions 
		);
		$data = $this->paginate('Order');
		//获取购票表单数据
		$categories = $this->Category->findListByConsumeMode('only_one');
		$this->set('categories',$categories);

		$conditions = array();
		if($this->request->query['category_id']){
			$conditions = array('id'=>$this->request->query['category_id']);
		}
		$this->request->data = $this->Category->find('first',array(
			'conditions'=>$conditions,
            'order'=>'Category.id desc'
		));
		//当天统计
		$statis = $this->Order->dayStatis($this->UserAuth->getUserId());
		$this->set('data',$data);
		$this->set('statis',$statis);
		$this->set($this->Category->getArr());	
	}
 	
 	/**
 	 * 票激活
 	 */
 	public function sell_add(){
 		if($this->request->data){
			$post_data = $this->request->data;
           	list($result,$data) = $this->DepotHelper->organize_data($post_data);
           	if($result){
           		$post_data = $data;
           	}else{
           		$this->error($msg);
       			$this->redirect(array('action'=>'index','sell'=>true));
           	}

           	//必须是上架状态
           	$conditions = array('Depot.active=1');
           	$exists = $this->DepotHelper->check_validate($post_data,$conditions);
       		//把需要处理的订单放到session当中,一个简易的购物车
       		$this->Session->write('wait_actived',$exists);
 		}
 			
 		if($exists){
 			//统计个数、价格
 			$count = $sum = 0;
 			foreach ($exists as $key => $one) {
 				$count++;
 				$sum += $one['Category']['price'];
 			}
 			$this->set('data',$exists);
 			$this->set(compact('count','sum'));
 		}else{
 			$this->error('错误请求！');
 			$this->set('data',array());
 		}
 		$this->set($this->Category->getArr());
 		$this->view = 'order_confirm';
 	}

 	/**
 	 * 票的打印，同时进行入库、出库、生成订单
 	 * 生成一组票号码
 	 * 1\写入库存数据
 	 * 2\写入入库、领票日志
 	 * 3\生成订单
 	 */
 	public function sell_print(){	
 		if($this->request->is('put')){
 			$post_data = $this->request->data;
	 		$category = $this->Category->read(null,$post_data['Category']['id']);
	 		if(!$category){
				throw new NotFoundException("无效票种");
			}
			if($post_data['Depot']['number'] <= 0){
				$this->error('无效票数！');
				$this->redirect($this->referer());
			}

			if($post_data['AgentUser']['guide_no']){
				$this->loadModel('AgentUser');
				$agent_user = $this->AgentUser->findByGuideNo($post_data['AgentUser']['guide_no']);
				if(!$agent_user){
					$this->error('无效导游证！');
					$this->redirect($this->referer());
				}
			}
			$post_data['Depot']['start_no'] = $this->Depot->generateTicketNo();
	        $post_data['Depot']['end_no'] = str_pad($post_data['Depot']['start_no']+($post_data['Depot']['number']-1), strlen($post_data['Depot']['start_no']) , '0', STR_PAD_LEFT); 
	 		
	 		//构建$post_data 
	 		$post_data['Depot']['depot_type'] = 'batch';
	 		$post_data['Depot']['category_id'] = $category['Category']['id'];
	 		if(!$post_data['Depot']['valid_start']){
		 		$post_data['Depot']['valid_start'] = date('Y-m-d H:i:s',time());
	 		}
	 		$db = $this->Order->getDataSource();
	 		$db->begin();
	 		try {
	 			list($result,$data) = $this->DepotHelper->organize_data($post_data);
	 			if(!$result){
	 				throw new Exception($data, 1);
	 			}else{
	 				$post_data = $data;
	 			}

	 			$this->DepotHelper->_import($post_data);
	 			$this->DepotHelper->_export($post_data);
	 			//检出数据
	   			$exists = $this->DepotHelper->check_validate($post_data,array('Depot.active=1'));
	 			
	 		} catch (Exception $e) {
	            $db->rollback();
	           	$this->error($e->getMessage().' 错误代码'.$e->getCode());
	           	return ;
	 		}
	 		$db->commit();

			$this->Session->write('wait_actived',$exists);
			if($agent_user){
				$this->Session->write('agent_user',$agent_user);
			}
	 		list($result,$msg) = $this->DepotOrder->submit();
	 		if($result){
	 			$this->succ('出票成功！');
	 			//统计个数、价格
	 			$count = $sum = 0;
	 			foreach ($exists as $key => $one) {
	 				$count++;
	 				$sum += $one['Category']['price']*$one['Depot']['voucher_total'];
	 			}
	 			$this->set('data',$exists);
	 			$this->set(compact('count','sum'));
	 		}else{
	 			$this->error($data);
	 			$this->set('data',array());
	 		}
	 		$this->set($this->Category->getArr());
	 		$this->view = 'sell_print';
 		}else{
 			$this->redirect(array('action'=>'index','sell'=>true));
 		}
 	}

 	/**
 	 * 提交订单
 	 */
 	public function sell_submit(){
 		list($result,$msg) = $this->DepotOrder->submit();
 		if($result){
 			$this->succ('出票成功！');
 		}else{
 			$this->error($msg);
 		}
        $this->redirect(array('action'=>'index','sell'=>true));
 	}

 	/**
 	 * 1\找到需要退的票
 	 * 2\验证是否可以退票
 	 * 3\更具选择的退票方式,重新入库或者作废即可
 	 */
 	public function sell_refund(){
		$this->UserAuth->hasPurview('sell_refund');

 		$query = $this->request->query;
 		if($query['ticket_no']){
 			$conditions['Depot.ticket_no'] = $query['ticket_no'];
 			$conditions['Order.active'] =  0;
	 		$this->Order->recursive = 2;
	 		$this->Order->cache = false;
	 		$order = $this->Order->find('first',array(
	 			'conditions'=>$conditions,
	 		));
	 		if($order){
		 		$this->request->data['Order'] = $order['Order'];
		 		$this->request->data['Category'] = $order['Depot']['Category'];
		 		if($order['Depot']['Category']['support_refund'] == 'n'){
		 			$this->error('本票不允许退票！');
		 		}
	 		}else{
		 		$this->error('没有找到有效订单!');
	 		}
		}
		if($this->request->is('put') && $order ){
			list($result,$msg) = $this->DepotOrder->refund($order);
			if($result){
				$this->succ('操作成功！');
			}else{
				$this->error($msg);
			}
		}
		$conditions = array(
			'Order.active<=-1',
			'Category.consume_mode'=>'only_one'
		);
		$this->Order->cache = false;
		$this->Order->recursive = -1;
	    $this->paginate = array(
			'fields'=>array('Depot.ticket_no','Depot.voucher_total','Order.*','Category.*'),
			'joins'=>array(
                array(
                    'table' => 'depots',
                    'alias' => 'Depot',
                    'type' => 'inner',
                    'conditions' => 'Order.depot_id=Depot.id'
                ),
                array(
                    'table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'inner',
                    'conditions' => 'Depot.category_id=Category.id'
                ),
			),
			'order'=>'Order.created desc',
			'limit'=>'15',
			'conditions' => $conditions 
		);
		$data = $this->paginate('Order');

		$this->set('data',$data);
		$this->set($this->Category->getArr());
 	}
 	

 	/**
 	 * 普通卡验票验票查询
 	 */
 	public function sell_view_only_one(){
		$this->UserAuth->hasPurview('sell_check_ticket');
 		
 		$this->set($this->Depot->getArr());
 		if($this->request->data){
 			$post_data = $this->request->data;

 			$ticket_no = $post_data['Depot']['ticket_no'];
	 		$this->Order->recursive = 2;
	 		$this->Order->cache = false;
	 		$order = $this->Order->find('first',array(
	 			'conditions'=>array(
	 				'Depot.ticket_no'=>$ticket_no
	 			)
	 		));
	 		if(!$order){
	 			$this->error('找不到编号为'.$ticket_no.'的票号!');
	 			return ;
	 		}
	 		$this->set('order',$order);
 		}

 	}
 		
 	/**
 	 * 年票查询
 	 */
 	public function sell_view_year($card_no = null){
		$this->UserAuth->hasPurview('sell_check_ticket');

 		$this->loadModel('DepotAnnual');
 		$this->set($this->Depot->getArr());
 		$this->set('card_no',$card_no);
 		if($this->request->data){
 			$post_data = $this->request->data;

 			$card_no = $post_data['DepotAnnual']['card_no'];
	 		$this->DepotAnnual->recursive = 2;
	 		$this->DepotAnnual->cache = false;
	 		$depot_annual = $this->DepotAnnual->find('first',array(
	 			'conditions'=>array(
	 				'DepotAnnual.card_no'=>$card_no
	 			)	
	 		));
	 		if(!$depot_annual){
	 			$this->error('找不到编号为'.$ticket_no.'的票号!');
	 			return ;
	 		}
	 		$this->set('depot_annual',$depot_annual);
 		}
 	}

	/**
	 * 代理销售报告 
	 */
	public function agent_index(){
		$this->UserAuth->hasPurview('agent_sell_report');

		$query = $this->request->query;
		$conditions = array(
			'Order.active>=0',
		);
		if($query['start_time'] && $query['end_time']){
			$start_time = strtotime($query['start_time']);
			$end_time = strtotime($query['end_time']);
		}
		if($query['quick']){
			$result =  $this->Order->get_time_conditions($query['quick']);
			list($start_time, $end_time, $search_date) = $result;
		}
		$conditions['Order.created >='] = $start_time;
		$conditions['Order.created <='] = $end_time;

		$this->Order->recursive = -1;
		$this->Order->cache = false;
		$data = $this->Order->find('first',array(
			'fields'=>array(
				'COUNT(1) as count','SUM(Order.price) as sum',
			),
			'joins'=>array(
				array(
					'table'=>'agent_users',
					'alias'=>'AgentUser',
					'type'=>'inner',
					'conditions'=>array(
						'order.buyer_id=AgentUser.id'
					)
				)
			),
			'conditions'=>$conditions
		));
		extract($data[0]);
		$this->set(compact('start_time','end_time','count','sum'));
	}

	/**
	 * 售票明细
	 */
	public function data_index(){
		$this->UserAuth->hasPurview('data_order_record');

		$conditions = array(
		);
        $query = $this->request->query;
        if($query['keyword']){
            $conditions[$query['type'].' like'] = '%'.$this->request->query['keyword'].'%';
        }
        if($query['start_time']){
            $conditions['Order.created'.' >='] = strtotime($query['start_time']);
        }
        if($query['end_time']){
            $conditions['Order.created'.' <='] = strtotime($query['end_time']);
        }
        $this->request->data['Depot'] = $query;
		$this->Order->cache = false;
		$this->Order->recursive = -1;
	    $this->paginate = array(	
			'fields'=>array(
				'Depot.ticket_no','Depot.voucher_total','Order.*','Category.*'),
			'joins'=>array(
                array(
                    'table' => 'depots',
                    'alias' => 'Depot',
                    'type' => 'inner',
                    'conditions' => 'Order.depot_id=Depot.id'
                ),
                array(
                    'table' => 'categories',
                    'alias' => 'Category',
                    'type' => 'inner',
                    'conditions' => 'Depot.category_id=Category.id'
                ),
			),
			'order'=>'Order.created desc',
			'limit'=>'15',
			'conditions' => $conditions 
		);
		$data = $this->paginate('Order');
		$this->set('data',$data);
		$this->set($this->Category->getArr());
	}

	/**
	 * 销售报告 
	 */
	public function data_report(){
		$this->UserAuth->hasPurview('data_sell_report');

		$query = $this->request->query;
		$conditions = array(
			'Order.active>=0',
		);
		if($query['start_time'] && $query['end_time']){
			$start_time = strtotime($query['start_time']);
			$end_time = strtotime($query['end_time']);
		}
		if($query['quick']){
			$result =  $this->Order->get_time_conditions($query['quick']);
			list($start_time, $end_time, $search_date) = $result;
		}
		$conditions['Order.created >='] = $start_time;
		$conditions['Order.created <='] = $end_time;

		$this->Order->recursive = -1;
		$this->Order->cache = false;
		$data = $this->Order->find('first',array(
			'fields'=>array(
				'COUNT(1) as count','SUM(Order.price) as sum',
			),
			'conditions'=>$conditions
		));
		extract($data[0]);
		$this->set(compact('start_time','end_time','count','sum'));
	}


	/**
	 * 作废记录
	 */
	public function data_invalid()
	{
		$this->UserAuth->hasPurview('data_cancel');
		
		$conditions = array(
			'DepotLog.action'=>'cancel',
		);

        $query = $this->request->query;
        if($query['keyword']){
            $conditions[$query['type'].' like'] = '%'.$this->request->query['keyword'].'%';
        }
        if($query['start_time']){
            $conditions['DepotLog.created'.' >='] = strtotime($query['start_time']);
        }
        if($query['end_time']){
            $conditions['DepotLog.created'.' <='] = strtotime($query['end_time']);
        }
        $this->request->data['Depot'] = $query;

		$this->Category->cache = false;
		$this->Category->recursive = -1;
	    $this->paginate = array(
			'fields'=>array('Depot.ticket_no','User.name','Category.*','DepotLog.created'),
			'joins'=>array(
                array(
                    'table' => 'depots',
                    'alias' => 'Depot',
                    'type' => 'inner',
                    'conditions' => 'Depot.category_id=Category.id'
                ),
                array(
                    'table' => 'depot_logs',
                    'alias' => 'DepotLog',
                    'type' => 'inner',
                    'conditions' => 'Depot.ticket_no >= DepotLog.start_no AND Depot.ticket_no <= DepotLog.end_no'
                ),
                array(
                    'table' => 'users',
                    'alias' => 'User',
                    'type' => 'inner',
                    'conditions' => 'DepotLog.user_id=User.id'
                ),
			),
			'order'=>'DepotLog.created desc',
			'limit'=>'15',
			'conditions' => $conditions 
		);
		$data = $this->paginate('Category');
		$this->set('data',$data);
	}
}
