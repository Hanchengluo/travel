<div class="column">
	<div class="row-fluid">
		<div class="span12">
			<table class="table">
				<thead>
					<tr>
						<th>办卡人姓名</th>
						<th>票种名称</th>
						<th>身份证</th>
						<th>手机号</th>
						<th>单价(元)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data as $key => $one): ?>
					<tr>
						<td><?php echo $one['DepotAnnual']['name']; ?></td>
						<td><?php echo $one['Category']['name']; ?></td>
						<td><?php echo $one['DepotAnnual']['card_no']; ?></td>
						<td><?php echo $one['DepotAnnual']['mobile']; ?></td>
						<td><?php echo $one['Category']['price']; ?></td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<?php echo $this->element('pages'); ?>
		</div>
	</div>
	<div class="row-fluid">
		<p>
			<dl class="dl-horizontal">
			  <dt>有效年限:</dt>
			  <dd><?php echo $count; ?>年</dd>
			  <dt>应收金额：</dt>
			  <dd><?php echo $this->Html->formatMoney($sum); ?>元</dd>
			</dl>
		</p>
		<p class="text-center ">
			<a href="javascript:window.history.go(-1)" class="btn">返回</a>
		</p>
	</div>
</div>