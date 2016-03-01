<div class="column alin-center">
	<?php echo $this->Form->create('DepotVoucher'); ?>
	<?php echo $this->Form->input('voucher_number',array('label'=>'凭证号')); ?>
	<?php echo $this->Form->submit('核销',array('class'=>'btn btn-success'));; ?>
	<?php echo $this->Form->end(); ?>
</div>