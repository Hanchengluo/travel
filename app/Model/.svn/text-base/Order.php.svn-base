<?php
App::uses('AppModel', 'Model');
/**
 * Order Model
 *
 * @property Seller $Seller
 * @property Depot $Depot
 */
class Order extends AppModel {

	public $displayField = 'id';

	public $active_arr = array('-2'=>'退钱','-1'=>'退票','0'=>'正常');

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $validate = array(
        'price' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            	'message' => '必须为数字!',
            ),
        ),
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
		)
	);

	/**
	 * 当天统计
	 */
	public function dayStatis($user_id){
		list($start_time,$end_time,$search_date) = $this->get_time_conditions('day');

		$conditions = array(
			'Order.seller_id'=>$user_id
		);
		$conditions['Order.created >='] = $start_time;
		$conditions['Order.created <='] = $end_time;

		$this->recursive = -1;
		$this->cache = false;
		$result = $this->find('first',array(
			'fields'=>array('COUNT(1) as count','SUM(Order.price) as sum'),
			'conditions'=>$conditions,
		));
		return $result[0];
	}
}
