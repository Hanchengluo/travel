<?php 
	echo $this->Html->script('jquery-ui-1.9.2.custom.min');
	echo $this->Html->script('datepicker');
	echo $this->Html->css('jquery-ui');
 ?>
<br>
<div class="row-fluid">
	<div class="span12">
		<?php 
			$form_arr = array(
			    'order' => array(
			        'category_id',
			        'depot_type',  //入库方式
			        'Depot.start_no',
			        'Depot.end_no',
			        'Depot.number',	
			        '_no',
			        'valid_start',
			    ),
			    'lang' => array(
			        'category_id'=>'选择票种',
			        'depot_type'=>'入库方式',
			        '_no'=>'票号',
			        'Depot.start_no'=>'开始号段',
			        'Depot.end_no'=>'结束号段',
			        'Depot.number'=>'入库总数',
			        'Depot.valid_start'=>'自动激活时间',
			    ),
			    'fields' => array(
			        'category_id' => array( 'options' => $categories),
			        'depot_type' => array( 'options' => array('single'=>'单个入库','batch'=>'批量入库')),
			        '_no' => array('default' => '00000' ),
			        'Depot.start_no' => array('default' => '00000' ),
			        'Depot.end_no' => array('default' => '00001' ),
			        'Depot.number' => array('disabled'=>'disabled','default'=>'1'),
			        'Depot.valid_start' => array('type'=>'text','class'=>'datetime none','default'=>date('Y-m-d H:i:s')),
			    ),
			);

			echo $this->QuickForm->quick_build('Depot',$form_arr);
		 ?>
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

		$("#DepotCategoryId").change(function(){
			var depot_category_id = $(this).val();
			var url = '/admin/categories/view/'+depot_category_id;
			$.get(url,{},function(r){
				if(r.inventory_ticket_activation_mode == "set_expired_time"){
					$("#DepotValidStart").parent().parent().show();
				}else{
					$("#DepotValidStart").parent().parent().hide();
				}
			},'json');
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
	datepicker('.datetime');
</script>