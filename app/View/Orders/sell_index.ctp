<?php 
	echo $this->Html->script('jquery-ui-1.9.2.custom.min');
	echo $this->Html->script('datepicker');
	echo $this->Html->css('jquery-ui');
 ?>
<div class="left">
	<div class="head-title">
		<h2>售票点：东门售票点A</h2>
	</div>
	<div class="block-content">
		<div class="btn-tool nav nav-tabs" id="myTab">
			<a href="#sell" data-toggle="tab">
			<?php echo $this->Html->image('btn_print.jpg'); ?>
			<a href="#actived" data-toggle="tab">
			<?php echo $this->Html->image('btn_actived.jpg'); ?>
			</a>
		</div>
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="sell">
				<h3 class="column-title">打印出票</h3>
				<div class="form">
					<?php 
						$default_expired_days = $this->request->data['Category']['default_expired_days'];
						$valid_ends = date('Y-m-d',3600*24*$default_expired_days+time());
					?>
					<?php echo $this->Form->create('Category',array('url'=>array('controller'=>'Orders','action'=>'print','sell'=>true))); ?>
					<?php echo $this->Form->input('id',array('options'=>$categories,'label'=>'门票种类')); ?>
					<?php echo $this->Form->input('AgentUser.guide_no',array('type'=>'text','label'=>'导游证','class'=>'span2')); ?>
					<?php echo $this->Form->input('group_ticket',array('disabled'=>'disabled','options'=>$yn_arr,'label'=>'是否时团体票')); ?>
					<?php echo $this->Form->input('price',array('disabled'=>'disabled','type'=>'text','label'=>'门票单价')); ?>
					<?php echo $this->Form->input('valid_start',array('disabled'=>'disabled','type'=>'text','label'=>'生效日期','class'=>'datetime','value'=>date('Y-m-d'))); ?>
					<?php echo $this->Form->input('valid_ends',array('disabled'=>'disabled','type'=>'text','label'=>'有效截止','class'=>'datetime','value'=>$valid_ends)); ?>
					<?php echo $this->Form->input('Depot.number',array('type'=>'text','label'=>'购买张数')); ?>
					<?php echo $this->Form->submit('提交',array('class'=>'btn btn-success','id'=>'print-submit')); ?>
					<?php echo $this->Form->end(); ?>
				</div>
			</div>
			<div class="tab-pane fade none" id="actived">
				<h3 class="column-title">库存票激活</h3>
				<div class="form">
					<?php 
						echo $this->QuickForm->quick_build('Depot', array(
							'form'=>array(
								'class'=>'standard',
								'url'=>array(
									'controller'=>'Orders',
									'action'=>'add',
									'sell'=>true
								)
							),
						    'order' => array(
						        'depot_type',  //操作方式
						        'Depot.start_no',
						        'Depot.end_no',
						        'Depot.number',	
						        '_no',
						    ),
						    'lang' => array(
						        'depot_type'=>'激活方式',
						        '_no'=>'票号',
						        'Depot.start_no'=>'开始号段',
						        'Depot.end_no'=>'结束号段',
						        'Depot.number'=>'号段总数',
						    ),
						    'fields' => array(
						        'depot_type' => array( 'options' => array('single'=>'扫描枪激活','batch'=>'批量激活')),
						        '_no' => array('default' => '00000' ),
						        'Depot.start_no' => array('default' => '00000' ),
						        'Depot.end_no' => array('default' => '00001' ),
						        'Depot.number' => array('disabled'=>'disabled','default'=>'1'),
						    ),
						));
					 ?>		
				<p>请扫描门票二维码或输入门票编号</p>
				</div>
			</div>
		</div>
	</div>
</div>

