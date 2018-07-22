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
		<div class='container'>
			<div class='row'>
				<div class="col-xs-3 copy">
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
		        <div class="col-xs-9 footer-links">
		        	<?php
		        	$s = $this->cms_model->getPages('footer');

					if ($s->num_rows() != 0)
					{
						$num = count($s->result_array());
						foreach ($s->result_array() as $k => $row)
						{
							echo "<a href='".base_url("p/".$row['slug'])."'>".$row['title']."</a>";
							
							if ($k != $num - 1)
							{
								echo " | ";
							}
							//echo $k;
						}
					}

					$s->free_result();
					?>
				</div>
			</div>
		</div>
	</footer>
    <!-- Bootstrap core JavaScript -->
    <script src="<?php echo base_url(); ?>css/bootstrap/js/bootstrap.js"></script>
    <script src="<?php echo base_url(); ?>js/main.js"></script>
<?php
//echo substr(microtime(TRUE) - MICROTIME,0,5)." ms";
?>
</body>
</html>