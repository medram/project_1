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
		<form action='' method='post'>
			<div class='form-group'>
				<label>Language name :</label>
				<input type='text' class='form-control' disabled value='<?php echo $result['name'] ?>'>
			</div>
			<div class='form-group'>
				<label>Language symbol :</label><br>
				<input type='text' name='symbol' class='form-control' value='<?php echo $result['symbol'] ?>'>
			</div>
			<div class='form-group'>
				<label>Language direction :</label>
				<select name='direction' class='form-control'>
					<option value='0' <?php if(!$result['isRTL']) { echo 'selected';} ?> >LTR</option>
					<option value='1' <?php if($result['isRTL']) { echo 'selected';} ?> >RTL</option>
				</select>
			</div>
			<?php if ($result['id'] != 1){ ?>
			<div class='form-group'>
				<label>Status (ready to use on website):</label>
				<select name='status' class='form-control'>
					<option value='0' <?php if(!$result['active']) { echo 'selected';} ?> >Off</option>
					<option value='1' <?php if($result['active']) { echo 'selected';} ?> >On</option>
				</select>
			</div>
			<?php } ?>
			<hr>
			<div class='form-group'>
				<input type='submit' name='edit' class='btn btn-primary' value='Save'>
			</div>
		</form>
	</div>
</div>