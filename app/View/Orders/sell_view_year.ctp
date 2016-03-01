<div class="column">
	<div class="row-fluid">
		<div class="span12">
			<ul class="nav nav-tabs" id="myTab">
			  <li> <a href="/sell/orders/view_only_one">普通票</a></li>
			  <li class="active"><a href="/sell/depot_annuals/view_year">年卡</a></li>
			</ul>
			<div class="tab-content">
				<div class="row-fluid">
					<div class="span4">
						<?php echo $this->Form->create('DepotAnnual'); ?>
						<?php echo $this->Form->input('card_no',array('label'=>'身份证','default'=>$card_no)); ?>
						<?php echo $this->Form->submit('查找',array('class'=>'btn btn-success'));; ?>
						<?php echo $this->Form->end(); ?>
						<p>
							请使用身份证查询
						</p>
					</div>		
					<div class="span6">
						<?php if ($depot_annual): ?>
						<h3>门票信息</h3>
							<dl class="dl-horizontal text-left view-list">
							  <dt>门票种类</dt>
							  <dd class="text-error"><?php echo $depot_annual['Depot']['Category']['name']; ?></dd>
							  <dt>持卡人</dt>
							  <dd class="text-error"><?php echo $depot_annual['DepotAnnual']['name']; ?></dd>
							  <dt>有效期</dt>
							  <dd class="text-error"><?php echo date('Y-m-d H:i:s',$depot_annual['Depot']['created']) ?></dd>
							</dl>
							<hr>
							<div>
								<h3>核销记录</h3>
								<?php if ($depot_annual['Depot']['Verify']): ?>
									<table class="table">
										<tr>
											<th>序号</th>
											<th>时间</th>
										</tr>
										<?php foreach ($depot_annual['Depot']['Verify'] as $key => $one): ?>
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