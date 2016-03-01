<?php
App::uses('AppModel', 'Model');
/**
 * Depot Model
 *
 * @property Category $Category
 * @property DepotStaff $DepotStaff
 * @property DepotVoucher $DepotVoucher
 * @property Order $Order
 * @property Verify $Verify
 */
class Depot extends AppModel {

	//商品的状态
	public $active_arr = array('-1'=>'作废','0'=>'仓储','1'=>'上架','2'=>'售出');

	public $create_from_arr = array('www_seller'=>'web方式入库', 'window_seller'=>'客户端方式', 'import_depot'=>'导入方式');
	
	public function getArr(){
		$active_arr = $this->active_arr;
		$yn_arr = $this->yn_arr;
		return compact('active_arr','yn_arr');
	}

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $validate = array(
        'category_id' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            	'message' => '必须为数字',
            ),
        ),
        'ticket_no' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！!',
            ),
        ),
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
		'Category' => array(
			'className' => 'Category',
			'foreignKey' => 'category_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	public $hasOne = array(
		//工卡拓展
		'DepotStaff' => array(
			'className' => 'DepotStaff',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),

		//年卡拓展
		'DepotAnnual' => array(
			'className' => 'DepotAnnual',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
	);

	/**
	 * hasMany associations
	 *
	 * @var array
	 */
	public $hasMany = array(
		//一张票可以由多种核销途径
		'DepotVoucher' => array(
			'className' => 'DepotVoucher',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),

		//一张票可以被多次销售
		'Order' => array(
			'className' => 'Order',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),

		//一张票可以被多次验证
		'Verify' => array(
			'className' => 'Verify',
			'foreignKey' => 'depot_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		)
	);

	//生成票号码
    public  function generateTicketNo(){
        $ticket_no = time();
        if (!$this->findByTicketNo($ticket_no)){
            return $ticket_no;
        }else{
        	return $this->generateTicketNo();
        }
    }
}
