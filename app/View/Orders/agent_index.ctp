<?php 
	echo $this->Html->script('jquery-ui-1.9.2.custom.min');
	echo $this->Html->script('datepicker');
	echo $this->Html->css('jquery-ui');
	$query = $this->request->query;
 ?>
<!-- 销售报告 -->
<div class="column">
	<div class="row-fluid">
		<div class="span12">
			<h3>快速统计</h3>
			<div class="btn-group">
			  <a class="btn <?php echo $query['quick']=='day'?'btn-primary':''; ?>" href="<?php echo $this->Html->url(array('?'=>array('quick'=>'day'))); ?>">今天</a>
			  <a class="btn <?php echo $query['quick']=='week'?'btn-primary':''; ?>" href="<?php echo $this->Html->url(array('?'=>array('quick'=>'week'))); ?>">本周</a>
			  <a class="btn <?php echo $query['quick']=='month'?'btn-primary':''; ?>" href="<?php echo $this->Html->url(array('?'=>array('quick'=>'month'))); ?>">本月</a>
			  <a class="btn <?php echo $query['quick']=='year'?'btn-primary':''; ?>" href="<?php echo $this->Html->url(array('?'=>array('quick'=>'year'))); ?>">本年</a>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<h3>精确统计</h3>
		<div class="span12">
	        <?php
	        echo $this->Form->create('Depot',array('type' => 'get','class'=>'inline'));
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
	        echo $this->Form->button('统计',array('class'=>'btn'));
	        echo $this->Form->end();
	        ?>
		</div>
        <br>
		<h3>统计数据</h3>
		<table class="table">
			<thead>
				<tr>
					<th>开始时间</th>
					<th>结束时间</th>
					<th>出票数量(张)</th>
					<th>收取金额(元)</th>
				</tr>
			</thead>
			<tbody>
				<tr>
					<td><?php echo date('Y-m-d H:i:s',$start_time); ?></td>
					<td><?php echo date('Y-m-d H:i:s',$end_time); ?></td>
					<td><?php echo $count; ?></td>
					<td><?php echo $this->Html->formatMoney($sum); ?></td>
				</tr>
			</tbody>
		</table>
        <div class="clearfix"></div>
	</div>
</div>
<script>
	datepicker('.datetime');
</script>