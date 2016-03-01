<?php 
	echo $this->Html->script('jquery-ui-1.9.2.custom.min');
	echo $this->Html->script('datepicker');
	echo $this->Html->css('jquery-ui');
 ?>
<div class="row-fluid">
	<div class="span12">
	    <div class="column">
	        <?php
	        echo $this->Form->create('User',array('type' => 'get','class'=>'inline'));
	        echo "时间段";
			echo $this->Form->input('start_time', array(
			    'label' => false,
			    'div' => false,
			    'default' => date('Y-m-d', (time() - 3600 * 24 * 31)),
			    'class' => 'input-small datetime'
			));
			echo "--";
			echo $this->Form->input('end_time', array(
			    'label' => false,
			    'div' => false,
			    'default' => date('Y-m-d', (time() + 3600 * 24)),
			    'class' => 'input-small datetime'
			));

	        echo "操作人:";
	        echo $this->Form->input('name', array(
		        'label' => false,
		        'div' => false,
		        'class' => 'input-small',
	        ));
	        echo $this->Form->button('搜索',array('class'=>'btn'));
	        echo $this->Form->end();
	        ?>
	        <br>
	        <table class="table">
	            <thead>
	                <tr>
	                	<th>序号</th>
	                    <th>时间</th>
	                    <th>操作人</th>
	                    <th>操作项目</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($data as $key => $one):?>
	                <?php extract($one['UserLog']); ?>
	                <tr>
	                    <td><?php echo $id; ?></td>
	                    <td><?php echo date('Y-m-d H:i:s',$created); ?></td>
						<td><?php echo $one['User']['name'] ?>(<?php echo $one['User']['username'] ?>)</td>
	                    <td><?php echo $logs ?></td>
	                </tr>
	                <?php endforeach;?>
	            </tbody>
	        </table>
	        <?php echo $this->element('pages'); ?>
	        <div class="clearfix"></div>
	    </div>
	</div>
</div>
<script>
	datepicker('.datetime');
</script>