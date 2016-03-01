<?php 
	echo $this->Html->script('jquery-ui-1.9.2.custom.min');
	echo $this->Html->script('datepicker');
	echo $this->Html->css('jquery-ui');
 ?>
<div class="row-fluid">
	<div class="span12">
	    <div class="column">
	        <?php
	        echo $this->Form->create(array('type' => 'get','class'=>'inline'));
	        
	        echo "搜索条件:";
	        echo $this->Form->input('type', array(
		        'label' => false,
		        'div' => false,
		        'class' => 'input-small',
		        'options' => array(
		        	'Depot.ticket_no' => '票号'
		        ),
	        ));
	        echo "关键词：";
	        echo $this->Form->input('keyword', array(
		        'label' => false,
		        'div' => false,
		        'class' => 'input-small',
		        ));
	        echo "入库时间";
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
			    'default' => date('Y-m-d'),
			    'class' => 'input-small datetime'
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
	        <br>
	        <table class="table">
	            <thead>
	                <tr>
	                    <th>入库时间</th>
	                    <th>票种名称</th>
	                    <th>门票编号</th>

	                    <th>操作</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($data as $key => $one):?>
	                <tr>
	                    <td><?php echo date('Y-m-d H:i:s',$one['DepotLog']['created']); ?></td>
	                    <td><?php echo $one['Category']['name']; ?></td>
	                    <td><?php echo $one['Depot']['ticket_no']; ?></td>
	                    
	                    <td>
	                   		<?php $active = $one['Depot']['active']; ?>
	                   		<?php if ($active >= 0): ?>
		                    	<?php echo $this->Form->postLink('作废',array('action'=>'cancel',$one['Depot']['id']),null,'确定要作废？'); ?>
	                   		<?php endif ?>
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
<script>
	datepicker('.datetime');
</script>