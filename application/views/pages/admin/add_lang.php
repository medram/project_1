<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class="fa fa-plus-circle"></i> Add language
        </h1>
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
		<form action='<?php echo base_url($page_path); ?>/languages/add' method='post'>
			<div class='form-group'>
				<label>Language name :</label>
				<input type='text' name='name' class='form-control' placeholder='English'>
			</div>
			<div class='form-group'>
				<label>Language symbol :</label><br>
				<input type='text' name='symbol' class='form-control' placeholder='en_us'>
			</div>
			<div class='form-group'>
				<label>Language direction :</label>
				<select name='direction' class='form-control'>
					<option value='0'>LTR</option>
					<option value='1'>RTL</option>
				</select>
			</div>
			<div class='form-group'>
				<input type='submit' name='add' class='btn btn-primary' value='Add Language'>
			</div>
		</form>
	</div>
</div>