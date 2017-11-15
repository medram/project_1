<link type='text/css' rel='stylesheet' href='<?php echo base_url(); ?>js/morris/morris.css' >
<script type='text/javascript' src='<?php echo base_url(); ?>js/morris/raphael-min.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/morris/morris.min.js'></script>

<?php

if ($s_st->num_rows() > 0)
{
	$a = array();
	foreach ($s_st->result_array() as $k => $row)
	{
		$a[$k]['date'] = $row['date'];
		$a[$k]['views'] = $row['views'];
	}


	$day = date("d-m-Y",time());
	$a1 = array();
	for ($i = 0; $i <= 30; $i++)
	{
		$date = date("Y-m-d",strtotime($day)-($i*24*3600));
		foreach ($a as $k => $row)
		{
			if (in_array($date,$row))
			{
				$a1[] = $row;
				break;
			}
			else if ($k == count($a)-1)
			{
				$a1[] = array('date'=>$date,'views'=>0);
				break;
			}
		}
	}

	$a2 = $a1;
	sort($a1);
	/*
	echo "<pre dir='ltr'>";
	print_r($a1);
	echo "</pre>";
	*/
	/*
	$a2 = array();
	for ($i = count($a1); $i > 0; $i--)
	{
		$a2[] = $a1[$i-1];
	}
	*/

	$all_views = 0;

	$d = "[";
	foreach ($a1 as $row)
	{
		$d .= "{x: '".$row['date']."', y: ".$row['views']."},";
		$all_views = $all_views + $row['views'];
	}
	$d .= "]";
}

?>

<script type='text/javascript'>
	$(document).ready(function (){

		Morris.Area({
			element: 'graph',
			behaveLikeLine: true,
			data: <?php echo $d; ?>,
			xkey: 'x',
			ykeys: ['y'],

			labels: [' المشاهدات '],
            lineColors: ['#3BAFDA','#8CC152',"#8CC152","#F6BB42","#DA4453","#434A54",'#37BC9B'],
            lineWidth: 2,
            smooth: true,

            pointSize: 3,

            hideHover: true,
            parseTime: false,
            grid: true,
            gridTextSize: 12,
            gridTextColor: '#656D78',
            xLabelAngle: 35,
            resize: true,
		});

	});
</script>

<div class='container'>

<?php
if (!isset($userdata['user_pub']) || empty($userdata['user_pub']))
{

?>
<div class='row'>
	<div class='col-md-12'>
		<div class='alert alert-warning'>
			<i class='fa fa-info-circle fa-lg fa-fw'></i> لتتمكن من عرض اعلاناتك على روابطك المختصرة ، عليك بإدخال كود pub الخاص بك على google adsense من <a href='<?php echo base_url($page_path)."/settings"; ?>'>هنــــــا</a>
		</div>
	</div>
</div>
<?php

}

?>
	<div class='row'>
		<?php
		echo $sidebar;
		?>
		<div class='col-md-9'>
			<div class='row'>
				<div class='col-lg-12 page-header'>
					<h1><i class="fa fa-fw fa-pie-chart"></i> إحصاءاتي</h1>
				</div>
			</div>
			<?php
			if ($s_st->num_rows() > 0)
			{
			?>
			<div class='row'>
				<div class='col-md-4'>
					<div class="panel panel-success">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3 text-right">
					                <i class="fa fa-eye fa-4x"></i>
					            </div>
					            <div class="col-xs-9 text-right">
					                <div class="huge"><?php echo $all_views; ?></div>
					                <div>عدد المشاهدات الكلية لآخر 30 يوما</div>
					            </div>
					        </div>
					    </div>
					</div>
				</div>
				<div class='col-md-4'>
					<div class="panel panel-danger">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3 text-right">
					                <i class="fa fa-chain-broken fa-4x"></i>
					            </div>
					            <div class="col-xs-9 text-right">
					                <div class="huge"><?php echo $all_links; ?></div>
					                <div>عدد الروابط المختصرة</div><br>
					            </div>
					        </div>
					    </div>
					</div>		
				</div>
				<div class='col-md-4'>
					<div class="panel panel-warning">
					    <div class="panel-heading">
					        <div class="row">
					            <div class="col-xs-3 text-right">
					                <i class="fa fa-eye fa-4x"></i>
					            </div>
					            <div class="col-xs-9 text-right">
					                <div class="huge"><?php echo $all_linls_views; ?></div>
					                <div>عدد المشاهدات الكلية للروابط</div><br>
					            </div>
					        </div>
					    </div>
					</div>		
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-12'>
					<div class="panel panel-info">
						<div class="panel-heading"><b><i class='fa fa-lg fa-fw fa-area-chart'></i> إحصاءات آخر 30 يوما</b></div>
						<div class="panel-body">
							<div id='graph' style='width: 100%; height: 400px;'></div>
						</div>
					</div>
					<br>
				</div>
			</div>
			<div class='row'>
				<div class='col-lg-12'>
					<table class='table table-striped table-hover'>
						<thead>
							<th>الأيام</th>
							<th>عدد المشاهدات</th>
						</thead>
						<tbady>
						<?php

						foreach ($a2 as $row)
						{
							echo "<tr>";
								echo "<td>".$row['date']."</td>";
								echo "<td>".$row['views']."</td>";
							echo "</tr>";
						}
						?>
						</tbady>
					</table>
				</div>
			</div>
			<?php
			}
			else
			{

			?>
			<div class='row'>
				<div class='col-lg-12'>
					<div class='alert alert-info'><i class='fa fa-info-circle'></i> لا توجد بيانات كافية لعرضها لحد الآن</div>
				</div>
			</div>
			<?php

			}
			?>
		</div>
	</div>
</div>
