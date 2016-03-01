
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
				        'Category.name' => '票种名称',
			        ),
		        ));
		        echo "关键词：";
		        echo $this->Form->input('keyword', array(
			        'label' => false,
			        'div' => false,
			        'class' => 'input-small',
			        ));
		        echo "库存状态：";
		        echo $this->Form->input('Depot.active', array(
			        'label' => false,
			        'div' => false,
			        'class' => 'input-small',
			        'options'=>$active_arr,
			        'default'=>'1'
			        ));
		        echo $this->Form->button('搜索',array('class'=>'btn'));
		        echo $this->Form->end();
	        ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
			<table class="table">
				<thead>
					<tr>
						<th>序号</th>
						<th>票种名称</th>
						<th>是否团体票</th>
						<th>有效天数</th>
						<th>门票单价(元)</th>
						<th>库存数量(张)</th>
					</tr>
				</thead>
				<tbody>
					<?php foreach ($data as $key => $one): ?>
					<?php extract($one['Category']); ?>
					<tr>
						<td><?php echo $id; ?></td>
						<td><?php echo $name; ?></td>
						<td><?php echo $yn_arr[$group_ticket]; ?></td>
						<td><?php echo $default_expired_days; ?></td>
						<td><?php echo $price; ?></td>
						<td>
							<?php echo $one[0]['depot_sum']; ?>
							<?php $active = $this->request->query['active'] ?>
							<?php echo $this->Html->link('所有序列号',array('action'=>'view','admin'=>true,$id,'?'=>array('active'=>$active))); ?>
						</td>
					</tr>
					<?php endforeach ?>
				</tbody>
			</table>
			<?php echo $this->element('pages'); ?>
		</div>
	</div>
</div>