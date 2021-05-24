<?php
	if ($pagedata['lang_id'] == 0)
		$lang = config_item('languages')[0];
	else
		$lang = config_item('languages')[$pagedata['lang_id']-1];
	$dir = ($lang['isRTL'])? 'rtl' : 'ltr' ;
?>
<div class='container' dir='<?php echo $dir ?>'>
	<div class='row'>
		<div class='col-lg-12'>
			<h1><?php echo $pagedata['title']; ?></h1>
		</div>
	</div>
	<hr>
	<div class='row'>
		<div class='col-lg-12'>
			<section><?php echo $page_content ?></section>
		</div>
	</div>
</div>
