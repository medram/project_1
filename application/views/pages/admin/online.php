<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class='fa fa-wifi'></i> <?php echo $title; ?>
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / <?php echo $title; ?>
            </li>
        </ol>
    </div>
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
    	<?php
    	if ($online->num_rows() > 0)
    	{

    	?>
    	<table class='table table-hover'>
    		<thead>
	    		<td><b>#id</b></td>
	    		<td><b>ip</b></td>
	    		<td><b>Platform</b></td>
	    		<td><b>Agent</b></td>
    		</tead>
    		<?php
    		foreach ($online->result_array() as $row)
    		{
    			echo "<tr>";
    				echo "<td>".$row['id']."</td>";
    				echo "<td>".$row['ip']."</td>";
    				echo "<td>".$row['platform']."</td>";
    				echo "<td>".$row['agent']."</td>";
    			echo "</tr>";
    		}
    		?>
    	</table>
    	<?php

    	}
    	else
    	{
    		echo "<div class='alert alert-warning'><i class='fa fa-fw fa-info-circle'></i> Data not found !</div>";
    	}
    	?>
    </div>
</div>