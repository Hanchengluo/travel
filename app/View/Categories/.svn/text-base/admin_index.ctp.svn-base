<br>
<div class="row-fluid">
	<div class="span12">
		<div class="row-fluid">
			<div class="span4">
			<?php 
				//工卡不再此处办理
				$show_consume_mode_arr = $consume_mode_arr;
				unset($consume_mode_arr['staff_card']);
				echo $this->QuickForm->quick_build('Category', array(
				    'order' => array(
				        'name',
				        'consume_mode',
				        'group_ticket',
				        'support_refund',
				        'refund_ratio',
				        'refund_after_be_invalid',
				        'default_expired_days',
				        'price',
				        'inventory_ticket_activation_mode',
				    ),
				    'lang' => array(
				        'name'=>'名称',
				        'consume_mode'=>'消费方式',
				        'group_ticket'=>'是否是团体票',
				        'support_refund'=>'是否允许退款',
				        'refund_ratio'=>'退款比例',
				        'refund_after_be_invalid'=>'退款后作废',
				        'default_expired_days'=>'默认过期时间',
				        'price'=>'价格',
				        'inventory_ticket_activation_mode'=>'激活方式',
				    ),
				    'fields' => array(
				        'id' => array('type' => 'hidden', 'default' => '0' ),
				        'consume_mode' => array('options'=>$consume_mode_arr,'default' => 'only_one' ),
				        'group_ticket' => array('options' => $yn_arr, 'default' => 'n' ),
				        'refund_ratio' => array('after'=>'%'),
				        'support_refund' => array('options' => $yn_arr, 'default' => 'n' ),
				        'refund_after_be_invalid' => array('options' => $yn_arr, 'default' => 'n' ),
				        'default_expired_days' => array('after'=>'天'),
				        'inventory_ticket_activation_mode' => array('options'=>$inventory_ticket_activation_mode_arr,'default'=>'after_sell'),
				    ),
				));
			 ?>
			</div>
			<div class="span8">
				<table class="table">
					<thead>
						<tr>
							<th>序号</th>
							<th>名称</th>
							<th>状态</th>
							<th>消费方式</th>
							<th>是否是团体票</th>
							<th>是否允许退票</th>
							<th>退钱比例</th>
							<th>有效天数</th>
							<th>激活方式</th>
							<th>操作</th>
						</tr>
					</thead>
					<tbody>
						<?php foreach ($categories as $key => $one): ?>
							<?php extract($one['Category']); ?>
						<?php if ($consume_mode == 'staff_card'): ?>
							<tr>
								<td><?php echo $id; ?></td>
								<td><?php echo $name; ?></td>
								<td><?php echo $active_arr[$active]; ?></td>
								<td><?php echo $show_consume_mode_arr[$consume_mode]; ?></td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>-</td>
								<td>
									系统生成
								</td>
							</tr>
						<?php else: ?>
							<tr>
								<td><?php echo $id; ?></td>
								<td><?php echo $name; ?></td>
								<td><?php echo $active_arr[$active]; ?></td>
								<td><?php echo $show_consume_mode_arr[$consume_mode]; ?></td>
								<td><?php echo $yn_arr[$group_ticket]; ?></td>
								<td><?php echo $yn_arr[$support_refund]; ?></td>
								<td><?php echo $refund_ratio; ?>%</td>
								<td><?php echo $default_expired_days; ?></td>
								<td><?php echo $inventory_ticket_activation_mode_arr[$inventory_ticket_activation_mode]; ?></td>
								<td>
									<?php echo $this->html->link('编辑',array('action'=>'edit','admin'=>true,$id)); ?>
									<?php echo $this->Form->postLink('删除',array('action'=>'delete','admin'=>true,$id), array(), '确认删除？'); ?>
								</td>
							</tr>
						<?php endif; ?>
						<?php endforeach ?>
					</tbody>
				</table>
				<?php echo $this->element('pages'); ?>
			</div>
		</div>
	</div>
</div>