	</section> <!-- close section div -->

	<footer class='container-fluid'>
		<div class='container'>
			<div class='row'>
				<div class="col-xs-3">
					<span dir="ltr">© <?php echo date('Y') .' '. config_item('sitename'); ?></span><br>
		        </div>
		        <div class="col-xs-9" dir="ltr">
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
<?php
//echo substr(microtime(TRUE) - MICROTIME,0,5)." ms";
?>
</body>
</html>