<div class="column">
	<div class="row-fluid">
		<div class="span8">
	        <?php
		        echo $this->Form->create('Agent',array('type' => 'get','class'=>'inline'));
		        echo "搜索代理商:";
		        echo $this->Form->input('name', array(
			        'label' => false,
			        'div' => false,
			        'class' => 'input-small',
			        ));	
		        echo $this->Form->button('搜索',array('class'=>'btn'));
		        echo $this->Form->end();
	        ?>
		</div>
		<div class="span4">
		       	<?php echo $this->Html->link('添加代理商',array('action'=>'add','agent'=>true),array('class'=>'btn')); ?>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span12">
	        <table class="table">
	            <thead>
	                <tr>
	                    <th>时间</th>
	                    <th>代理商</th>
	                    <th>支付方式</th>

	                    <th>合作模式</th>
	                    <th>管理</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($data as $key => $one):?>
	                <?php extract($one['Agent']) ?>
	                <tr>
	                    <td><?php echo $id; ?></td>
	                    <td><?php echo $name; ?></td>
	                    <td><?php echo $pay_mode_arr[$pay_mode]; ?></td>

	                    <td><?php echo $consume_mode_arr[$consume_mode]; ?></td>
	                    <td>
	                  		<?php echo $this->Html->link('修改',array('action'=>'edit',$id)); ?>
	                  		<?php echo $this->Html->link('删除',array('action'=>'del',$id)); ?>
	                  		<?php echo $this->Html->link('导游证管理',array('controller'=>'AgentUsers','action'=>'index',$id)); ?>
	                  		<?php echo $this->Html->link('出料明细',array('controller'=>'depots','action'=>'index','agent'=>true,'?'=>array('type'=>'Agent.name','keyword'=>$name))); ?>
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

