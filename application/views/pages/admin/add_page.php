<!-- Content Header (Page header) -->
<section class="content-header">
	<h1><i class="fa fa-plus-circle"></i> Add page</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-warning">
		<div class="box-body">
			<div class='row'>
				<div class='col-lg-8'>
					<?php
					if (isset($msg))
					{
						echo $msg;
					}
					?>
					<form action='<?php echo base_url($page_path); ?>/pages/add' method='post'>
						<div class='form-group'>
							<label>Page name :</label>
							<input type='text' name='title' class='form-control'>
						</div>
						<div class='form-group'>
							<label>Slug :</label>
							<!--<input type='text' name='slug' class='form-control' placeholder='example'>-->
							<div class="input-group">
								<span class="input-group-addon" id="basic-addon3"><b><?php echo base_url('p'); ?>/</b></span>
								<input type="text" name="slug" class="form-control" placeholder='about-us' id="basic-url" aria-describedby="basic-addon3">
							</div>
						</div>
						<div class='form-group'>
							<label>this page will be availabel for : </label><br>
							<small><i>choose the language.</i></small>
							<select name='lang-id' class='form-control'>
								<option value='0'>---------- All languages ----------</option>
								<?php
								foreach(config_item('languages') as $k => $row)
								{
									echo "<option value='".($k+1)."'>".ucfirst($row['name'])."</option>";
								}
								?>
							</select>
						</div>
						<div class='form-group'>
							<label>Keywords :</label><br>
							<small><i>put this carracter "<b>,</b>" between the keywords.</i></small>
							<input type='text' name='keywords' class='form-control'>
						</div>
						<div class='form-group'>
							<label>Description (short idea about the page):</label>
							<textarea name='desc' class='form-control' rows='5'></textarea>
						</div>
						<div class='form-group'>
							<label>Publish :</label>
							<select name='published' class='form-control'>
								<option value='1'>Yes</option>
								<option value='0'>No</option>
							</select>
						</div>
						<div class='form-group'>
							<label>Show at the header (navbar) :</label>
							<select name='header' class='form-control'>
								<option value='1'>Yes</option>
								<option value='0'>No</option>
							</select>
						</div>
						<div class='form-group'>
							<label>Show at the footer :</label>
							<select name='footer' class='form-control'>
								<option value='1'>Yes</option>
								<option value='0'>No</option>
							</select>
						</div>
						<div class='form-group'>
							<label>Page Content :</label>
							<!-- <textarea name='content' class='form-control' rows='5'></textarea> -->
							
							<div> <!-- start editor -->
								<textarea name='content' id="some-textarea" placeholder="Enter the content here ..." style="width: 100%; height: 480px; padding: 10px;"></textarea>
							</div> <!-- end editor -->


						</div>
						<div class='form-group'>
							<input type='submit' name='add' class='btn btn-primary' value='Add page'>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</section>

