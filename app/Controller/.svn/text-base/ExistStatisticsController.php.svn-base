<?php
App::uses('AppController', 'Controller');
/**
 * ExistStatistics Controller
 *
 * @property ExistStatistic $ExistStatistic
 */
class ExistStatisticsController extends AppController {


	public function data_index(){

	}
	
	/**
	 * 出口,客户端每个一段时间发过来数据
	 */
	public function exit_log($device_sid,$count){
		$this->autoRender = false;

		$this->loadModel('Device');
		$device = $this->Device->findByDeviceSid($device_sid);
		if(!$device){
			return json_encode(array('0','设备没有找到！'));
		}
		$data = array(
			'date'=>date('Y-m-d H:i:s'),
			'device_id'=>$device['Device']['id'],
			'count'=>$count
		);

		$this->ExistStatistic->create();
		if($this->ExistStatistic->save($data)){
			return json_encode(array(1,''));
		}else{
			return json_encode(array(0,print_r($this->ExistStatistic->validationErrors,true)));
		}
	}
}
