<?php 
	echo $this->Html->script('jquery-ui-1.9.2.custom.min');
	echo $this->Html->script('datepicker');
	echo $this->Html->css('jquery-ui');
 ?>
<div class="row-fluid">
	<div class="span12">
	    <div class="column">
	        <?php
	        echo $this->Form->create('Order',array('type' => 'get','class'=>'inline'));
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
			    'default' => date('Y-m-d'),
			    'class' => 'input-small datetime'
			));
	        echo "搜索条件:";
	        echo $this->Form->input('type', array(
		        'label' => false,
		        'div' => false,
		        'class' => 'input-small',
		        'options' => array(
		        'AgentUser.guide_no' => '导游证',
		        'Agent.name' => '代理商'
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
	        <br>
	        <table class="table">
	            <thead>
	                <tr>
	                    <th>代理商</th>
	                    <th>导游证编号</th>
	                    <th>票种名称</th>
	                    <th>购买张数</th>
						<th>门票编号</th>
	                    <th>总价(元)</th>
	                    <th>实际收取(元)</th>
	                    <th>时间</th>
	                </tr>
	            </thead>
	            <tbody>
	                <?php foreach ($data as $key => $one):?>
	                <tr>
	                    <td><?php echo $one['Agent']['name']; ?></td>
	                    <td><?php echo $one['AgentUser']['guide_no']; ?></td>
	                    <td><?php echo $one['Category']['name']; ?></td>
	                    <td><?php echo $one['Depot']['voucher_total']; ?></td>
	                    <td><?php echo $one['Depot']['ticket_no']; ?></td>

	                    <td><?php echo $this->Html->formatMoney($one['Category']['name']*$one['Depot']['voucher_total']); ?></td>
	                    <td><?php echo $this->Html->formatMoney($one['Order']['price']);  ?></td>
	                    <td><?php echo date('Y-m-d H:i:s',$one['Order']['created']); ?></td>
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