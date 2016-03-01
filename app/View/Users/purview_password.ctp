<div class="column">
	<?php echo $this->Form->create('User',array('class'=>'form-horizontal')); ?>
	<div class="row-fluid ">
		<div class="span6">
			<div class="form-section border">
				<?php echo $this->BForm->input('id',array('type'=>'hidden','label'=>false)); ?>
				<?php echo $this->BForm->input('password',array('type'=>'password','label'=>'新密码')); ?>
				<?php echo $this->BForm->input('cpassword',array('type'=>'password','label'=>'重复密码')); ?>
				<?php echo $this->BForm->submit('保存',array('class'=>'btn btn-success')); ?>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>