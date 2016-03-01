<div class="column">
	<div class="row-fluid">
		<div class="span12">
			<?php 
				echo $this->QuickForm->quick_build('AgentUser', array(
				    'order' => array(
				        'name',
				        'idcard_no',
				        'guide_no',
				    ),
				    'lang' => array(
				        'name'=>'姓名',
				        'idcard_no'=>'身份证编号',
				        'guide_no'=>'导游证编号',
				    ),
				    'fields' => array(
				        'id' => array('type' => 'hidden', 'default' => '0' ),
				        'agent_id' => array('type' => 'hidden', 'value' => $agent_id ),
				        'name' => array('type' => 'text'),
				        'idcard_no' => array('type' => 'text'),
				        'guide_no' => array('type' => 'text'),
				        'created' => array('type' => 'hidden','defalut'=>time()),
				    ),
				));
			 ?>
		</div>
	</div>
</div>