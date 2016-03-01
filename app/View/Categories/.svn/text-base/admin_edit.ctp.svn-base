<div class="column">
	<div class="row-fluid">
		<div class="span6">
			<?php 
				//工卡不再此处办理
				unset($consume_mode_arr['staff_card']);
				echo $this->QuickForm->quick_build('Category', array(
				    'order' => array(
				        'name',
				        'consume_mode',
				        'group_ticket',
				        'support_refund',
				        'refund_ratio',
				        'refund_after_be_invalid',
				        'default_expired_days',
				        'price',
				        'inventory_ticket_activation_mode',
				    ),
				    'lang' => array(
				        'name'=>'名称',
				        'consume_mode'=>'消费方式',
				        'group_ticket'=>'是否是团体票',
				        'support_refund'=>'是否允许退款',
				        'refund_ratio'=>'退款比例',
				        'refund_after_be_invalid'=>'退款后作废',
				        'default_expired_days'=>'默认过期时间',
				        'price'=>'价格',
				        'inventory_ticket_activation_mode'=>'激活方式',
				    ),
				    'fields' => array(
				        'id' => array('type' => 'hidden', 'default' => '0' ),
				        'consume_mode' => array('options'=>$consume_mode_arr,'default' => 'only_one' ),
				        'group_ticket' => array('options' => $yn_arr, 'default' => 'n' ),
				        'refund_ratio' => array('after'=>'%'),
				        'support_refund' => array('options' => $yn_arr, 'default' => 'n' ),
				        'refund_after_be_invalid' => array('options' => $yn_arr, 'default' => 'n' ),
				        'default_expired_days' => array('after'=>'天'),
				        'inventory_ticket_activation_mode' => array('options'=>$inventory_ticket_activation_mode_arr,'default'=>'after_sell'),
				    ),
				));
			 ?>
		</div>
	</div>
</div>