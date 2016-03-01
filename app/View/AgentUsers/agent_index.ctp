<div class="column">
	<div class="row-fluid">
		<div class="span2 pull-right">
		    <?php echo $this->Html->link('添加导游证',array('action'=>'add','agent'=>true,$agent_id),array('class'=>'btn')); ?>
		</div>
	</div>
	<hr>
	<div class="row-fluid">
		<div class="span12">
	        <table class="table">
	            <thead>
	                <tr>
	                    <th>序号</th>
	                    <th>姓名</th>
	                    <th>身份证号码</th>

	                    <th>导游证编号</th>
	                    <th>创建时间</th>
	                    <th>管理</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($data as $key => $one):?>
	                <?php extract($one['AgentUser']) ?>
	                <tr>
	                    <td><?php echo $id; ?></td>
	                    <td><?php echo $name; ?></td>
	                    <td><?php echo $idcard_no; ?></td>
	                    <td><?php echo $guide_no; ?></td>
	
	                    <td><?php echo date('Y-m-d',$created); ?></td>
	                    <td>
	                  		<?php echo $this->Html->link('修改',array('action'=>'edit',$id)); ?>
	                  		<?php echo $this->Form->postLink('删除',array('action'=>'del',$id),null,'确定要删除？'); ?>
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

