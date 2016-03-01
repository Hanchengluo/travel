<?php
App::uses('AppController', 'Controller');
/**
 * Depots Controller
 *
 * @property Depot $Depot
 */
class DepotsController extends AppController {
	public $uses = array('Depot','DepotVoucher','Category','DepotLog', 'Order');

	public $components = array('DepotHelper');
	
	/**
	 * 入库
	 */
	public function admin_index() {
		$this->UserAuth->hasPurview('admin_depot_import');

		if($this->request->is('post')){
			$post_data = $this->request->data;
	        $ret = $this->DepotHelper->dispatch('import',$post_data);
			list($result,$msg) = $ret;
			if($result){
				$this->succ('入库成功！');
           		$this->redirect($this->referer());
			}else{
				$this->error($msg);
			}
		}
		$categories = $this->Category->findListByConsumeMode('only_one');
		$this->set('categories',$categories);
	}

	/**
	 * 库存统计
	 */
	public function admin_statis(){
		$this->UserAuth->hasPurview('admin_depot_statis');

		$conditions = array(
			'Category.active>=0',
			'Category.consume_mode'=>'only_one'
		);

		$query = $this->request->query;
        if($query['keyword']){
            $conditions[$query['type'].' like'] = '%'.$query['keyword'].'%';
        }
       	if($query['active']){
       		$conditions['Depot.active'] = $query['active'];
       	}
        $this->request->data['Depot'] = $query;

		$this->Category->recursive = -1;
		$this->Category->cache = false;
		$this->paginate = array(
			'fields'=>array(
				'Category.*',
				'COUNT(Depot.id) as depot_sum'
			),
			'joins'=>array(
                array(
                    'table' => 'depots',
                    'alias' => 'Depot',
                    'type' => 'left',
                    'conditions' => 'Depot.category_id=Category.id'
                ),
			),
			'group'=>'Category.id',
			'order'=>'Category.id desc',
			'conditions'=>$conditions,
		);
		$data = $this->paginate('Category');
		$this->set('data',$data);
		$this->set($this->Category->getArr());
		$this->set($this->Depot->getArr());
	}

