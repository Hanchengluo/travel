<?php
/**
 *  这个组件用来操作入库、出库、回库、作废等逻辑
 * @ln
 */
class DepotHelperComponent extends Component {
    var $components = array(
        'Session'
    );
    var $controller = '';

    public function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    /**
     * 整理数据
     * @return array
     */
    public function organize_data($post_data){
        if (!$post_data['Depot']) {
            $post_data = array(
                'Depot' => $post_data
            );
        }
        if ($post_data['Depot']['depot_type'] == 'batch') {
            $number = intval($post_data['Depot']['end_no'] - $post_data['Depot']['start_no']) + 1;
        } else {
            $post_data['Depot']['start_no'] = $post_data['Depot']['_no'];
            $post_data['Depot']['end_no'] = $post_data['Depot']['_no'];
            $number = 1;
        }
        if ($number <= 0) {
            return array(0,'票号错误！');
        }
        if ($number > 50) {
            return array(0,'每次操作不能大于50张' );
        }
        $post_data['Depot']['number'] = $number;
        return array(1,$post_data);
    }

    /**
     *  @param $action 四种基本操作,入库\领取票\回库\作废
     *  @param $post_data 每个操作需要的数据不同
     *  @param $tra 是否开启事物操作
     */
    public function dispatch($action, $post_data,$transaction = true) {
        $_this = $this->controller;

        list($result,$data) = $this->organize_data($post_data);
        if(!$result){
            return array(0,$data);
        }else{
            $post_data = $data;
        }
        if($transaction){
            $db = $_this->Category->getDataSource();
            $db->begin();
        }
        try {
            switch ($action) {
                case 'import':
                    $exists = $_this->Depot->find('list', array(
                        'fields' => 'Depot.ticket_no',
                        'conditions' => array(
                            'Depot.ticket_no BETWEEN ' . $post_data['Depot']['start_no'] . ' and ' . $post_data['Depot']['end_no']
                        )
                    ));
                    if (!empty($exists)) {
                        $error = '下列票号已经存在:<br >' . join($exists, '<br >');
                        throw new Exception($error,001);
                    }                    
                    $this->_import($post_data);
                    break;
                case 'export':
                    $conditions = array('Depot.active=0');  //必须是入库状态才能出库
                    $this->check_validate($post_data,$conditions);
                    $this->_export($post_data);
                    break;
                case 'back_depot':
                    $conditions = array('Depot.active'=>array('1,2'));  //只有售出和出库状态才能回库
                    $this->check_validate($post_data,$conditions);
                    $this->_back_depot($post_data);
                    break;
                case 'cancel':
                    $conditions = array('Depot.active !=-1');  //只要不是已经作废就能作废
                    $this->check_validate($post_data,$conditions);
                    $this->_cancel($post_data);
                    break;
                default:
                    throw new Exception('请求不能存在!',002);
                    break;
            }
        }
        catch(Exception $e) {
            if($transaction){
                $db->rollback();
            }
            return array(
                0,
                $e->getMessage() . '错误代码' . $e->getCode()
            );
        }
        if($transaction){
            $db->commit();
        }
        return array(
            1,
            ''
        );
    }
 
    /**
     * 导入
     * 
     * @param post_data 
     *  'Depot' = array(
     *   category_id,
     *   user_id, 
     *   start_no
     *   end_no
     *  )
     * 'DepotVoucher'=>array(),其他的核销方式
     */
    public function _import($post_data){
        $_this = $this->controller;

        $category = $_this->Category->read(null, $post_data['Depot']['category_id']);
        if (!$category) {
            throw new Exception("票种错误", 001);
        }

        //记录日志
        $user_id = $_this->UserAuth->getUserId();
        $post_data['Depot']['user_id'];
        $depot_log = $this->log($post_data);
        //二维码生成,构建库存数据
        $data = array();
        for ($i = $post_data['Depot']['start_no']; $i <= $post_data['Depot']['end_no']; $i++) {
            $depot_voucher_item = array(
                array(
                    'voucher_number' => $_this->DepotVoucher->generateQrCode() ,
                    'voucher_type' => 'qrcode'
                )
            );
            //除了默认生成一个Qr码之外还要生成多种核销方式
            if($post_data['DepotVoucher'] && is_array($post_data['DepotVoucher'])){
                foreach ($post_data['DepotVoucher'] as $key => $one) {
                    if($one['voucher_type'] && $one['voucher_number'])
                    $depot_voucher_item[] = array(
                        'voucher_number' => $one['voucher_number'],
                        'voucher_type' => $one['voucher_type'],
                    );
                }
            }
            $ticket_no = str_pad($i, strlen($post_data['Depot']['start_no']) , '0', STR_PAD_LEFT);
            $voucher_total = $post_data['Depot']['voucher_total']?$post_data['Depot']['voucher_total']:1;
            $depot_item = array(
                'category_id' => $category['Category']['id'],
                'ticket_no' => $ticket_no,
                'voucher_total' => $voucher_total,
                'voucher_remaining' => $voucher_total,
                'price' => $category['Category']['price'],
                'create_from_id' => $depot_log['DepotLog']['id'],
                'create_from' => 'import_depot',
                'created' => time() ,
            );
            //如果是自动激活卡还要设置验证时间
            if ($category['Category']['inventory_ticket_activation_mode'] == 'set_expired_time') {
                $depot_item['valid_start'] = $post_data['Depot']['valid_start'];
                $depot_item['valid_ends'] = date('Y-m-d H:i:s', 3600 * 24 * $category['Category']['default_expired_days'] + strtotime($post_data['Depot']['valid_start']));
            }
            $data[] = array(
                'Depot' => $depot_item,
                'DepotVoucher' => $depot_voucher_item
            );
        }
        $result = $_this->Depot->saveAll($data, array(
            'deep' => true
        ));
        if (!$result) {
            throw new Exception("入库数据错误" . print_r($_this->Depot->validateErrors, true) , 003);
        }
    }

