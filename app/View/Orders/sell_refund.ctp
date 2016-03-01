<?php 
	echo $this->Html->script('jquery-ui-1.9.2.custom.min');
	echo $this->Html->script('datepicker');
	echo $this->Html->css('jquery-ui');
 ?>
<div class="left">
	<div class="head-title">
		<h2>售票点：东门售票点A</h2>
		<div class="form">
	        <?php
		        echo $this->Form->create('Order',array('type' => 'get','class'=>'inline'));
		        echo $this->Form->input('ticket_no', array(
			        'label' => false,
			        'div' => false,
			        'class' => 'input-small',
			        ));	
		        echo $this->Form->button('搜索',array('class'=>'btn'));
		        echo $this->Form->end();
	        ?>
			<p><small>*请扫描门票二维码或输入门票编号</small></p>
		</div>
	</div>
	<hr>
	<div class="block-content">
		<?php if ($this->request->data['Category']): ?>
			<div class="form">
				<?php 
					$form_data = $this->request->data;
					$refund_price = $form_data['Order']['price']*($form_data['Category']['refund_ratio']/100);
				 ?>
				<?php echo $this->Form->create('Category') ?>
				<?php echo $this->Form->input('Order.id',array('type'=>'hidden')); ?>
				<?php echo $this->Form->input('name',array('type'=>'text','disabled'=>'disabled','label'=>'门票种类')); ?>
				<?php echo $this->Form->input('group_ticket',array('disabled'=>'disabled','options'=>$yn_arr,'label'=>'是否是团体票')); ?>
				<?php echo $this->Form->input('Order.price',array('disabled'=>'disabled','type'=>'text','label'=>'购票金额')); ?>
				<?php echo $this->Form->input('Order.refund_price',array('disabled'=>'disabled','type'=>'text','label'=>'退款金额','value'=>$this->Html->formatMoney($refund_price))); ?>
				<?php echo $this->Form->input('Category.support_refund',array('disabled'=>'disabled','options'=>$yn_arr,'label'=>'是否允许退票')); ?>
				<?php echo $this->Form->input('refund_type',array('disabled'=>'disabled','options'=>array('n'=>'重新回库','y'=>'作废此票'),'label'=>'退票操作')); ?>
				<?php if ($form_data['Category']['support_refund'] == 'y'): ?>
					<?php echo $this->Form->submit('确认退票',array('class'=>'btn btn-primary')); ?>
				<?php endif ?>
				<?php echo $this->Form->end(); ?>
			</div>
		<?php endif ?>
	</div>
</div>

<!-- 标题右侧有更多等文字信息 -->
<div class="right">
	<div class="head-title">
		<h2>退票记录</h2>
		<a href="#" class="more"></a>
	</div>
	<div class="block-content">
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
					<th>折价(元)</th>
					<th>实际收取(元)</th>
					<th>时间</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $key => $one): ?>
				<?php 
					$sum_price = $one['Depot']['voucher_total']*$one['Category']['price'];
					$refund_price = $one['Depot']['voucher_total']*$one['Category']['price']*($one['Category']['refund_ratio']/100);
				 ?>
				<tr>
					<td><?php echo $one['Order']['id']; ?></td>
					<td><?php echo $yn_arr[$one['Category']['group_ticket']]; ?></td>
					<td><?php echo $one['Category']['name']; ?></td>
					<td><?php echo $one['Depot']['ticket_no']; ?></td>
					<td><?php echo $this->Html->formatMoney($one['Category']['price']); ?></td>
					<td><?php echo $one['Depot']['voucher_total']; ?></td>
					<td><?php echo $this->Html->formatMoney($one['Order']['price']); ?></td>
					<td><?php echo $this->Html->formatMoney($refund_price); ?></td>
					<td><?php echo $this->Html->formatMoney($refund_price); ?></td>
					<td><?php echo date('Y-m-d H:i:s',$one['Order']['updated']); ?></td>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
		<?php echo $this->element('pages'); ?>
	</div>
</div>