	/**
	 * category下的所有序列号
	 */
	public function admin_view($category_id = null) {
		$this->Category->id = $category_id;
		if (!$this->Category->exists()) {
			throw new NotFoundException(__('Invalid depot'));
		}
		$this->Category->recursive = -1;
		$this->Category->cache = false;
		$conditions = array(
			'Depot.category_id'=>$category_id,
			'DepotLog.action'=>'import',
			'Category.consume_mode'=>'only_one'
		);

		// 搜索
		$query = $this->request->query;	
		$this->request->data = array('Depot' => $query);
		if($query['type'] && $query['keyword']){
			$conditions[$query['type'].' like'] = '%'.$query['keyword'].'%';
		}
		if($query['start_time'] && $query['end_time']){
		    $conditions['DepotLog.created >= '] = strtotime($query['start_time']);
            $conditions['DepotLog.created <= '] = strtotime($query['end_time']) + 3600 * 24;
		}
		if($query['active']){
			$conditions['Depot.active'] = $query['active'];
		}

		$this->Category->cache = false;
	    $this->paginate = array(
			'fields'=>array('Depot.*','DepotLog.created','Category.*'),
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
                    'conditions' => 'Depot.create_from_id=DepotLog.id'
                ),
			),
			'order'=>'DepotLog.created desc',
			'conditions' => $conditions 
		);
		$data = $this->paginate('Category');
		$this->set('data',$data);
		$this->set($this->Depot->getArr());
	}

	/**
	 * cancel 作废
	 */
	public function admin_cancel($id){
		if (!$this->request->is('post')) {
			throw new MethodNotAllowedException();
		}

		$this->Depot->id = $id;
		$depot = $this->Depot->read();
		if (!$depot) {
			throw new NotFoundException(__('Invalid depot'));
		}

		$post_data = $depot;
		$post_data['Depot']['user_id'] = $this->UserAuth->getUserId();
		$post_data['Depot']['start_no'] = $depot['Depot']['ticket_no'];
		$post_data['Depot']['end_no'] = $depot['Depot']['ticket_no'];
		$post_data['Depot']['depot_type'] = 'batch';
		$post_data['Depot']['number'] = 1;

		$ret = $this->DepotHelper->dispatch('cancel',$post_data);
		list($result,$msg) = $ret;
		if($result){
			$this->succ('作废成功！');
		}else{
			$this->error($msg);
		}
       	$this->redirect($this->referer());
	}

	/**
	 * 售票员领票
	 * 这里只是修改状态,没有实际操作
	 * 1\验证用户输入
	 * 2\验证当前领取票的状态
	 * 3\修改状态
	 */
	public function admin_seller_take(){
		$this->UserAuth->hasPurview('admin_depot_sell_take');

		if($this->request->is('post')){
			$post_data = $this->request->data;
			$ret = $this->DepotHelper->dispatch('export',$post_data);
			list($result,$msg) = $ret;
			if($result){
				$this->succ('出票成功！');
           		$this->redirect($this->referer());
			}else{
				$this->error($msg);
			}
		}

		$this->loadModel('User');
		$users = $this->User->find('list',array(
			'fields'=>array('User.name')
		));

		$conditions = array(
			'DepotLog.action'=>'export',
			'Depot.active>=0',
			'Category.consume_mode'=>'only_one'
		);
		$this->Category->cache = false;
		$this->Category->recursive = -1;
	    $this->paginate = array(
			'fields'=>array('Depot.ticket_no','DepotLog.created','User.name','Category.*'),
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
		$this->set(compact('users','data'));
		$this->set($this->Category->getArr());
	}

	/**
	 * 余票回库
	 *  1\验证用户输入
	 *  2\票的状态为已经出库才能操作
	 *  3\修改状态为回库
	 */
	public function admin_back_depot(){
		$this->UserAuth->hasPurview('admin_depot_return');

		if($this->request->is('post')){
			$post_data = $this->request->data;
			$ret = $this->DepotHelper->dispatch('back_depot',$post_data);
			list($result,$msg) = $ret;
			if($result){
				$this->succ('回库成功！');
           		$this->redirect($this->referer());
			}else{
				$this->error($msg);
			}
		}

		$this->loadModel('User');
		$users = $this->User->find('list',array(
			'fields'=>array('User.name')
		));

		$conditions = array(
			'DepotLog.action'=>'return',
			'Depot.active>=0',
			'Category.consume_mode'=>'only_one'
		);
		$this->Category->cache = false;
		$this->Category->recursive = -1;
	    $this->paginate = array(
			'fields'=>array('Depot.ticket_no','DepotLog.created','User.name','Category.*'),
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
		$this->set(compact('users'));
		$this->set('data',$data);
	}

	/**
	 * 代理商出货明细
	 */
	public function agent_index(){
		$this->UserAuth->hasPurview('agent_order');

		$conditions = array(
			'Category.consume_mode'=>'only_one'
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
        $this->request->data['Order'] = $query;

		$this->Order->cache = false;
	    $this->paginate = array(
			'fields'=>array('Depot.ticket_no','Depot.voucher_total','Depot.ticket_no','Order.*','Category.name','Agent.name','AgentUser.guide_no'),
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
                array(
                    'table' => 'agent_users',
                    'alias' => 'AgentUser',
                    'type' => 'inner',
                    'conditions' => 'Order.buyer_id=AgentUser.id'
                ),
                array(
                    'table' => 'agents',
                    'alias' => 'Agent',
                    'type' => 'inner',
                    'conditions' => 'AgentUser.agent_id=Agent.id'
                ),
			),
			'order'=>'Order.created desc',
			'limit'=>'15',
			'conditions' => $conditions,
			'recursive'=>-1
		);
		$data = $this->paginate('Order');
		$this->set('data',$data);
	}

	/**
	 * 领票统计
	 */
	public function data_index(){
		$this->UserAuth->hasPurview('data_sell_take');
		
		$conditions = array(
			'DepotLog.action'=>'export',
			'Depot.active>=0',
			'Category.consume_mode'=>'only_one'
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
			'fields'=>array('Depot.ticket_no','User.name','Category.*'),
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
