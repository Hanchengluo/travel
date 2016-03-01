<?php
/**
 * OrderFixture
 *
 */
class OrderFixture extends CakeTestFixture {

/**
 * Fields
 *
 * @var array
 */
	public $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 9, 'key' => 'primary'),
		'seller_id' => array('type' => 'integer', 'null' => false, 'default' => null),
		'depot_id' => array('type' => 'integer', 'null' => false, 'default' => '0', 'length' => 8, 'comment' => '入库ID'),
		'created' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 12),
		'active' => array('type' => 'integer', 'null' => false, 'default' => null, 'length' => 1),
		'price' => array('type' => 'float', 'null' => false, 'default' => null, 'length' => '8,2'),
		'indexes' => array(
			'PRIMARY' => array('column' => 'id', 'unique' => 1)
		),
		'tableParameters' => array('charset' => 'utf8', 'collate' => 'utf8_general_ci', 'engine' => 'InnoDB')
	);

/**
 * Records
 *
 * @var array
 */
	public $records = array(
		array(
			'id' => 1,
			'seller_id' => 1,
			'depot_id' => 1,
			'created' => 1,
			'active' => 1,
			'price' => 1
		),
	);

}
