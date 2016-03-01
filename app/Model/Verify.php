<?php
App::uses('AppModel', 'Model');

/**
 * Verify Model
 *
 * @property Depot $Depot
 * @property Device $Device
 */
class Verify extends AppModel {

	public $validate = array(
		'depot_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            	'message' => '必须为数字!',
            ),
		),
		'device_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            	'message' => '必须为数字!',
            ),
		)
	);
	
	/**
	 * belongsTo associations
	 *
	 * @var array
	 */
	public $belongsTo = array(
		'Depot' => array(
			'className' => 'Depot',
			'foreignKey' => 'depot_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Device' => array(
			'className' => 'Device',
			'foreignKey' => 'device_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	/**
	 * 统计
	 */
	public function count($conditions = array()){
		$this->recursive = -1;
		$this->cache = false;
		$result = $this->find('first',array(
			'fields'=>array("COUNT(Verify.id) as count"),
			'conditions'=>$conditions
		));
		return $count = $result['0']['count'];
	}
}
