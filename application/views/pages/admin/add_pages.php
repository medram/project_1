<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class="fa fa-plus-circle"></i> Add pages
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Add pages
            </li>
        </ol>
    </div>
</div>
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
				<label>Title :</label>
				<input type='text' name='title' class='form-control'>
			</div>
			<div class='form-group'>
				<label>Slug :</label>
				<!--<input type='text' name='slug' class='form-control' placeholder='example'>-->
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon3"><b><?php echo base_url('p'); ?>/</b></span>
					<input type="text" name="slug" class="form-control" placeholder='page name' id="basic-url" aria-describedby="basic-addon3">
				</div>
			</div>
			<div class='form-group'>
				<label>Keywords :</label><br>
				<small><i>put this carracter "<b>,</b>" between two keywords.</i></small>
				<input type='text' name='keywords' class='form-control'>
			</div>
			<div class='form-group'>
				<label>Description :</label>
				<textarea name='desc' class='form-control' rows='5'></textarea>
			</div>
			<div class='form-group'>
				<label>Published :</label>
				<select name='published' class='form-control'>
					<option value='1'>Yes</option>
					<option value='0'>No</option>
				</select>
			</div>
			<div class='form-group'>
				<label>Show on the header (navbar) :</label>
				<select name='header' class='form-control'>
					<option value='1'>Yes</option>
					<option value='0'>No</option>
				</select>
			</div>
			<div class='form-group'>
				<label>Show on the footer :</label>
				<select name='footer' class='form-control'>
					<option value='1'>Yes</option>
					<option value='0'>No</option>
				</select>
			</div>
			<div class='form-group'>
				<label>Content :</label>
				<textarea name='content' class='form-control' rows='5'></textarea>
			</div>
			<div class='form-group'>
				<input type='submit' name='add' class='btn btn-primary' value='Add page'>
			</div>
		</form>
	</div>
</div>