<?php
App::uses('AppModel', 'Model');
/**
 * DepotVoucher Model
 *
 * @property Depot $Depot
 */
class DepotVoucher extends AppModel {

	public $voucher_type = array(
		'barcode'=>'条码',
		'fingerprint'=>'指纹',
		'rfid'=>'RFID',
		'idcard'=>'身份证',
		'qrcode'=>'二维码'
	);

	//The Associations below have been created with all possible keys, those that are not needed can be removed
	public $validate = array(
        'voucher_number' => array(
            'notempty' => array(
                'rule' => array('notempty'),
            	'message' => '不能为空！!',
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

	//生成二维码串号
    public  function generateQrCode() {
        $qrcode = rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999) . rand(1000, 9999);
        if (!$this->findByVoucherNumber($qrcode)){
            return $qrcode;
        }else{
        	return $this->generateQrCode();
        }
    }
}