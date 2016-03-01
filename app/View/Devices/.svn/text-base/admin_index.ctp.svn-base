<div class="column">
	<div class="row-fluid">
		<div class="span2 pull-right">
		       	<?php echo $this->Html->link('添加设备',array('action'=>'add','admin'=>true),array('class'=>'btn')); ?>
		</div>
	</div>
	<br>
	<div class="row-fluid">
		<div class="span12">
	        <table class="table">
	            <thead>
	                <tr>
	                    <th>序列</th>
	                    <th>设备号</th>
	                    <th>名称</th>
	                    <th>所在点</th>
	                    <th>状态</th>
	                    <th>添加时间</th>
	                    <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($data as $key => $one):?>
	                <?php extract($one['Device']); ?>
	                <tr>
	                    <td><?php echo $id; ?></td>
	                    <td><?php echo $device_sid; ?></td>
	                    <td><?php echo $name; ?></td>
	                    <td><?php echo $type_arr[$type]; ?></td>
	                    <td><?php echo $active_arr[$active]; ?></td>
	                    <td><?php echo date('Y-m-d H:i:s',$created); ?></td>
	                    <td>
	                    	<?php echo $this->Html->link('编辑',array('action'=>'edit','admin'=>true,$id)) ?>
	                    	<?php if ($active == '-1'): ?>
	                    		<?php echo $this->Html->link('激活',array('action'=>'active','admin'=>true,$id)) ?>
	                    	<?php else: ?>
	                    		<?php echo $this->Form->postLink('锁定',array('action'=>'lock','admin'=>true,$id),null,'确认要锁定？') ?>
	                    	<?php endif ?>
	                    </td>
	                </tr>
	                <?php endforeach;?>
	            </tbody>
	        </table>
	        <?php echo $this->element('pages'); ?>
	        <div class="clearfix"></div>
		</div>
	</div>
</div>
