<?php
App::uses('AppModel', 'Model');
/**
 * DepotStaff Model
 */
class DepotStaff extends AppModel {

	public $displayField = 'id';

	//限制方式：不限，总使用次数，每天限制、每月限制、每年限制
	public $access_mode_arr = array('year'=>'每年限制', 'month'=>'每月限制', 'day'=>'每天限制', 'all'=>'总使用次数', 'noset'=>'不限');
	
	public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！',
            ),
        ),
        'title' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！!',
            ),
        ),
        'card_no' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！!',
            	),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => '系统已存在！',
                'on'   => 'create'
            )
        ),
	);
	
	public function getArr()
	{
		$access_mode_arr = $this->access_mode_arr;
		return compact('access_mode_arr');
	}
	
	public $belongsTo = array(
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

}
