	</section> <!-- close section div -->
	<?php
   	if (is_array(config_item('languages')) && count(config_item('languages')) > 1)
   	{
   	?>
	<div id='lang-box' dir='ltr'>
		<div class="dropdown">
			<button class="btn btn-primary dropdown-toggle" type="button" id="dropdownMenu1" data-toggle="dropdown" aria-haspopup="true" aria-expanded="true">
				<span class='fa fa-fw fa-language'></span>
				<span class="caret"></span>
			</button>
			<ul class="dropdown-menu" aria-labelledby="dropdownMenu1">

			<?php
			foreach (config_item('languages') as $k => $row)
			{
				echo "<li><a href='?lang=".$row['symbol']."'>".ucfirst($row['name'])." (".ucfirst($row['symbol']).")</a></li>";
			}

			?>
			</ul>
        </div>
	</div>
    <?php } ?>
	<footer class='container-fluid'>
		<div class='container' style="padding-top: 5em; padding-bottom: 5em;">
			<div class='row'>
		        <div class="col-md-4 footer-links">
		        	<div class="footer-logo <?php if (config_item("show_logo") == 1){echo 'site-logo-img';} ?>">
		        		<?php echo get_logo(); ?>
		        	</div>
		        	<p><?php echo get_config_item('description') ?></p>
		        </div>
		        <div class="col-md-4 social_media">
		        	<h3><?php langLine('footer.social_media') ?>:</h3>
		        	<?php
		        		if (get_config_item('social_media_facebook'))
			        		echo "<a href='".get_config_item('social_media_facebook')."'><img src='".base_url("img/social_media/facebook.png")."'></a>";

		        		if (get_config_item('social_media_instagram'))
			        		echo "<a href='".get_config_item('social_media_instagram')."'><img src='".base_url("img/social_media/instagram.png")."'></a>";

			        	if (get_config_item('social_media_twitter'))
		        			echo "<a href='".get_config_item('social_media_twitter')."'><img src='".base_url("img/social_media/twitter.png")."'></a>";

		        		if (get_config_item('social_media_youtube'))
			        		echo "<a href='".get_config_item('social_media_youtube')."'><img src='".base_url("img/social_media/youtube.png")."'></a>";

						if (get_config_item('social_media_github'))
			        		echo "<a href='".get_config_item('social_media_github')."'><img src='".base_url("img/social_media/github.png")."'></a>";

			        	if (get_config_item('social_media_linkedin'))
			        		echo "<a href='".get_config_item('social_media_linkedin')."'><img src='".base_url("img/social_media/linkedin.png")."'></a>";

		        		if (get_config_item('social_media_reddit'))
			        		echo "<a href='".get_config_item('social_media_reddit')."'><img src='".base_url("img/social_media/reddit.png")."'></a>";

			        	if (get_config_item('social_media_pinterest'))
			        		echo "<a href='".get_config_item('social_media_pinterest')."'><img src='".base_url("img/social_media/pinterest.png")."'></a>";

			        	if (get_config_item('social_media_tumblr'))
			        		echo "<a href='".get_config_item('social_media_tumblr')."'><img src='".base_url("img/social_media/tumblr.png")."'></a>";
		        	?>
		        </div>
		        <div class="col-md-4 footer-links">
		        	<h3><?php langLine('footer.links_and_pages') ?>:</h3>
		        	<?php
		        	$s = $this->cms_model->getPages('footer');

					if ($s->num_rows() != 0)
					{
						$num = count($s->result_array());
						echo "<ul>";
						foreach ($s->result_array() as $k => $row)
						{
							echo "<li><a href='".base_url("p/".$row['slug'])."'>".ucfirst($row['title'])."</a></li>";

							// if ($k != $num - 1)
							// {
							// 	echo " | ";
							// }
							//echo $k;
						}
						echo "</ul>";
					}

					$s->free_result();
					?>
				</div>
			</div>
		</div>
		<div class='row'>
			<div class="col-xs-12 text-center copy">
				<span dir="ltr">&copy; <?php echo date('Y') .' '. config_item('sitename'); ?></span>
				<?php
					if (is_array(config_item('languages')) && count(config_item('languages')) > 1)
					{
						echo " - <select id='lang'>";
						$selected = '';
						foreach (config_item('languages') as $k => $row)
						{
							$selected = ($row['name'] == config_item('validLang')['name'])? 'selected' : '' ;
							echo "<option value='".$row['symbol']."' ".$selected.">".ucfirst($row['name'])."</option>";
						}
						echo "</select> <span class='fa fa-fw fa-language'></span>";
					}
				?>
				<br>
	        </div>
	    </div>
	</footer>
    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url(); ?>css/bootstrap/js/bootstrap.js"></script>
    <!-- <script src="<?php echo base_url(); ?>css/bootstrap4/js/bootstrap.min.js"></script> -->
    <script src="<?php echo base_url(); ?>css/bootstrap4/js/popper.min.js"></script>
    <script src="<?php echo base_url(); ?>js/main.js"></script>
<?php
//echo substr(microtime(TRUE) - MICROTIME,0,5)." ms";
?>
</body>
</html>
