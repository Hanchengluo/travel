<?php
/**
 * 用来处理生成、退票
 * @ln
 */
class DepotOrderComponent extends Component
{
    var $components = array('Session', 'DepotHelper');
    var $controller = '';
    
    public function initialize(Controller $controller)
    {
        $this->controller = $controller;
    }
    
    /**
     * 提交订单
     * 1\从购物车中获取待处理数据
     * 2\生成订单
     * 3\修改库存状态
     * 4\激活票(修改有效时间)
     * 5\记录售出日志
     */
    public function submit()
    {
        $_this = $this->controller;
        
        $exists = $_this->Session->read('wait_actived');
        $agent_user = $_this->Session->read('agent_user');

        if (!$exists) {
            return array(
                0,
                '错误请求'
            );
        }
        //订单生成
        $db = $_this->Order->getDataSource();
        $db->begin();
        try {
            $user_id       = $_this->UserAuth->getUserId();
            $order_data    = array();
            $ticket_no_arr = array();
            foreach ($exists as $key => $one) {
                $buyer_id = $agent_user['AgentUser']['id'];
                $buyer_id = $buyer_id?$buyer_id:0;
                
                $order_data[]     = array(
                    'buyer_id'=> $buyer_id,
                    'seller_id' => $user_id,
                    'depot_id' => $one['Depot']['id'],
                    'created' => time(),
                    'price' => $one['Category']['price'] * $one['Depot']['voucher_total']
                );
                $ticket_no_arr[]  = $one['Depot']['ticket_no'];
                //激活当前
                $_this->Depot->id = $one['Depot']['id'];
                $_this->Depot->read();
                if ($one['Category']['inventory_ticket_activation_mode'] == 'after_sell') {
                    $valid_ends = date('Y-m-d H:i:s', time() + 3600 * 24 * $one['Category']['default_expired_days']);
                    $_this->Depot->set('valid_start', date('Y-m-d H:i:s'));
                    $_this->Depot->set('valid_ends', $valid_ends);
                }
                //如果是年卡，按照年卡的方式激活
                if ($one['Category']['consume_mode'] == 'year') {
                    $valid_ends = date('Y-m-d H:i:s', time() + 3600 * 24 * 365 * $one['DepotAnnual']['valid_for']);
                    $_this->Depot->set('valid_start', date('Y-m-d H:i:s'));
                    $_this->Depot->set('valid_ends', $valid_ends);
                }
                $_this->Depot->set('active', 2);
                if (!$_this->Depot->save()) {
                    throw new Exception("库存状态修改错误", 22);
                }
            }
            $order_result = $_this->Order->saveMany($order_data);
            if (!$order_result) {
                throw new Exception("订单生成错误！", 21);
            }
        }
        catch (Exception $e) {
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
     * 退票
     * 1\找到需要退的票
     * 2\验证是否可以退票
     * 3\更具选择的退票方式,重新入库或者作废即可
     */
    public function refund($order)
    {
        $_this = $this->controller;
        
        $db = $_this->Order->getDataSource();
        $db->begin();
        try {
            $ticket_no = $order['Depot']['ticket_no'];
            $post_data = array(
                'Depot' => array(
                    '_no' => $ticket_no,
                    'depot_type' => 'simple',
                )
            );
            list(,$post_data) = $this->DepotHelper->organize_data($post_data);
            
            $this->cancel($order['Order']['id']);
            if ($order['Depot']['Category']['refund_after_be_invalid'] == 'y') {
                //作废
                $ret = $this->DepotHelper->_cancel($post_data);
            } else {
                //回库
                $ret = $this->DepotHelper->_back_depot($post_data);
            }
        }
        catch (Exception $e) {
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
     * 作废订单
     * @param 只是作废订单，还需要选择回库或者作废
     */
    public function cancel($order_id)
    {
        $_this            = $this->controller;

        $_this->Order->id = $order_id;
        $order_result     = $_this->Order->saveField('active', -1); //作废订单
        if (!$order_result) {
            throw new Exception("订单作废失败", 2);
        }
    }
}
?>