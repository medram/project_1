<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-users"></i> Users</h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="box box-warning">
	    <div class="box-header with-border">
	        <h3 class="box-title">Users list</h3>
	    </div>
	    <div class="box-body">
			<div class='row'>
				<div class='col-lg-12'>
					<form action='<?php echo base_url($page_path); ?>/users' method='GET'>
						<div class='form-group'>
							<label>Search for users :</label>
							<div class="input-group">
							  <input type="text" name='q_user' class="form-control" placeholder="Search for..." 
							  	value='<?php if (isset($string) && $string != ''){echo $string;} ?>' >
							  <span class="input-group-btn">
							    <button class="btn btn-success" type="submit">Go!</button>
							  </span>
							</div><!-- /input-group -->
						</div>
					</form>
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-12'>
				<?php
				if (isset($ops) && $ops != '')
				{
					echo "<div style='text-align: center; height: 200px;'><b>".$ops."</b></div>";
				}
				else
				{
				?>
						<table class='table table-striped'>
							<tr>
								<th>ID</th>
								<th>Username</th>
								<th>Email</th>
								<th>Info</th>
								<th>Action</th>
							</tr>
							<?php
							foreach ($row as $k => $r)
							{

								$u_verified = ($r['user_verified'] == 1)? "<i class='fa fa-check' style='color: green;' 
									data-toggle='tooltip' data-placement='right' title='Confirmed Account'></i>" : "<i class='fa fa-times' style='color: red;' 
									data-toggle='tooltip' data-placement='right' title='Not confirmed Account'></i>" ;
								echo "<tr>";
									echo "<td style='vertical-align: middle;'>".$r['id']."</td>";
									echo "<td style='vertical-align: middle;'>
											<img src='".get_profile_img($r["user_token"])."' 
												class='img-circle' width='50px' height='50px' >
											".$r['username']."
										</td>";
									echo "<td style='vertical-align: middle;'>".$r['email']." ".$u_verified."</td>";
									echo "<td style='vertical-align: middle;'>
											<b>Registered: </b>".date(config_item("time_format"),$r['user_joined'])."<br><b>Account Status : </b>";
											if ($r['account_status'] == 1){echo "<span class='badge badge-warning'>Inactive</span>";}
											else if ($r['account_status'] == 2){echo "<span class='badge badge-danger'>Banned</span>";}
											else{ echo "<span class='badge badge-success'>Active</span>"; }
									echo "</td>";
									echo "<td style='vertical-align: middle;'>
											<a href='".base_url($page_path)."/u/edit/".$r['id']."' target='_blank' 
												class='btn btn-primary btn-xs' ><i class='fa fa-pencil'></i> Edit</a> 
											<span class='btn btn-xs btn-danger delete' id='".$r['id']."' ><i class='fa fa-times'></i> Delete</span>
										  </td>
										";
								echo "</tr>";
							}
							?>
						</table>
						<div style='text-align: right;'><small><i><?php echo $page."/".$all_pages; ?> pages (<?php echo $total_users; ?> Users)</i></small></div>
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-12'>
					<?php
					echo $pagination;
					?>

				<?php
				}
				?>
				</div>
			</div>
	    </div>
	</div>

</section>

