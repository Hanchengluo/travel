<?php
App::uses('AppModel', 'Model');
/**
 * Category Model
 *
 */
class Category extends AppModel {

    /**
     * Display field
     *
     * @var string
     */
	public $displayField = 'id';
		
	//卡类型
	public $consume_mode_arr = array('only_one'=>'普通卡','year'=>'年卡','staff_card'=>'工卡');
	//
	public $active_arr = array('0'=>'正常');

	public $inventory_ticket_activation_mode_arr = array('set_expired_time'=>'设置自动激活时间','after_sell'=>'销售后激活');
		

	public $validate = array(
        'name' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '名称不能为空！',
            ),
        ),
        'refund_ratio' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            	'message' => '必须为数字!',
            ),
            'range' => array(
                'rule'    => array('range', 0, 100),
                'message' => '范围为0-100之间!',
            )
        ),
        'default_expired_days' => array(
            'numeric' => array(
                'rule' => array('numeric'),
            	'message' => '必须为数字!',
            ),
        ),
        'price' => array(
            'notempty' => array(
                'rule' => array('decimal', 2),
            	'message' => '请输入有效的金钱格式!',
            ),
        ),
	);

    /**
     * 关联
     */
    public $hasMany = array(
        'Depot' => array(
            'className' => 'Depot',
            'foreignKey' => 'category_id',
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

	public function getArr(){
		$yn_arr = $this->yn_arr;
		$consume_mode_arr = $this->consume_mode_arr;
		$active_arr = $this->active_arr;
		$inventory_ticket_activation_mode_arr = $this->inventory_ticket_activation_mode_arr;
		return compact('consume_mode_arr','active_arr','inventory_ticket_activation_mode_arr','yn_arr');
	}


    public function findListByConsumeMode($type = ''){
        $conditions = array('Category.active>=0');
        if($type){
            $conditions['Category.consume_mode'] = $type;
        }
        $data = $this->find('list',array(
            'fields'=>'Category.name',
            'conditions'=>$conditions,
            'order'=>'Category.id desc'
        ));
        return $data;
    }
}
