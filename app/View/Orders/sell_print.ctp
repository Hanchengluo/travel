<?php 
	$print_arr = array();
	foreach ($data as $key => $one) {
		$print_arr[] = array(
			'name'=>$one['Category']['name'],
			'valid_start'=>$one['Depot']['valid_start'],
			'valid_ends'=>$one['Depot']['valid_ends'],
			'ticket_no'=>$one['Depot']['ticket_no'],
			'qrcode'=>$one['DepotVoucher'][0]['voucher_number'],
		);
	}
	$print_json = json_encode($print_arr);
 ?>
<script type="text/javascript">	
	var print_content = <?php echo  $print_json; ?>;
	console.log(print_content);
</script>
<div class="column">
	<div class="row-fluid">
		<div class="span12">
			<table class="table">
				<thead>
					<tr>
						<th>门票编号</th>
						<th>票种名称</th>
						<th>是否团体票</th>
						<th>退票支持</th>
						<th>单价(元)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data as $key => $one): ?>
					<tr>
						<td><?php echo $one['Depot']['ticket_no']; ?></td>
						<td><?php echo $one['Category']['name']; ?></td>
						<td><?php echo $yn_arr[$one['Category']['group_ticket']]; ?></td>
						<td><?php echo $yn_arr[$one['Category']['support_refund']]; ?></td>
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
			  <dt>共计:</dt>
			  <dd><?php echo $count; ?> 张</dd>
			  <dt>应收金额：</dt>
			  <dd><?php echo $this->Html->formatMoney($sum); ?>元</dd>
			</dl>
		</p>
		<p class="text-center ">
			<button class="btn btn-success" onlick="jsTest.print(print_content)">打印</button>
			<a href="javascript:window.history.go(-1)" class="btn">返回</a>
		</p>
	</div>
</div>