<div class="column">
	<div class="row-fluid">
		<div class="span6">
			<?php echo $this->Form->create('DepotAnnual'); ?>
			<?php echo $this->Form->input('Category.id',array('label'=>'办卡类别','options' => $categories )) ?>
			<?php echo $this->Form->input('Category.price',array('type'=>'hidden')); ?>
			<?php echo $this->Form->input('id',array('type' => 'hidden', 'default' => '0' )) ?>
			<?php echo $this->Form->input('name',array('label'=>'办卡人姓名','type' => 'text')) ?>
			<?php echo $this->Form->input('card_no',array('label'=>'身份证','type' => 'text')) ?>
			<?php echo $this->Form->input('mobile',array('label'=>'手机号','type' => 'text')) ?>
			<?php echo $this->Form->input('created',array('type' => 'hidden')) ?>
			<?php echo $this->Form->input('updated',array('type' => 'hidden')) ?>
			<?php echo $this->Form->input('valid_for',array('label'=>'有效期限(年)','type' => 'text','default'=>'1')) ?>
			<hr>
			<h4>卡类型</h4>
			<?php echo $this->Form->input('DepotVoucher.0.voucher_type',array('label'=>'IC卡','type'=>'checkbox','value'=>'rfid',)) ?>
			<?php echo $this->Form->input('DepotVoucher.0.voucher_number',array('type'=>'text','label'=>false,'after'=>'<a href="">登记</a>')) ?>
			
			<?php echo $this->Form->input('DepotVoucher.1.voucher_type',array('label'=>'身份证','type'=>'checkbox','value'=>'idcard')) ?>
			<?php echo $this->Form->input('DepotVoucher.1.voucher_number',array('type'=>'text','label'=>false,'after'=>'<a href="">登记</a>')) ?>
			
			<?php echo $this->Form->input('DepotVoucher.2.voucher_type',array('label'=>'指纹','type'=>'checkbox','value'=>'fingerprint')) ?>
			<?php echo $this->Form->input('DepotVoucher.2.voucher_number',array('type'=>'text','label'=>false,'after'=>'<a href="">登记</a>')) ?>
			<?php echo $this->Form->submit('下一步',array('class'=>'btn btn-sucess','id'=>'annual-submit')); ?>
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

<script type="text/javascript">
	/*订单确认*/
	$("#annual-submit").bind('click',function(){
		var name  = $("#DepotAnnualName").val();
		var card_no  = $("#DepotAnnualCardNo").val();
		var mobile  = $("#DepotAnnualMobile").val();
		var valid_for  = $("#DepotAnnualValidFor").val();

		//计算价格
		var price = $("#CategoryPrice").val();
		if(valid_for <= 0){
			alert('年限不能小于1年');
			return false;
		}  
		var sum = (price*valid_for).toFixed(2);

		$("#confirmModal #valid_for").html(valid_for);
		$("#confirmModal #sum").html(sum);
		$("#confirmModal").modal();
		return false;
	});

	$("#CategoryId").change(function(){
		var  category_id = $(this).val();
		location.href = '?category_id='+category_id;
	})
</script>

<!-- Modal -->
<div id="confirmModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">请认真核对办卡人信息！</h3>
  </div>
  <div class="modal-body">
	<dl class="dl-horizontal text-left view-list">
	  <dt>办卡人姓名</dt>
	  <dd class="text-error">-</dd>
	  <dt>身份证</dt>
	  <dd class="text-error">-</dd>
	  <dt>电话</dt>
	  <dd class="text-error">-</dd>
	  <dt>有效年限</dt>
	  <dd class="text-error" id="valid_for">-</dd>
	  <dt>总金额</dt>
	  <dd class="text-error" id="sum">-</dd>
	</dl>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
    <button class="btn btn-primary" onclick="$('#DepotAnnualSellAddForm').submit()">提交</button>
  </div>
</div>
