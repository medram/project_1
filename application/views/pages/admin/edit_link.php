<script type='text/javascript'>
	$(document).ready(function (){
		$('#edit_link').autosubmit('.msg','Saving ...');
	});
</script>
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class='fa fa-pencil'></i> <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / <?php echo $title; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class='row'>
	<?php
	if ($s->num_rows() != 1)
	{
	?>
	<div class='col-lg-12'>
		<div class='alert alert-danger'><i class='fa fa-lg fa-info-circle'></i> Not Found Link data !</div>
	<div>
	<?php
	}
	else
	{
		$row = $s->row_array();
	?>
	<div class='col-lg-8'>
		<div class='msg'></div>
		<form id='edit_link' action='<?php echo base_url($page_path."/ajax"); ?>' method='post'>
			<div class='form-group'>
				<label>Title :</label>
				<input type='text' name='title' class='form-control' value='<?php echo htmlentities($row['title'],ENT_QUOTES); ?>'>
			</div>
			<div class='form-group'>
				<label>Origin url :</label>
				<input type='text' name='origin_url' class='form-control' value='<?php echo htmlentities(decode($row['url']),ENT_QUOTES); ?>'>
			</div>
			<div class='form-group'>
				<label>Shorted url :</label>
				<div class="input-group">
					<span class="input-group-addon" id="basic-addon3"><b>http://localhost/ci/go/</b></span>
					<input type="text" name="new_slug" class="form-control" id="basic-url" aria-describedby="basic-addon3" value='<?php echo $row['slug']; ?>' >
				</div>
			</div>
			<div class='form-group'>
				<label>Status :</label>
				<select name='status' class='form-control'>
					<option value='1' <?php if ($row['status'] == 1){echo "selected";} ?> >Active</option>
					<option value='0' <?php if ($row['status'] == 0){echo "selected";} ?> >Banned</option>
				</select>
			</div>
			<div class='form-group'>
				<input type='hidden' name='slug' value='<?php echo $row['slug']; ?>'>			
				<input type='hidden' name='link_id' value='<?php echo $row['id']; ?>'>		
				<button name='edit_link' class='btn btn-primary'>Save data</button>
			</div>
		</form>
	</div>
	<div class='col-lg-4'>
		<div class='well'>
			<?php
			if ($user_info->num_rows() == 1)
			{
				$user_info = $user_info->row_array();

				echo "<img src='".get_profile_img($user_info['user_token'])."' class='pro-img img-circle ' width='70px' height='70px' ><hr>";
				
				echo "<b>User info</b><br>";
				echo "id : ".$user_info['id'].'<br>';
				echo "Username : ".$user_info['username'].'<br>';
				echo 'E-mail : '.$user_info['email'].'<br>';
				echo 'gender : ';
				if ($user_info['gender'] == 1)
				{
					echo "Male<br>";
				}
				else if ($user_info['gender'] == 2)
				{
					echo "Female<br>";
				}

				switch ($user_info['account_status'])
				{
					case 0: echo 'Account status : Active'; break;
					case 1: echo 'Account status : inactive'; break;
					case 2: echo 'Account status : Banned'; break;
				}
				echo "<hr><b>Link info</b><br>";
				echo "Created : ".date(config_item('time_format'),$row['created']).'<br>';
				echo "Modified : ".date(config_item('time_format'),$row['modified']).'<br>';

			}
			else
			{
				echo "Unknown !";
			}
			?>
		</div>
	</div>
	<?php
	} // end else
	?>
</div>