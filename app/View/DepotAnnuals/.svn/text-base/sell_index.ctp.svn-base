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
				        'DepotAnnual.mobile' => '电话',
				        'DepotAnnual.name' => '姓名'
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
		       	<?php echo $this->Html->link('办理年卡',array('action'=>'add','sell'=>true),array('class'=>'btn')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
	        <table class="table">
	            <thead>
	                <tr>
	                    <th>序号</th>
	                    <th>姓名</th>
	                    <th>电话</th>
	                    <th>身份证</th>
	                    <th>办卡时间</th>
	                    <th>到期时间</th>
	                    <th>金额(元)</th>
	                    <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($data as $key => $one):?>
	                <tr>
	                	<?php $price = $one['Depot']['price']*$one['DepotAnnual']['valid_for']; ?>
	                    <td><?php echo $one['DepotAnnual']['id']; ?></td>
	                    <td><?php echo $one['DepotAnnual']['name']; ?></td>
	                    <td><?php echo $one['DepotAnnual']['mobile']; ?></td>
	                    <td><?php echo $one['DepotAnnual']['card_no']; ?></td>
	                    <td><?php echo $one['Depot']['valid_start']; ?></td>
	                    <td><?php echo $one['Depot']['valid_ends']; ?></td>
	                    <td><?php echo $this->Html->formatMoney($price)?></td>
	                    <td>
	                    	<?php echo $this->html->link('修改信息',array('action'=>'edit','sell'=>true,$one['DepotAnnual']['id'])); ?>
	                    	<?php echo $this->html->link('查看',array('controller'=>'orders','action'=>'view_year','sell'=>true,$one['DepotAnnual']['card_no'])); ?>
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
