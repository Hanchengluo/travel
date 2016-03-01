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
			        'username' => '登陆帐号',
			        'name' => '姓名'
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
	                    <th>工卡编号</th>
	                    <th>工卡类别</th>
	                    <th>手机号</th>
	                    <th>办卡时间</th>
	                    <th>到期时间</th>
	                    <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($data as $key => $one):?>
	                <tr>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                    <td></td>
	                </tr>
	                <?php endforeach;?>
	            </tbody>
	        </table>
	        <?php echo $this->element('pages'); ?>
	        <div class="clearfix"></div>
		</div>
	</div>
</div>
