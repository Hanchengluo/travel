<?php if ($this->Paginator->hasPage()): ?>
<div class="pages">
	<?php
        echo $this->Paginator->prev('上一页', array('tag' => 'span'),null,array('class' => 'prev disabled','tag'=>'span'));
        echo $this->Paginator->next('下一页', array('tag' => 'span'),null,array('class' => 'next disabled','tag'=>'span'));
	    echo $this->Paginator->numbers(array('separator' => ' ','tag'=>'span','currentClass'=>'active'));
    ?>
	<span>
	<?php 
		echo $this->Paginator->counter(
		    '{:page}/{:pages} 显示 {:current} 条记录,
		     共{:count}条记录'
		);
	 ?>
	</span>
</div>
<?php endif; ?>