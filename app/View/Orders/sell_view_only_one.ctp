<div class="column">
	<div class="row-fluid">
		<div class="span12">
			<ul class="nav nav-tabs" id="myTab">
			  <li class="active"><a href="/sell/orders/view_only_one">普通票</a></li>
			  <li><a href="/sell/orders/view_year">年卡</a></li>
			</ul>
			<div class="tab-content">
				<div class="row-fluid">
					<div class="span4">
						<?php echo $this->Form->create('Depot'); ?>
						<?php echo $this->Form->input('ticket_no',array('label'=>'票号')); ?>
						<?php echo $this->Form->submit('查找',array('class'=>'btn btn-success'));; ?>
						<?php echo $this->Form->end(); ?>
						<p>
						请扫描门票二维码或输入门票编号
						</p>
					</div>		
					<div class="span6">
						<?php if ($order): ?>
							<h3>门票信息</h3>
							<dl class="dl-horizontal text-left view-list">
							  <dt>门票状态</dt>
							  <dd class="text-error"><?php echo $active_arr[$order['Depot']['active']]; ?></dd>
							  <dt>门票种类</dt>
							  <dd class="text-error"><?php echo $order['Depot']['Category']['name']; ?></dd>
							  <dt>是否团体票</dt>
							  <dd class="text-error"><?php echo $yn_arr[$order['Depot']['Category']['group_ticket']]; ?></dd>
							  <dt>购票金额</dt>
							  <dd class="text-error"><?php echo $this->Html->formatMoney($order['Order']['price']); ?>元</dd>
							  <dt>购买时间</dt>
							  <dd class="text-error"><?php echo date('Y-m-d H:i:s',$order['Order']['created']) ?></dd>
							</dl>
							<hr>
							<div>
								<h3>核销记录</h3>
								<?php if ($order['Depot']['Verify']): ?>
									<table class="table">
										<tr>
											<th>序号</th>
											<th>时间</th>
										</tr>
										<?php foreach ($order['Depot']['Verify'] as $key => $one): ?>
										<tr>
											<td><?php echo $one['id'] ?></td>
											<td><?php echo date('Y-m-d H:i:s',$one['created']) ?></td>
										</tr>
										<?php endforeach ?>
									</table>
								<?php else: ?>
									<p>本票还没有消费！</p>
								<?php endif ?>
							</div>
						<?php endif ?>
					</div>
				<hr>
				</div>
			</div>
		</div>
	</div>
</div>