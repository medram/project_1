<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-pencil"></i> <?php echo $title ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-body">
        	<div class='row'>
        		<div class='col-lg-8'>
                    <div class="col-md-12"><?php echo get_messages(true) ?></div>
        			<form action='<?php echo base_url($page_path); ?>/withdrawal_methods/edit/<?php echo $method->id ?>' method='post'>
        				<div class='form-group'>
        					<label>Name:</label>
        					<input type='text' name='name' class='form-control' value="<?php echo $method->name ?>" placeholder='e.g. PayPal' >
        				</div>
        				<div class='form-group'>
        					<label>Minimum Amount to Withdraw (in <?php echo get_currency()['name'] ?>):</label><br>
                            <div class="input-group">
                                <input type="number" class="form-control" name='min_amount' placeholder='e.g. 50' value="<?php echo $method->min_amount ?>">
                                <span class="input-group-addon"><?php echo get_currency()['symbol'] ?></span>
                            </div>
        				</div>
        				<div class='form-group'>
        					<label>Status:</label>
        					<select name='status' class='form-control'>
        						<option value='0' <?php echo !$method->status ? 'selected' : '' ?> >Inactive</option>
        						<option value='1' <?php echo $method->status ? 'selected' : '' ?> >Active</option>
        					</select>
        				</div>
                        <div class='form-group'>
                            <label>Description for users:</label>
                            <textarea name='desc' class='form-control' placeholder='e.g. For PayPal, add your email.' ><?php echo $method->description ?></textarea>
                        </div>
        				<div class='form-group'>
        					<input type='submit' name='add' class='btn btn-primary' value='Add Withdrawal Method'>
        				</div>
        			</form>
        		</div>
        	</div>
        </div>
    </div>
</section>

