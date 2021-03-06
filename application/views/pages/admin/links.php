<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-link'></i> <?php echo $title; ?></h1>
</section>

<!-- Main content -->
<section class="content">
	<div class='row'>
		<div class='col-lg-12'>
			<div class='alert alert-info'>
				<b>Notes :</b>
				You can search about any links by :<br>
				- link title.<br>
				- link slug.<br>
				- User token.<br>
			</div>
			<div class='form-group'>
				<form action='<?php echo base_url($page_path); ?>/links' method='get'>
					<div class="input-group">
						<input type="text" class="form-control" name="search" placeholder="search for ..." 
						<?php
						if (isset($search))
						{
							echo "value='".htmlentities($search,ENT_QUOTES)."'";
						}
						?>
						>
						<span class="input-group-btn">
							<button class="btn btn-warning"><i class="fa fa-search"></i> Search</button>
						</span>
					</div>
				</form>
			</div>
			<?php
				echo "<i>Results : ".$all_items."</i>";
			?>
		</div>
	</div>
	<div class="row">
	    <div class="col-lg-12">
	    	<?php
	    	if ($links->num_rows() > 0)
	    	{
	    		foreach ($links->result_array() as $row)
	    		{

	    	?>
				<div class="panel panel-default">
				    <div class="panel-heading">
				        <div class="row">
				            <div class="col-xs-10">
				            	<b><i class='fa fa-link'></i> <?php echo $row['title']; ?></b>
				            </div>
				            <div class="col-xs-2 text-right">
				            	<span class='btn btn-xs btn-danger delete_link' id='<?php echo $row['id']; ?>'><i class="fa fa-trash-o"></i> delete</span>
				            	<a href='<?php echo base_url($page_path."/links/edit/".$row["slug"]); ?>' target='_blank' class='btn btn-xs btn-primary'><i class="fa fa-pencil"></i> edit</a>
				            </div>
				        </div>
				    </div>
					<div class="panel-body">
						<div class='row'>
							<div class='col-lg-12'>
								<i class="fa fa-clock-o"></i> <?php echo date(config_item('time_format'),$row['created']); ?>&nbsp;&nbsp;&nbsp;&nbsp;
								<i class="fa fa-eye"></i> <?php echo $row['views']; ?>
								&nbsp;&nbsp;&nbsp;&nbsp;
								#id (<?php echo $row['id']; ?>)
								&nbsp;&nbsp;&nbsp;&nbsp;
								<?php
								if ($row['status'] == 1)
								{
									echo "<div class='label label-success'>Active</div>";
								}
								else
								{
									echo "<div class='label label-danger'>Banned</div>";
								}
								?>
							</div>
						</div>
						<div class='row'>
							<div class="col-lg-6">
								<span>Origin link :</span>
								<div class='input-group input-group-sm'>
									<input class='form-control text-left' type='text' value="<?php echo htmlentities(decode($row['url']),ENT_QUOTES); ?>" >
									<span class='input-group-btn'>
										<button class='btn btn-primary copy' type='button'>Copy</button>
									</span>
								</div>
							</div>
							<div class="col-lg-6">
								<span>Shorted link :</span>
								<div class='input-group input-group-sm'>
									<input class='form-control text-left' type='text' value="<?php echo get_domains($row['domain']).'go/'.$row['slug']; ?>" >
									<span class='input-group-btn'>
										<button class='btn btn-primary copy' type='button'>Copy</button>
									</span>
								</div>
							</div>

						</div>
					</div>
				</div>
	    	<?php
	    		} // end foreach
	    	?>
	    	<div class='row'>
	    		<div class='col-lg-12'>
	    			<div class='pull-left'>
	    			<?php
	    			// $all_items,$num_per_page,$url,$lg='en'
	    			echo pagination($all_items,$links_per_page,base_url($page_path.'/links/p'));
	    			?>
	    			</div>
	    			<div class='pull-right'><i><?php echo $page."/".$all_pages." pages"; ?></i></div>
	    			<div class='clearfix'></div>
	    		</div>
	    	</div>
	    	<?php
	    	}
	    	else
	    	{
	    		echo "<div class='alert alert-info'><i class='fa fa-info-circle'></i> No links Found !</div>";
	    	}
	    	?>
	    </div>
	</div>

</section>