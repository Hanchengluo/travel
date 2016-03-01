<?php
/**
 * 核销,支持通过多种方式进行核销
 * @ln 
 */
class DepotVerifyComponent extends Component {
    var $components = array(
        'Session',
        'DepotHelper'
    );

    var $device = ''; //设备号
    var $depot = null; //票数据
    var $controller = '';

    public function initialize(Controller $controller) {
        $this->controller = $controller;
    }

    /**
     * @param 凭证号码
     * @param 设备号码
     * @param 凭证类型,默认为qrcode
     * 1\验证是否可以核销
     * 2\记录核销数据
     */
    public function check($voucher_number, $device_sid,$voucher_type = 'qrcode') {
        $_this = $this->controller;
        $this->Depot->recursive = 3;
        $this->Depot->cache = false;
        $depot = $_this->Depot->find('first', array(
            'conditions' => array(
                'DepotVoucher.voucher_number' => $voucher_number,
                'DepotVoucher.voucher_type' => $voucher_type
            ) ,
            'joins' => array(
                array(
                    'table' => 'depot_vouchers',
                    'alias' => 'DepotVoucher',
                    'type' => 'inner',
                    'conditions' => 'DepotVoucher.depot_id=Depot.id'
                ) ,
            )
        ));
        if (!$depot) {
            return array(
                0,
                '票号不存在'
            );
        } else {
            $this->depot = $depot;
        }
        $device = $_this->Device->findByDeviceSid($device_sid);
        if (!$device) {
            return array(
                0,
                '设备号不存在'
            );
        } else {
            $this->device = $device;
        }
        //验证有效期
        $current = date('Y-m-d H:i:s');
        if ($depot['Depot']['valid_start'] > $current || $depot['Depot']['valid_ends'] < $current) {
            return array(
                0,
                '票号已经过期'
            );
        }
        //判断使用方式
        $consume_mode = $depot['Category']['consume_mode'];
        switch ($consume_mode) {
            case 'only_one':
                return $this->check_only_one($depot, $device_sid);
                break;

            case 'year':
                return $this->check_year();
                break;

            case 'staff_card':
                return $this->check_staff_card();
                break;

            default:
                return array(
                    '0',
                    '无效消费模式'
                );
                break;
        }
        exit();
    }

    /**
     * 次卡核销
     * 1\检查可用次数
     */
    private function check_only_one() {
        $_this = $this->controller;
        //验证剩余次数
        if ($this->depot['Depot']['voucher_remaining'] <= 0) {
            return array(
                0,
                '已经消费完,无法继续使用'
            );
        }
        //开始核销
        $db = $_this->Depot->getDataSource();
        $db->begin();
        try {
            $_this->Depot->id = $this->depot['Depot']['id'];
            if (!$_this->Depot->saveField('voucher_remaining', $this->depot['Depot']['voucher_remaining'] - 1)) {
                throw new Exception("核销错误", 1);
            }
            $this->log();
        }
        catch(Exception $e) {
            $db->rollback();
            return array(
                0,
                $e->getMessage() . ' 错误代码' . $e->getCode()
            );
        }
        $db->commit();
        return array(
            1,
            ''
        );
    }

    /**
     * 年卡核销
     * 生成核销记录
     */
    private function check_year() {
        $_this = $this->controller;

        $this->log();
    }


    /**
     * 工卡核销
     * 检查限制模式和限制次数
     * 1\生成时间范围
     * 1\统计时间次数
     */
    private function check_staff_card() {
        $_this = $this->controller;

        $access_mode = $this->depot['DepotStaff']['access_mode'];
        $access_number = $this->depot['DepotStaff']['access_number'];
        $depot_id = $this->depot['Depot']['id'];
        $checked_count = 0;

        switch ($access_mode) {
            case 'noset':
                $checked_count = 0;
                break;
            case 'day':
                list($start_time,$end_time,$search_date) = $this->get_time_conditions('day');
                $conditions = array(
                    'Verify.depot_id'=>$depot_id,
                    'Verify.created >='=>$start_time,
                    'Verify.created <='=>$end_time,
                );
                $checked_count = $_this->Verify->count($conditions);
                break;
            case 'month':
                list($start_time,$end_time,$search_date) = $this->get_time_conditions('month');
                $conditions = array(
                    'Verify.depot_id'=>$depot_id,
                    'Verify.created >='=>$start_time,
                    'Verify.created <='=>$end_time,
                );
                $checked_count = $_this->Verify->count($conditions);
                break;    
            case 'year':
                list($start_time,$end_time,$search_date) = $this->get_time_conditions('year');
                $conditions = array(
                    'Verify.depot_id'=>$depot_id,
                    'Verify.created >='=>$start_time,
                    'Verify.created <='=>$end_time,
                );
                $checked_count = $_this->Verify->count($conditions);
                break;
            case 'all':
                $conditions = array(
                    'Verify.depot_id'=>$depot_id,
                );
                $checked_count = $_this->Verify->count($conditions);
                break;
            default:
                return array(0,'消费模式错误！无法核销');
                break;
        }

        if(($access_mode != 'noset') && ($checked_count >= $access_number)){
            $access_mode_arr = $_this->DepotStaff->access_mode_arr;
            return array(0,'你在指定时间内验证次数超过限制！'.'限制模式:'.$access_mode_arr[$access_mode]);
        }
        $this->log();
        return array(1,'');
    }


    /**
     * 日志记录
     */
    public function log() {
        $_this = $this->controller;
        $_this->Verify->create();
        $data = array(
            'depot_id' => $this->depot['Depot']['id'],
            'device_id' => $this->device['Device']['id'],
            'created' => time() ,
        );
        if (!$_this->Verify->save($data)) {
            throw new Exception($_this->Verify->validationErrors, 1);
        }
    }

    /**
     * 日期范围
     *
     * @author LinYang
     * @param int  $days
     * @return array
     */
    private function get_time_conditions($days) {
        $start_time = date('Y-m-d') . ' 00:00:00';
        $end_time = date('Y-m-d H:i:s');
        $search_date = '今天';
        switch ($days) {
            case 'day':
                $start_time = date('Y-m-d') . ' 00:00:00';
                $end_time = date('Y-m-d H:i:s');
                break;
            case 'last_day':
                $start_time = date('Y-m-d', strtotime('-1 day')) . ' 00:00:00';
                $end_time = date('Y-m-d') . ' 00:00:00';
                $search_date = '至昨天';
                break;
            case 'week':
                $start_time = date('Y-m-d', strtotime('-7 days')) . ' 00:00:00';
                $end_time = date('Y-m-d H:i:s');
                $search_date = '本周';
                break;
            case 'month':
                $start_time = date('Y-m-d', mktime(0, 0, 0, date("m"), 1, date("Y")));
                $end_time = date('Y-m-d H:i:s');
                $search_date = '本月';
                break;
            case 'year':
                $start_time = date('Y-m-d', mktime(0, 0, 0, 1, 1, date("Y")));
                $end_time = date('Y-m-d H:i:s');
                $search_date = '本年';
                break;
            default :
                $start_time = date('Y-m-d') . ' 00:00:00';
                $end_time = date('Y-m-d H:i:s');
        }
        $start_time = strtotime($start_time);
        $end_time = strtotime($end_time);
        return array($start_time, $end_time, $search_date);
    }

}
?>
