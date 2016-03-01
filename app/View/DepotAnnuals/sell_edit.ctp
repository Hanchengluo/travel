<div class="column">
	<div class="row-fluid">
		<div class="span6">
			<?php echo $this->Form->create('DepotAnnual'); ?>
			<?php echo $this->Form->input('Category.id',array('label'=>'办卡类别','options' => $categories )) ?>
			<?php echo $this->Form->input('id',array('type' => 'hidden', 'default' => '0' )) ?>
			<?php echo $this->Form->input('name',array('label'=>'办卡人姓名','type' => 'text')) ?>
			<?php echo $this->Form->input('card_no',array('label'=>'身份证','type' => 'text')) ?>
			<?php echo $this->Form->input('mobile',array('label'=>'手机号','type' => 'text')) ?>
			<?php echo $this->Form->input('created',array('type' => 'hidden')) ?>
			<?php echo $this->Form->input('updated',array('type' => 'hidden')) ?>
			<?php echo $this->Form->input('valid_for',array('label'=>'有效期限(年)','type' => 'text')) ?>
			<hr>
			<h4>卡类型</h4>
			<?php echo $this->Form->input('DepotVoucher.qrcode.id',array('type'=>'hidden')) ?>
			<?php echo $this->Form->input('DepotVoucher.qrcode.voucher_type',array('label'=>'IC卡','type'=>'hidden','label'=>false,'value'=>'qrcode',)) ?>
			<?php echo $this->Form->input('DepotVoucher.qrcode.voucher_number',array('type'=>'hidden','label'=>false)) ?>

			<?php echo $this->Form->input('DepotVoucher.rfid.id',array('type'=>'hidden')) ?>
			<?php echo $this->Form->input('DepotVoucher.rfid.voucher_type',array('label'=>'IC卡','type'=>'checkbox','value'=>'rfid',)) ?>
			<?php echo $this->Form->input('DepotVoucher.rfid.voucher_number',array('type'=>'text','label'=>false,'after'=>'<a href="">修改</a>')) ?>
			
			<?php echo $this->Form->input('DepotVoucher.idcard.id',array('type'=>'hidden')) ?>
			<?php echo $this->Form->input('DepotVoucher.idcard.voucher_type',array('label'=>'身份证','type'=>'checkbox','value'=>'idcard')) ?>
			<?php echo $this->Form->input('DepotVoucher.idcard.voucher_number',array('type'=>'text','label'=>false,'after'=>'<a href="">修改</a>')) ?>
			
			<?php echo $this->Form->input('DepotVoucher.fingerprint.id',array('type'=>'hidden')) ?>
			<?php echo $this->Form->input('DepotVoucher.fingerprint.voucher_type',array('label'=>'指纹','type'=>'checkbox','value'=>'fingerprint')) ?>
			<?php echo $this->Form->input('DepotVoucher.fingerprint.voucher_number',array('type'=>'text','label'=>false,'after'=>'<a href="">修改</a>')) ?>
			<?php echo $this->Form->submit('下一步',array('class'=>'btn btn-sucess')); ?>
			<?php echo $this->Form->end(); ?>
		</div>
		<div class="span6">
			<h2>身份证</h2>
			<div class="car_perview" style="width:200px;height:150px;border:1px solid #ccc;">

			</div>
			<div class="btn_group">
				<a href="" class="btn">保存</a>
				<a href="" class="btn">重新扫描</a>
			</div>
		</div>
	</div>
</div>
	
