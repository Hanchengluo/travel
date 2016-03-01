<?php
App::uses('AppController', 'Controller');
/**
 * DepotStaffs Controller
 *
 * @property DepotStaff $DepotStaff
 */
class DepotStaffsController extends AppController {

	public $uses = array('DepotStaff','Category','Depot','Order','DepotLog','DepotVoucher');
	
	public $components = array('DepotHelper');

	/**
	 * 工卡办理
	 * 
	 */
	public function admin_index() {
		$this->UserAuth->hasPurview('admin_depot_staff');
		
		$this->DepotStaff->recursive = 0;
		$conditions = array();
		if($this->request->query['keyword']){
			$conditions[$this->request->query['type'].' like'] = '%'.$this->request->query['keyword'].'%';
			$this->request->data['DepotStaff'] = $this->request->query;
		}
		$this->paginate = array(
			'conditions'=>$conditions,
			'order'=>'DepotStaff.id desc',
		);
		$data = $this->paginate('DepotStaff');
		$this->set('data',$data );
		$this->set($this->DepotStaff->getArr());
	}

	/**
	 * 1\判断并添加默认票种
	 * 2\入库
	 * 3\保存员工数据
	 */
	public function admin_add(){	
		$this->set($this->DepotStaff->getArr());
		if($this->request->is('post')){
			$post_data = $this->request->data;
	 		$category = $this->Category->findByConsumeMode('staff_card');
	 		if(!$category){
				$this->Category->create();
				$category = array(
					'name'=>'工卡',
					'consume_mode'=>'staff_card',
					'price'=>0,
				);
				$category = $this->Category->save($category);
			}

			if($post_data['DepotStaff']['valid_for'] <= 0){
				$this->error('无效过期时间！');
				$this->redirect($this->referer());
			}

			$post_data['Depot']['end_no'] = 
			$post_data['Depot']['start_no'] = $this->Depot->generateTicketNo();
	 		
	 		//构建$post_data 
	 		$post_data['Depot']['depot_type'] = 'batch';
	 		$post_data['Depot']['category_id'] = $category['Category']['id'];
	 		$post_data['Depot']['valid_start'] = date('Y-m-d H:i:m',time());
	 		$post_data['Depot']['valid_ends'] = date('Y-m-d H:i:m',strtotime('+ '.$post_data['DepotStaff']['valid_for'].' month'));

	 		$db = $this->DepotStaff->getDataSource();
	 		$db->begin();
	 		try {
 				list($result,$data) = $this->DepotHelper->organize_data($post_data);
	 			if(!$result){
	 				throw new Exception($data, 1);
	 			}else{
	 				$post_data = $data;
	 			}
	 			$this->DepotHelper->_import($post_data);
 				$this->DepotHelper->_export($post_data,false);
 				//手动激活
 				$this->DepotHelper->_active($post_data);
	 			$depot = $this->Depot->findByTicketNo($post_data['Depot']['end_no']);

	 			$post_data['DepotStaff']['depot_id'] = $depot['Depot']['id'];
				$this->DepotStaff->create();
				$depot_staff = $this->DepotStaff->save($post_data);
	 			if(!$depot_staff){
	 				throw new Exception(print_r($this->DepotStaff->validateErrors,true),2);
	 			}
	 		} catch (Exception $e) {
	            $db->rollback();
	           	$this->error($e->getMessage().' 错误代码'.$e->getCode());
	           	$this->redirect($this->referer());
	 		}
 			$db->commit();
 			$this->succ('办理成功！');
	        $this->redirect(array('action'=>'index','admin'=>true));
		}
	}

 	/**
 	 * 编辑
 	 */
	public function admin_edit($id = null) {
		$this->DepotStaff->id = $id;
		$this->DepotStaff->recursive = 2;
		$this->DepotStaff->cache = false;
		$depot_staff = $this->DepotStaff->findById($id);	
		if (!$this->DepotStaff->exists()) {
			throw new NotFoundException(__('Invalid depot annual'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$post_data = $this->request->data;
			$depot_id = $depot_staff['Depot']['id'];
			foreach ($post_data['DepotVoucher'] as $key => $one) {
				$post_data['DepotVoucher'][$key]['depot_id'] = $depot_id;
				if(!$one['voucher_type'] || !$one['voucher_number']){
					unset($post_data['DepotVoucher'][$key]);
				}
			}
			$db = $this->DepotStaff->getDataSource();
			$db->begin();
			try {
				if(!$this->DepotStaff->saveAll($post_data)){
					throw new Exception($this->DepotStaff->validateErrors, 1);
				}
				$this->DepotVoucher->deleteAll(array('depot_id'=>$depot_id));
				if(!$this->DepotVoucher->saveMany($post_data['DepotVoucher'])){
					throw new Exception($this->DepotStaff->validateErrors, 1);
				}
			} catch (Exception $e) {
	            $db->rollback();
	           	$this->error($e->getMessage());
	        	$this->redirect($this->referer());
			}
	        $db->commit();
	        $this->succ('办理成功！');
	        $this->redirect(array('action'=>'edit',$id));
		} else {
			$this->request->data['DepotStaff'] = $depot_staff['DepotStaff'];
			$this->request->data['DepotVoucher'] = $depot_staff['Depot']['DepotVoucher'];
			$this->request->data['Depot'] = $depot_staff['Depot'];
			$tmp = array();
			if(is_array($this->request->data['DepotVoucher'])){
				foreach ($this->request->data['DepotVoucher'] as $key => $value) {
					$tmp[$value['voucher_type']] = $value;
				}
			}
			$this->request->data['DepotVoucher'] = $tmp;
		}
		$this->set($this->DepotStaff->getArr());
	}

}
