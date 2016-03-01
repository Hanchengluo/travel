<?php
App::uses('AppModel', 'Model');
/**
 * User Model
 *
 */
class User extends AppModel {

	public $active_arr = array('-1'=>'禁用','0'=>'正常');

	public function getArr(){
		$active_arr = $this->active_arr;
		return compact('active_arr');
	}

	public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！',
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => '姓名已存在！',
                'on'   => 'create'
            )
        ),
        'password' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '不能为空！',
            ),
        ),
        'username' => array(
            'notempty' => array(
                'rule' => array('notempty'),
                'message' => '不能为空！',
            ),
            'isUnique' => array(
                'rule' => array('isUnique'),
                'message' => '用户名已存在！',
                'on'   => 'create'
            )
        ),
    );
}
