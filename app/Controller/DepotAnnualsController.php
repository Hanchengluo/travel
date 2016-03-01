<?php
App::uses('AppController', 'Controller');
/**
 * DepotAnnuals Controller
 *
 * @property DepotAnnual $DepotAnnual
 */
class DepotAnnualsController extends AppController {

	public $uses = array('DepotAnnual','Category','Depot','Order','DepotLog','DepotVoucher');
	
	public $components = array('DepotHelper','DepotOrder');

	/**
	 * 年卡办理
	 * 
	 */
	public function sell_index() {
		$this->UserAuth->hasPurview('sell_year');
		
		$this->DepotAnnual->recursive = 0;
		$conditions = array();
		if($this->request->query['keyword']){
			$conditions[$this->request->query['type'].' like'] = '%'.$this->request->query['keyword'].'%';
			$this->request->data['DepotAnnual'] = $this->request->query;
		}
		$this->paginate = array(
			'conditions'=>$conditions,
			'order'=>'DepotAnnual.id desc',
		);
		$data = $this->paginate('DepotAnnual');
		$this->set('data',$data );
		$this->set($this->DepotAnnual->getArr());
	}


	/**
	 * 年卡查看
	 */
	public function sell_view($id = null) {
		$this->DepotAnnual->id = $id;
		if (!$this->DepotAnnual->exists()) {
			throw new NotFoundException(__('Invalid depot annual'));
		}
		$this->set('depotAnnual', $this->DepotAnnual->read(null, $id));
		$this->set($this->DepotAnnual->getArr());
	}

	/**
	 * 0\写入身份数据
	 * 1\写入库存数据
	 * 2\写入voucher核销数据
	 * 3\跳转确认
	 */
	public function sell_add() {
		$categories = $this->Category->findListByConsumeMode('year');
		$this->set('categories',$categories);
		$conditions = array();
		if($this->request->query['category_id']){
			$conditions = array('id'=>$this->request->query['category_id']);
		}
		$this->request->data = $this->Category->find('first',array(
			'conditions'=>$conditions
		));
		if ($this->request->is('post')) {
			$post_data = $this->request->data;
	 		$category = $this->Category->read(null,$post_data['Category']['id']);
	 		if(!$category){
				throw new NotFoundException("无效票种");
			}
			if($post_data['DepotAnnual']['valid_for'] <= 0){
				$this->error('无效使用年限！');
				$this->redirect($this->referer());
			}

			$post_data['Depot']['end_no'] = 
			$post_data['Depot']['start_no'] = $this->Depot->generateTicketNo();
	 		
	 		//构建$post_data 
	 		$post_data['Depot']['depot_type'] = 'batch';
	 		$post_data['Depot']['category_id'] = $category['Category']['id'];
	 		$post_data['Depot']['valid_start'] = date('Y-m-d H:i:s',time());

	 		$db = $this->DepotAnnual->getDataSource();
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
 				
	 			$depot = $this->Depot->findByTicketNo($post_data['Depot']['end_no']);

	 			$post_data['DepotAnnual']['depot_id'] = $depot['Depot']['id'];
				$this->DepotAnnual->create();
				$depot_annual = $this->DepotAnnual->save($post_data);
	 			if(!$depot_annual){
	 				throw new Exception(print_r($this->DepotAnnual->validationErrors,true),2);
	 			}
	   			$exists = $this->DepotHelper->check_validate($post_data,array('Depot.active=1'));
	 		} catch (Exception $e) {
	            $db->rollback();
	           	$this->error($e->getMessage().' 错误代码'.$e->getCode());
	 		}
 			$db->commit();

	   		$this->Session->write('wait_actived',$exists);
	 		list($result,$msg) = $this->DepotOrder->submit();

	 		if($result){
	 			$this->succ('年卡办理成功！');

	 			//统计个数、价格
	 			$count = $sum = 0;
	 			foreach ($exists as $key => $one) {
	 				$count++;
	 				$sum += $one['Category']['price']*$one['DepotAnnual']['valid_for'];
	 			}
	 			$this->set('data',$exists);
	 			$this->set(compact('count','sum'));
	 		}else{
	 			$this->error($data);
	 			$this->set('data',array());
	 			return ;
	 		}
	 		$this->set($this->Category->getArr());
	 		$this->view = 'order_confirm';
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
 	 * 编辑
 	 */
	public function sell_edit($id = null) {
		$this->DepotAnnual->id = $id;
		$this->DepotAnnual->recursive = 2;
		$this->DepotAnnual->cache = false;
		$depot_annual = $this->DepotAnnual->findById($id);	
		if (!$this->DepotAnnual->exists()) {
			throw new NotFoundException(__('Invalid depot annual'));
		}
		if ($this->request->is('post') || $this->request->is('put')) {
			$post_data = $this->request->data;
			$depot_id = $depot_annual['Depot']['id'];
			foreach ($post_data['DepotVoucher'] as $key => $one) {
				$post_data['DepotVoucher'][$key]['depot_id'] = $depot_id;
				if(!$one['voucher_type'] || !$one['voucher_number']){
					unset($post_data['DepotVoucher'][$key]);
				}
			}
			$db = $this->DepotAnnual->getDataSource();
			$db->begin();
			try {
				if(!$this->DepotAnnual->save($post_data)){
					throw new Exception($this->DepotAnnual->validateErrors, 1);
				}
				$this->DepotVoucher->deleteAll(array('depot_id'=>$depot_id));
				if(!$this->DepotVoucher->saveMany($post_data['DepotVoucher'])){
					throw new Exception($this->DepotAnnual->validateErrors, 1);
				}
			} catch (Exception $e) {
	            $db->rollback();
	           	$this->error($e->getMessage());
	        	return ;
			}
	        $db->commit();
	        $this->succ('办理成功！');
	        $this->redirect(array('action'=>'edit',$id));
		} else {
			$this->request->data['DepotAnnual'] = $depot_annual['DepotAnnual'];
			$this->request->data['DepotVoucher'] = $depot_annual['Depot']['DepotVoucher'];
			$tmp = array();
			foreach ($this->request->data['DepotVoucher'] as $key => $value) {
				$tmp[$value['voucher_type']] = $value;
			}
			$this->request->data['DepotVoucher'] = $tmp;
		}
	}
}
