 <!DOCTYPE HTML>
<!--[if IE 6]><html class="ie6 lte9 lte7 no-css3" lang="zh-cn"><![endif]-->
<!--[if IE 8]><html class="ie8 lte9 no-css3" lang="zh-cn"><![endif]-->
<!--[if IE 9]><html class="ie9 lte9 no-css3" lang="zh-cn"><![endif]-->
<!--[if IE 7]><html class="ie7 lte9 lte7 no-css3" lang="zh-cn"><![endif]-->
<!--[if !(IE 6) | !(IE 7) | !(IE 8) | !(IE 9)  ]><!--><html lang="zh-cn"><!--<![endif]-->
<head>
<meta charset="UTF-8">
<title><?php echo $title; ?></title>
<?php echo $this->Html->css('bootstrap'); ?>
<?php echo $this->Html->css('main'); ?>
<?php echo $this->Html->script('jquery'); ?>
<?php echo $this->Html->script('bootstrap.min'); ?>
</head>
<body>
	<div id="header">
		<div class="row-fluid top">
			<div class="logo">
				<h1>电子售票系统</h1>
				<ul class="drop-menu none">
					<li class="title">所在售票点</a></li>
					<li><a href="/sell/orders">票务中心</a></li>
					<li><a href="/admin/Categories">管理中心</a></li>
					<li><a href="/data/orders">数据中心</a></li>
					<li><a href="/purview/users">权限管理</a></li>
					<li class="dived"><hr></li>
					<li><a href="/users/logout">注销</a></li>
					<li><a href="">退出打印</a></li>
				</ul>	
			</div>
			<div class="nav">
				<ul class="main-menu">
					<li class=" <?php echo ($current_prefix == 'sell')?'active':''; ?>"><a href="/sell/orders">票务中心</a></li>
					<li class=" <?php echo ($current_prefix == 'admin')?'active':''; ?>"><a href="/admin/Categories">管理中心</a></li>
					<li class=" <?php echo ($current_prefix == 'agent')?'active':''; ?>"><a href="/agent/agents/">代理系统</a></li>
					<li class=" <?php echo ($current_prefix == 'data')?'active':''; ?>"><a href="/data/orders">数据中心</a></li>
					<li class=" <?php echo ($current_prefix == 'purview')?'active':''; ?>"><a href="/purview/users">权限管理</a></li>
				</ul>
			</div>
			<div class="user-tool">
			 <span>
				<i class="icon icon-user"></i>
				<?php echo $user['name']; ?>
			 </span>	
			<span>|</span>
			 <span>
				<i class="icon icon-logout"></i>
				<a href="/users/logout">注销(交班)</a>
			 </span>				
			</div>
		</div>
	
		<!-- 每个管理栏目下的控制面板 售票模块 -->
		<?php if ($current_prefix == 'sell'): ?>
			<div class="panel">
				<div class="sub-menu">
					<ul>
						<li><a class="btn-bg btn-bg-sell <?php echo ($feature_alias=='sell_ticket')?'active':''; ?>" href="/sell/orders/"><span>售票</span></a></li>
						<li><a class="btn-bg btn-bg-refund <?php echo ($feature_alias=='sell_refund')?'active':''; ?>" href="/sell/orders/refund"><span>退票</span></a></li>
						<li><a class="btn-bg btn-bg-year <?php echo ($feature_alias=='sell_year')?'active':''; ?>" href="/sell/depot_annuals"><span>年卡办理</span></a></li>
						<li><a class="btn-bg btn-bg-chek <?php echo ($feature_alias=='sell_check_ticket')?'active':''; ?>" href="/sell/orders/view_only_one"><span>验票查询</span></a></li>
					</ul>
				</div>
				<?php if ($statis): ?>
				<div class="status">
					<p>当天已售票总数：<span class="num"><?php echo $statis['count']; ?></span> 位   金额：<span class="num"><?php echo $this->Html->formatMoney($statis['sum']); ?></span> 元  
					</p> 
				</div>
				<?php endif ?>
			</div>
		<?php endif; ?>

		<!-- 管理模块 -->
		<?php if ($current_prefix == 'admin'): ?>
			<div class="panel">
				<div class="sub-menu">
					<ul>
						<li><a class="btn-bg btn-bg-admin_category <?php echo ($feature_alias=='admin_category')?'active':''; ?>" href="/admin/categories/"><span>票种类管理</span></a></li>
						<li><a class="btn-bg btn-bg-admin_depot_statis <?php echo ($feature_alias=='admin_depot_statis')?'active':''; ?>" href="/admin/depots/statis?active=1"><span>库存统计</span></a></li>
						<li><a class="btn-bg btn-bg-admin_depot_import <?php echo ($feature_alias=='admin_depot_import')?'active':''; ?>" href="/admin/depots/"><span>门票入库</span></a></li>
						<li><a class="btn-bg btn-bg-admin_depot_sell_take <?php echo ($feature_alias=='admin_depot_sell_take')?'active':''; ?>" href="/admin/depots/seller_take"><span>售票员领票</span></a></li>
						<li><a class="btn-bg btn-bg-admin_depot_return <?php echo ($feature_alias=='admin_depot_return')?'active':''; ?>" href="/admin/depots/back_depot"><span>余票回库</span></a></li>
						<li><a class="btn-bg btn-bg-admin_depot_staff <?php echo ($feature_alias=='admin_depot_staff')?'active':''; ?>" href="/admin/depot_staffs"><span>工卡管理</span></a></li>
						<li><a class="btn-bg btn-bg-admin_exchange_record <?php echo ($feature_alias=='admin_exchange_record')?'active':''; ?>" href="/admin/users/log"><span>交班记录</span></a></li>
						<li><a class="btn-bg btn-bg-admin_device <?php echo ($feature_alias=='admin_device')?'active':''; ?>" href="/admin/devices/"><span>终端设备</span></a></li>
					</ul>
				</div>
			</div>
		<?php endif; ?>

		<!-- 代理系统 -->
		<?php if ($current_prefix == 'agent'): ?>
			<div class="panel">
				<div class="sub-menu">
					<ul>
						<li><a class="btn-bg btn-bg-agent_index <?php echo ($feature_alias=='agent_index')?'active':''; ?>" href="/agent/agents/"><span>现有代理商</span></a></li>
						<li><a class="btn-bg btn-bg-agent_add <?php echo ($feature_alias=='agent_add')?'active':''; ?>" href="/agent/agents/add"><span>新增代理</span></a></li>
						<li><a class="btn-bg btn-bg-agent_order <?php echo ($feature_alias=='agent_order')?'active':''; ?>" href="/agent/depots/"><span>出票明细</span></a></li>
						<li><a class="btn-bg btn-bg-agent_sell_report <?php echo ($feature_alias=='agent_sell_report')?'active':''; ?>" href="/agent/orders?quick=month"><span>销售报告</span></a></li>
					</ul>
				</div>
			</div>
		<?php endif; ?>

		<!-- 数据中心 -->
		<?php if ($current_prefix == 'data'): ?>
			<div class="panel">
				<div class="sub-menu">
					<ul>
						<li><a class="btn-bg btn-bg-data_sell_report <?php echo ($feature_alias=='data_sell_report')?'active':''; ?>" href="/data/orders/report?quick=month"><span>销售报告</span></a></li>
						<li><a class="btn-bg btn-bg-data_sell_take <?php echo ($feature_alias=='data_sell_take')?'active':''; ?>" href="/data/depots/"><span>领票统计</span></a></li>
						<li><a class="btn-bg btn-bg-data_order_record <?php echo ($feature_alias=='data_order_record')?'active':''; ?>" href="/data/orders/"><span>售票明细</span></a></li>
						<li><a class="btn-bg btn-bg-data_cancel <?php echo ($feature_alias=='data_cancel')?'active':''; ?>" href="/data/orders/invalid"><span>作废记录</span></a></li>
						<li><a class="btn-bg btn-bg-data_exit <?php echo ($feature_alias=='data_exit')?'active':''; ?>" href="/data/exist_statistics"><span>出口统计</span></a></li>
						<li><a class="btn-bg btn-bg-data_check_record <?php echo ($feature_alias=='data_check_record')?'active':''; ?>" href="/data/verifies/"><span>检票记录</span></a></li>
					</ul>
				</div>
			</div>
		<?php endif; ?>

		<!-- 用户权限管理 -->
		<?php if ($current_prefix == 'purview'): ?>
			<div class="panel">
				<div class="sub-menu">
					<ul>
						<li><a class="btn-bg btn-bg-purview_user <?php echo ($feature_alias=='purview_user')?'active':''; ?>" href="/purview/users/"><span>用户管理</span></a></li>
						<li><a class="btn-bg btn-bg-purview_user_add <?php echo ($feature_alias=='purview_user_add')?'active':''; ?>" href="/purview/users/add"><span>添加用户</span></a></li>
						<li><a class="btn-bg btn-bg-purview_user_log <?php echo ($feature_alias=='purview_user_log')?'active':''; ?>" href="/purview/users/log"><span>权限日志</span></a></li>
					</ul>
				</div>
			</div>
		<?php endif; ?>	</div>
	<div id="main">
		<?php echo $this->Session->flash(); ?>
		<?php echo $this->fetch('content'); ?>
	</div>
	<div class="clearfix"></div>
	<div id="footer">
		<p>时间： <?php echo date('Y 年 m  月 d 日') ?></p>
	</div>

	<script type="text/javascript">
		$(".logo").hover(function(){
			$('.drop-menu').show();
		},function(){
			$('.drop-menu').hide();
		})
	</script>
</body>
</html>