    /**
     * 出库(领票)
     * @param $post_data
     * @param $is_log 是否记录日志(有些地方不需要记录日志)
     */
    public function _export($post_data,$is_log = true){
        $_this = $this->controller;

        if($is_log){
            $depot_log = $this->log($post_data, 'export');
        }
        $_this->Depot->updateAll(array(
            'active' => '1'
        ) , array(
            'ticket_no >=' => $post_data['Depot']['start_no'],
            'ticket_no <=' => $post_data['Depot']['end_no'],
        ));
        if ($_this->Depot->getAffectedRows() != $post_data['Depot']['number']) {
            throw new Exception("出库错误", 004);
        }
    }


    /**
     * return 回库
     */
    public function _back_depot($post_data){
        $_this = $this->controller;

        $depot_log = $this->log($post_data,'return');

        $_this->Depot->updateAll(array(
            'active' => '0',
        ) , array(
            'ticket_no >=' => $post_data['Depot']['start_no'],
            'ticket_no <=' => $post_data['Depot']['end_no'],
        ));

        if ($_this->Depot->getAffectedRows() != $post_data['Depot']['number']) {
            throw new Exception("回库错误", 005);
        }
    }

    /**
     * 作废
     * @param 起始票和结束票
     */
    public function _cancel($post_data){
        $_this = $this->controller;

        $depot_log = $this->log($post_data, 'cancel');
        $_this->Depot->updateAll(array(
            'active' => '-1',
            'valid_start' => '"0000-00-00 00:00:00"',
            'valid_ends' => '"0000-00-00 00:00:00"',
        ) , array(
            'ticket_no >=' => $post_data['Depot']['start_no'],
            'ticket_no <=' => $post_data['Depot']['end_no'],
        ));
        if ($_this->Depot->getAffectedRows() != $post_data['Depot']['number']) {
            throw new Exception("作废错误", 006);
        }
    }

    /**
     * 激活票的有效时间 
     * @param 传入有效时间,默认为当前起效，1天有效
     */
    public function _active($post_data){
        $_this = $this->controller;

        if(!$post_data['Depot']['valid_start']){
            $post_data['Depot']['valid_start']= date('Y-m-d H:i:s');
        }
        if(!$post_data['Depot']['valid_ends']){
            $post_data['Depot']['valid_ends']= date('Y-m-d H:i:s',strtotime($post_data['Depot']['valid_start'])+3600*24);
        }

        $_this->Depot->updateAll(array(
            'valid_start' => '"'.$post_data["Depot"]["valid_start"].'"',
            'valid_ends' => '"'.$post_data["Depot"]["valid_ends"].'"',
        ) , array(
            'ticket_no >=' => $post_data['Depot']['start_no'],
            'ticket_no <=' => $post_data['Depot']['end_no'],
        ));
        if ($_this->Depot->getAffectedRows() != $post_data['Depot']['number']) {
            throw new Exception("激活错误", 006);
        }
    }

    /**
     * 日志记录
     * @param 日志数据
     * @param 操作方式
     */
    public function log($post_data, $action = 'import') {
        $_this = $this->controller;

        $log = array(
            'number' => $post_data['Depot']['number'],
            'user_id' => $post_data['Depot']['user_id'] ? $post_data['Depot']['user_id'] : 0,
            'action' => $action,
            'created' => time() ,
            'start_no' => $post_data['Depot']['start_no'],
            'end_no' => $post_data['Depot']['end_no'],
        );
        $_this->DepotLog->create();
        $depot_log = $_this->DepotLog->save($log);
        if (!$depot_log) {
            throw new Exception("日志错误", 007);
        }
        return $depot_log;
    }

    /**
     * 有效性检查
     * 根据开始票号和结束票号码
     * @param 需要验证的数据
     * @param 验证条件
     * @return 返回验证后的有效数据,如果有效数据没有返回为空
     */
    public function check_validate($post_data,$out_conditions = array()){
        $_this = $this->controller;
        
        $abnormal = array(); //无效数据
        $in_effects = array(); //有效数据

        for ($i = $post_data['Depot']['start_no']; $i <= $post_data['Depot']['end_no']; $i++) {
            $ticket_no = str_pad($i, strlen($post_data['Depot']['start_no']) , '0', STR_PAD_LEFT); 
            $_this->Depot->cache = false;
            $conditions_default = array(
                    'Depot.ticket_no' => $ticket_no,
            );

            $conditions = array_merge($conditions_default,$out_conditions);
            $depot = $_this->Depot->find('first', array(
                'conditions' => $conditions
            ));
            if ($depot) {
                $in_effects[] = $depot;
            }else{
                $abnormal[] = $ticket_no;
            }
        }
        if (!empty($abnormal)) {
            throw new Exception(join($abnormal, '<br>') . ' 票号异常，可能状态不符合当前操作或不存在！', 008);
        }
        return $in_effects;
    }
}
?>
