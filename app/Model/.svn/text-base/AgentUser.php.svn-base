<?php
App::uses('AppModel', 'Model');
/**
 * 代理商下面的用户(导游)
 *
 */
class AgentUser extends AppModel {

/**
 * Display field
 *
 * @var string
 */
	public $displayField = 'id';

	public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！',
            ),
        ),
        'guide_no' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空!',
            ),
		   'unique' => array(
		        'rule' => 'isUnique',
		        'required' => 'create',
            	'message' => '已经存在!',
		    ),
        ),
        'idcard_no' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空!',
            ),
		   'unique' => array(
		        'rule' => 'isUnique',
		        'required' => 'create',
            	'message' => '已经存在!',
		    ),
        ),
	);
}
