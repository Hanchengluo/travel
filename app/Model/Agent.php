<?php
App::uses('AppModel', 'Model');
/**
 * Agent Model
 *
 */
class Agent extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	//支付模式 预付、信用支付
	public $pay_mode_arr = array('prepaid'=>'预付','credit'=>'信用支付');

	//合作模式
	public $consume_mode_arr = array('rebate'=>'完成任务返点','base_price'=>'底价出票');

	public function getArr()
	{
		$pay_mode_arr = $this->pay_mode_arr;
		$consume_mode_arr = $this->consume_mode_arr;
		return compact('pay_mode_arr','consume_mode_arr');
	}
}
