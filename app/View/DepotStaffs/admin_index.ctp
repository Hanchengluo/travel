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
				        'DepotStaff.mobile' => '电话',
				        'DepotStaff.name' => '姓名'
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
		       	<?php echo $this->Html->link('添加工卡',array('action'=>'add','admin'=>true),array('class'=>'btn')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
	        <table class="table">
	            <thead>
	                <tr>
	                    <th>序号</th>
	                    <th>姓名</th>
	                    <th>身份证</th>
	                    <th>限制方式</th>
	                    <th>电话</th>
	                    <th>办卡时间</th>
	                    <th>到期时间</th>
	                    <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($data as $key => $one):?>
	                <tr>
	                    <td><?php echo $one['DepotStaff']['id']; ?></td>
	                    <td><?php echo $one['DepotStaff']['name']; ?></td>
	                    <td><?php echo $one['DepotStaff']['card_no']; ?></td>
	                    <td><?php echo $access_mode_arr[$one['DepotStaff']['access_mode']]; ?></td>
	                    <td><?php echo $one['DepotStaff']['mobile']; ?></td>
	                    <td><?php echo $one['Depot']['valid_start']; ?></td>
	                    <td><?php echo $one['Depot']['valid_ends']; ?></td>
	                    <td>
	                    	<?php echo $this->html->link('修改信息',array('action'=>'edit','admin'=>true,$one['DepotStaff']['id'])); ?>
	                    	<?php echo $this->html->link('查看',array('action'=>'view','admin'=>true,$one['DepotStaff']['id'])); ?>
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
