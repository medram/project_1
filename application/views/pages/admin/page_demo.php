<div class='row'>
	<div class='col-lg-12'>
		<h1><?php echo $pagedata['title']; ?></h1>
	</div>
</div>
<hr>
<div class='row'>
	<div class='col-lg-12'>
		<?php echo $pagedata['content']; ?>
	</div>
</div>
<div class='row'>
	<div class='col-lg-12'>
		<i>آخر تعديل : <span dir='ltr'><?php echo date(config_item('time_format'),$pagedata['modified']); ?></span></i>
	</div>
</div>