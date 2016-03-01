<div class="column">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				echo $this->QuickForm->quick_build('Agent', array(
				    'order' => array(
				        'pay_mode',
				        'name',
				        'discount',
				        'remark',
				    ),
				    'lang' => array(
				        'name'=>'名称',
				        'pay_mode'=>'支付模式',
				        'discount'=>'折扣',
				        'remark'=>'备注',
				    ),
				    'fields' => array(
				        'id' => array('type' => 'hidden', 'default' => '0' ),
				        'name' => array('type' => 'text',),
				        'pay_mode' => array('options' => $pay_mode_arr, 'default' => 'prepaid' ),
				        'discount' => array('type' => 'text',),
				        'remark' => array('type' => 'text',),
				    ),
				));
			 ?>
		</div>
	</div>
</div>