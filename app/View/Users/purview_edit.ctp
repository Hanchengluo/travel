<div class="column">
	<?php echo $this->Form->create('User',array('class'=>'form-horizontal')); ?>
	<div class="row-fluid ">
		<div class="span6">
			<div class="form-section border">
				<?php echo $this->BForm->input('id',array('type'=>'hidden','label'=>false)); ?>
				<?php echo $this->BForm->input('name',array('label'=>'姓名')); ?>
				<?php echo $this->BForm->input('title',array('label'=>'职位')); ?>
				<?php echo $this->BForm->input('group_id',array('label'=>'用户组','options'=>$group_arr)); ?>
			</div>
		</div>
		<div class="span6">
			<div class="row-fluid">
			<?php $i = 0; ?>
			<?php foreach ($user_access_arr as $key => $value): ?>
				<div class="span3">
					<dl class="check_group">
						<dt class="check_group_head">
							<?php echo $this->Form->input(''.$value['id'],array('type'=>'checkbox','value'=>$value['id'],'hiddenField'=>false,'label'=>'<b>'.$value['name'].'</b>')) ?>
							<hr>
						</dt>
						<dd class="sub_check_group">
							<?php foreach ($value['childs'] as $key => $sub_value): ?>
									<?php if (in_array($sub_value['id'],$user_access_data)): ?>
										<?php echo $this->Form->input('feature.'.$sub_value['id'],array('type'=>'checkbox','checked'=>'true','value'=>$sub_value['id'],'hiddenField'=>false,'label'=>$sub_value['name'])) ?>
									<?php else: ?>
										<?php echo $this->Form->input('feature.'.$sub_value['id'],array('type'=>'checkbox','value'=>$sub_value['id'],'hiddenField'=>false,'label'=>$sub_value['name'])) ?>
									<?php endif; ?>
							<?php endforeach ?>				
						</dd>
					</dl>
				</div>
				<?php $i++; ?>
				<?php if ($i%3 == 0): ?>
					</div><div class="row-fluid">
				<?php endif ?>
			<?php endforeach ?>
			</div>
			<div class="row-fluid">
				<hr>
				<p>
					<?php echo $this->Form->submit('提交',array('class'=>'btn btn-success')); ?>
				</p>
			</div>
		</div>
	</div>
	<?php echo $this->Form->end(); ?>
</div>
<script type="text/javascript">
	$(".check_group_head input").change(function(){
		var value = $(this).attr("checked");
		if(value){
			$(this).parent().parent().next().find("input").attr("checked",value);
		}else{
			$(this).parent().parent().next().find("input").removeAttr("checked");
		}
	})
</script>