<!-- 标题右侧有更多等文字信息 -->
<div class="right">
	<div class="head-title">
		<h2>出票记录</h2>
		<a href="#" class="more"></a>
	</div>
	<div class="block-content">
		<?php $test_data = array(
				'ticket_no'=>'123456789',
				'name'=>'测试票中',
				'valid_start'=>'2012-12-11',
				'valid_ends'=>'2012-12-11',
			) 
		?>
		<table class="table">
			<thead>
				<tr>
					<th>序号</th>
					<th>是否团体票</th>
					<th>票种</th>
					<th>门票编号</th>
					<th>单价(元)</th>
					<th>购买张数(张)</th>
					<th>总价(元)</th>
					<th>实际收取(元)</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $key => $one): ?>
				<tr>
					<td><?php echo $one['Order']['id']; ?></td>
					<td><?php echo $yn_arr[$one['Category']['group_ticket']]; ?></td>
					<td><?php echo $one['Category']['name']; ?></td>
					<td><?php echo $one['Depot']['ticket_no']; ?></td>
					<td><?php echo $this->Html->formatMoney($one['Category']['price']); ?></td>
					<td><?php echo $one['Depot']['voucher_total']; ?></td>
					<td><?php echo $this->Html->formatMoney($one['Depot']['voucher_total']*$one['Category']['price']); ?></td>
					<td><?php echo $this->Html->formatMoney($one['Depot']['voucher_total']*$one['Category']['price']); ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<?php echo $this->element('pages'); ?>
	</div>
</div>
<script type="text/javascript">
	$(function(){
		$("#DepotDepotType").change(function(){
			if($(this).val() == 'single'){
				$("#DepotNo").parent().parent().show();
				$("#DepotStartNo").parent().parent().hide();
				$("#DepotEndNo").parent().parent().hide();
				count(1);
			}else{
				$("#DepotNo").parent().parent().hide();
				$("#DepotStartNo").parent().parent().show();
				$("#DepotEndNo").parent().parent().show();
			}
		}).change();

		function count(number_val){
			if(number_val){
				$("#DepotNumber").val(number_val);
				return true;
			}
			var start = parseInt($("#DepotStartNo").val());
			var end = parseInt($("#DepotEndNo").val());
			var number_val = (end - start)+1;
			if(!isNaN(number_val)){
				$("#DepotNumber").val(number_val);
				alert('你输入的号段共有'+number_val+'张！');
				return true;
			}else{
				alert('号段不合法！');
				return false;
			}
		}

		if($('#DepotDepotType').val() != 'single'){
			$("#DepotAdminIndexForm").unbind().bind('submit',function(){
				if(!count()){
					return false;
				}
			});
		}

		/*订单确认*/
		$("#print-submit").bind('click',function(){
			//计算价格
			var price = $("#CategoryPrice").val();
			var number = $("#DepotNumber").val();
			if(number <= 0){
				return false;
			}  
			var sum = (price*number).toFixed(2);

			$("#confirmModal #number").html(number);
			$("#confirmModal #sum").html(sum);
			$("#confirmModal").modal();
			return false;
		});
		$("#CategoryId").change(function(){
			var  category_id = $(this).val();
			location.href = '?category_id='+category_id;
		})
	})
	datepicker('.datetime');
</script>

<!-- Modal -->
<div id="confirmModal" class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">订单确认</h3>
  </div>
  <div class="modal-body">
	<dl class="dl-horizontal text-left view-list">
	  <dt>门票种类</dt>
	  <dd class="text-error"><?php echo $this->request->data['Category']['name']; ?></dd>
	  <dt>是否团体票</dt>
	  <dd class="text-error"><?php echo $yn_arr[$this->request->data['Category']['group_ticket']]; ?></dd>
	  <dt>门票单价</dt>
	  <dd class="text-error"><?php echo $this->Html->formatMoney($this->request->data['Category']['price']); ?>元</dd>
	  <dt>购买张数</dt>
	  <dd class="text-error" id="number">-</dd>
	  <dt>总金额</dt>
	  <dd class="text-error" id="sum">-</dd>
	</dl>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">取消</button>
    <button class="btn btn-primary" onclick="$('#CategorySellIndexForm').submit()">提交</button>
  </div>
</div>