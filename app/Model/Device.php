<?php
App::uses('AppModel', 'Model');
/**
 * Device Model
 *
 */
class Device extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	public $type_arr = array('gates'=>'闸机', 'exit'=>'出口', 'seller'=>'销售终端');
	public $active_arr = array('0'=>'正常','-1'=>'锁定');

	public function getArr()
	{
		$type_arr = $this->type_arr;
		$active_arr = $this->active_arr;
		return compact('type_arr','active_arr');
	}

	public $validate = array(
        'device_sid' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！',
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => '系统已存在！',
                'on'   => 'create'
            )
        ),
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！!',
            ),
        ),
	);
}
