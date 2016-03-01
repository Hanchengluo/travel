<div class="column">
	<div class="row-fluid">
		<div class="span8">
	        <?php
		        echo $this->Form->create(array('type' => 'get','class'=>'inline'));
		        echo "搜索条件:";
		        echo $this->Form->input('type', array(
			        'label' => false,
			        'div' => false,
			        'class' => 'input-small',
			        'options' => array(
			            'User.name' => '姓名',
			            'User.username' => '用户名',
			        ),	
		        ));
		        echo "关键词：";
		        echo $this->Form->input('keyword', array(
			        'label' => false,
			        'div' => false,
			        'class' => 'input-small',
			        ));
		        echo $this->Form->button('搜索',array('class'=>'btn'));
		        echo $this->Form->end();
	        ?>
		</div>
		<div class="span4">
		       	<?php echo $this->Html->link('添加用户',array('action'=>'add','purview'=>true),array('class'=>'btn')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
		<table class="table">
			<thead>
				<tr>
					<th>序号</th>
					<th>用户名</th>
					<th>姓名</th>
					<th>用户组</th>
					<th>状态</th>
					<th>权限级别</th>
					<th>职位</th>
					<th>创建时间</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php foreach ($data as $key => $one): ?>
				<?php extract($one['User']); ?>
				<tr>
					<td><?php echo $id; ?></td>
					<td><?php echo $username;	 ?></td>
					<td><?php echo $name;	 ?></td>
					<td><?php echo $groups[$group_id];	 ?></td>
					<td><?php echo $active_arr[$active];	 ?></td>
					<td><?php echo '一般' ?></td>
					<td><?php echo $title;	 ?></td>
					<td><?php echo date('Y-m-d H:i:s',$updated);?></td>
					<th>
						<?php echo $this->Html->link('用户变更',array('purview'=>true,'action'=>'edit',$id)); ?>
						<?php echo $this->Html->link('修改密码',array('purview'=>true,'action'=>'password',$id)); ?>
						<?php echo $this->Form->postLink('删除',array('purview'=>true,'action'=>'delete',$id),null,'是否要删除?'); ?>
					</th>
				</tr>
				<?php endforeach ?>
			</tbody>
		</table>
	        <?php echo $this->element('pages'); ?>
	        <div class="clearfix"></div>
		</div>
	</div>
</div>
