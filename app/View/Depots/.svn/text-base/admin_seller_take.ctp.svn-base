<br>
<div class="row-fluid">
	<div class="span4">
		<div class="form">
		<?php 
			echo $this->QuickForm->quick_build('Depot', array(
			    'order' => array(
			        'user_id',
			        'depot_type',  //入库方式
			        'Depot.start_no',
			        'Depot.end_no',
			        'Depot.number',	
			        '_no',
			    ),
			    'lang' => array(
			        'user_id'=>'选择领取人',
			        'depot_type'=>'领取方式',
			        '_no'=>'票号',
			        'Depot.start_no'=>'开始号段',
			        'Depot.end_no'=>'结束号段',
			        'Depot.number'=>'号段总数',
			    ),
			    'fields' => array(
			        'user_id' => array( 'options' => $users),
			        'depot_type' => array( 'options' => array('single'=>'扫描枪领取','batch'=>'批量领取')),
			        '_no' => array('default' => '00000' ),
			        'Depot.start_no' => array('default' => '00000' ),
			        'Depot.end_no' => array('default' => '00001' ),
			        'Depot.number' => array('disabled'=>'disabled','default'=>'1'),
			    ),
			));
		 ?>			

		</div>
	</div>
	<div class="span8">
		<table class="table">
			<thead>
				<tr>
					<th>领票人</th>
					<th>票种名称</th>
					<th>门票编号</th>
					<th>退票支持</th>
					<th>单价(元)</th>
					<th>时间</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $key => $one): ?>
				<tr>
					<td><?php echo $one['User']['name']; ?></td>
					<td><?php echo $one['Category']['name']; ?></td>
					<td><?php echo $one['Depot']['ticket_no']; ?></td>
					<td><?php echo $yn_arr[$one['Category']['support_refund']]; ?></td>
					<td><?php echo $one['Category']['price']; ?></td>
					<td><?php echo date('Y-m-d H:i:s',$one['DepotLog']['created']); ?></td>
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
	})
</script>