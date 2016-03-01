<?php
App::uses('AppModel', 'Model');
/**
 * DepotAnnual Model
 */
class DepotAnnual extends AppModel {

	public $displayField = 'id';

	public $active_arr = array('-1'=>'禁用','0'=>'正常');

	public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！',
            ),
        ),
        'card_no' => array(
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
        'mobile' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！',
            ),
        ),
        'valid_for' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！',
            ),
        ),
	);

	public $belongsTo = array(
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function getArr(){
		$active_arr = $this->active_arr;
		return compact('active_arr');
	}
}
