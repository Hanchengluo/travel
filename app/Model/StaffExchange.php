<?php
App::uses('AppModel', 'Model');
/**
 * StaffExchange Model
 *
 * @property User $User
 */
class StaffExchange extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	public $action_arr = array('login'=>'登陆','logout'=>'退出');

	//The Associations below have been created with all possible keys, those that are not needed can be removed

/**
 * belongsTo associations
 *
 * @var array
 */
	public $belongsTo = array(
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	public function getArr(){
		$action_arr = $this->action_arr;
		return compact('action_arr');
	}
}
