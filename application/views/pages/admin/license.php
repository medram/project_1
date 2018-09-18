<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-pencil"></i> License Checker: </h1>
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

                    if ($showForm) {
        			?>
        			<form action='<?php echo base_url($page_path); ?>/license' method='post'>
        				<div class='form-group'>
        					<label>License Code (Purchase code) :</label>
        					<input type='text' name='license-code' class='form-control' placeholder='xxxxx-xxxxx-xxxxx-xxxxx' value="<?php echo config_item('purchase_code') != '' ? config_item('purchase_code') : '' ?>">
        				</div>
        				<div class='form-group'>
        					<label>Action :</label>
        					<select name='license-action' class='form-control'>
        						<option value='0'>Activate License</option>
        						<option value='1'>Deactivate License</option>
        					</select>
        				</div>
                        <hr>
        				<div class='form-group'>
        					<input type='submit' name='license-go' class='btn btn-primary' value='Go !'>
        				</div>
        			</form>
                    <?php } ?>
        		</div>
        	</div>
        </div>
    </div>
</section>

