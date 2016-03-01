<?php
App::uses('AppController', 'Controller');
/**
 * Verifies Controller
 *
 * @property Verify $Verify
 */
class VerifiesController extends AppController {

	public $uses = array('Verify','Depot','DepotVoucher','DepotStaff','Category','DepotLog','Device');

	public $components = array('DepotVerify');

	public $allow = array('device_check');
	/**
	 * 检票记录
	 */
	public function data_index()
	{	
		$paginate_model = 'Verify';

        $conditions = array();
        $query = $this->request->query;
        if($query['keyword']){
            $conditions[$query['type'].' like'] = '%'.$this->request->query['keyword'].'%';
        }
        if($query['start_time']){
            $conditions[$paginate_model.'.created'.' >='] = strtotime($query['start_time']);
        }
        if($query['end_time']){
            $conditions[$paginate_model.'.created'.' <='] = strtotime($query['end_time']);
        }
        $this->request->data['Verify'] = $query;

       	$this->Verify->recursive = -1;
       	$this->paginate = array(
       		'fields'=>array('Category.name','Device.name','Device.type','Verify.created','Verify.id'),
       		'joins'=>array(
	            array(
	                'table' => 'depots',
	                'alias' => 'Depot',
	                'type' => 'inner',
	                'conditions' => array(
	                    'Verify.depot_id = Depot.id'
	                )
	            ),
	            array(
	                'table' => 'categories',
	                'alias' => 'Category',
	                'type' => 'inner',
	                'conditions' => array(
	                    'Depot.category_id = Category.id'
	                )
	            ),	            
	            array(
	                'table' => 'devices',
	                'alias' => 'Device',
	                'type' => 'inner',
	                'conditions' => array(
	                    'Verify.device_id = Device.id'
	                )
	            ),
       		),
       		'conditions'=>$conditions,
       		'order'=>'Verify.id desc',
       		'limit'=>15
       	);
       	$data = $this->paginate();
		$this->set('data',$data);
	}

	/**
	 * 核销
	 * 1\入口应该是具体的凭证号,
	 * 2\找到
	 */
	public function web_check(){
		//测试数据
		$device_sid = 'webtest';
		$voucher_type = 'qrcode';

		if($this->request->is('post')){
			$post_data = $this->request->data;
			if(!$post_data['DepotVoucher']['voucher_number']){
				return;
			}
			list($result,$msg) = $this->DepotVerify->check($post_data['DepotVoucher']['voucher_number'],$device_sid,$voucher_type);
			if($result){
				$this->succ('核销成功！');
			}else{
				$this->error($msg);
			}
		}
	}

	/**
	 * 设备核销接口,需要绑定设备
	 * @param array(
	 *  'device_sid'=>
	 *  'voucher_type'=>
	 *  'voucher_number'=>
	 * )
	 */
	public function device_check(){
		$this->autoRender = false;
		$query = $this->request->query;
		extract($query);
		if(!$query['device_sid']){
			$msg = '设备号不能为空！';
			$this->pop_msg('error',$msg);
		}
		if(!$query['voucher_type']){
			$msg = '凭证类型不能为空！';
			$this->pop_msg('error',$msg);
		}
		if(!$query['voucher_number']){
			$msg = '凭证号不能为空！';
			$this->pop_msg('error',$msg);
		}
		list($result,$msg) = $this->DepotVerify->check($voucher_number,$device_sid,$voucher_type);
		if($result){
			$this->pop_msg('ok');
		}else{
			$this->pop_msg('error',$msg);
		}
	}
}
