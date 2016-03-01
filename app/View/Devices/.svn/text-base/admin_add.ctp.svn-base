<div class="column">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				echo $this->QuickForm->quick_build('Device', array(
				    'order' => array(
				        'device_sid',
				        'name',
				        'type',
				    ),
				    'lang' => array(
				        'device_sid'=>'设备号码',
				        'name'=>'设备名称',
				        'type'=>'类型',
				    ),
				    'fields' => array(
				        'id' => array('type' => 'hidden', 'default' => '0' ),
				        'name' => array('type' => 'text',),
				        'type' => array('options' => $type_arr, 'default' => 'noset' ),
				    ),
				));
			 ?>
		</div>
	</div>
</div>