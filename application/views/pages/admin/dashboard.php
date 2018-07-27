<link type='text/css' rel='stylesheet' href='<?php echo base_url(); ?>js/morris/morris.css' >
<script type='text/javascript' src='<?php echo base_url(); ?>js/morris/raphael-min.js'></script>
<script type='text/javascript' src='<?php echo base_url(); ?>js/morris/morris.min.js'></script>
<script type='text/javascript'>
    $(document).ready(function (){

        Morris.Donut({
            element: 'graph-bar',
            data: <?php echo $domains_info; ?>,
            resize: true,
            colors: ["#967ADC","#DA4453","#F6BB42","#8CC152",'#3BAFDA','#8CC152',"#434A54",'#37BC9B'],
        });

        /*--------------- graph1 ---------------*/
        Morris.Line({
            element: 'graph1',
            behaveLikeLine: false,

            data: [<?php echo $all_d; ?>],
            xkey: 'x',
            ykeys: ['y1','y2'],
            labels: [' Admin views ',' Users views '],
            
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


<!-- Page Heading -->
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-dashboard"></i> Dashboard</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="row">
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-aqua"><i class="fa fa-link"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Links</span>
                    <span class="info-box-number"><?php echo $all_links; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-green"><i class="fa fa-wifi"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Online</span>
                    <span class="info-box-number"><?php echo $online; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <!-- fix for small devices only -->
        <div class="clearfix visible-sm-block"></div>

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-yellow"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Users <br>(Verified emails)</span>
                    <span class="info-box-number"><?php echo $all_users_verified; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->

        <div class="col-md-3 col-sm-6 col-xs-12">
            <div class="info-box">
                <span class="info-box-icon bg-red"><i class="ion ion-ios-people-outline"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Users <br>(Not verified emails yet)</span>
                    <span class="info-box-number"><?php echo $all_users_no_verified; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>

    <div class='row'>
        <div class="col-md-4 col-sm-6">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion-ios-eye"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Admin views on this day</span>
                    <span class="info-box-number"><?php echo $views_this_day_admin; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion-ios-eye"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">All admin views on 30 days</span>
                    <span class="info-box-number"><?php echo $all_views_admin_30_day; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    
        <div class="col-md-4 col-sm-6">
            <div class="info-box bg-aqua">
                <span class="info-box-icon"><i class="ion-ios-eye"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">All admin views</span>
                    <span class="info-box-number"><?php echo $all_views_admin; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>


        <div class="col-md-4 col-sm-6">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion-ios-eye"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">Users views on this day</span>
                    <span class="info-box-number"><?php echo $views_this_day; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

        <div class="col-md-4 col-sm-6">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion-ios-eye"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">All users views on 30 days</span>
                    <span class="info-box-number"><?php echo $all_views_users_30_day; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>
    
        <div class="col-md-4 col-sm-6">
            <div class="info-box bg-green">
                <span class="info-box-icon"><i class="ion-ios-eye"></i></span>

                <div class="info-box-content">
                    <span class="info-box-text">All users views</span>
                    <span class="info-box-number"><?php echo $all_views_users; ?></span>
                </div>
                <!-- /.info-box-content -->
            </div>
        </div>

    </div>
    <!-- /.row -->

    <!-- Graph -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-info">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-area-chart fa-fw"></i> Views on last 30 days</h3>
                </div> <!-- /.box-header -->
                <div class="box-body">
                    <div id="graph1"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->

    <!-- Graph -->
    <div class="row">
        <div class="col-lg-12">
            <div class="box box-success">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-globe fa-fw"></i> Links at Domains package</h3>
                </div> <!-- /.box-header -->
                <div class="box-body">
                    <div id="graph-bar"></div>
                </div>
            </div>
        </div>
    </div>
    <!-- /.row -->


    <div class="row">
        <div class="col-md-7">
            <div class="box box-danger">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-link fa-fw"></i> Last links</h3>
                </div>
                <div class="box-body">
                    <div class='col-md-12' style='overflow-x: auto;'>
                        <?php
                        if (isset($lastLinks))
                        {
                        ?>
                        <table class='table table-hover'>
                            <?php
                            /*
                            echo "<pre>";
                            print_r($lastLinks);
                            echo "</pre>";
                            */
                            foreach ($lastLinks as $row)
                            {
                                echo "<tr>";
                                    echo "<td>
                                        <img src='".get_profile_img($row['userInfo']['user_token'])."' class='pro-img img-circle ' width='35px' height='35px' >
                                    </td>";
                                    echo "<td>
                                        <a href='".decode($row['link']['url'])."'><b>".$row['link']['title']."</b></a><br>
                                        <small>".decode($row['link']['url'])."</small>
                                        </td>";
                                    echo "<td><i class='fa fa-eye'></i> ".$row['link']['views']."</td>";
                                echo "</tr>";
                            }

                            ?>
                        </table>
                        <?php
                        }
                        else
                        {
                            echo '<b>Data Note Found !</b>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5">
            <div class="box box-warning">
                <div class="box-header with-border">
                    <h3 class="box-title"><i class="fa fa-users fa-fw"></i> Last users</h3>
                </div>
                <div class="box-body">
                    <?php
                    if (isset($lastUsers))
                    {
                    ?>
                    <table class='table table-hover'>
                        <thead>
                            <td style="vertical-align: middle;"><b>ID</b></td>
                            <td colspan='2'><b>Info</b></td>
                            <td><b>Registration date</b></td>
                        </thead>
                        <?php
                        foreach ($lastUsers as $row)
                        {
                            echo "<tr>";
                                echo "<td style='vertical-align: middle;'>".$row['id']."</td>";
                                echo "<td>
                                    <img src='".get_profile_img($row['user_token'])."' class='pro-img img-circle ' width='35px' height='35px' >
                                </td>";
                                echo "<td>
                                    <b>".$row['username']."</b>
                                    ";
                                    if ($row['user_verified'] == 1)
                                    {
                                        echo "<i style='color: #8CC152;' class='fa fa-check fa-fw' title='account activated'></i>";
                                    }
                                    else
                                    {
                                        echo "<i style='color: #DA4453;' class='fa fa-times fa-fw' title='account not activated'></i>"; 
                                    }
                                echo "<br>
                                    <small>".$row['email']."</small>
                                    </td>";
                                echo "<td style='vertical-align: middle;'>";
                                echo date(config_item('time_format'), $row['user_joined']);
                                echo "</td>";
                            echo "</tr>";
                        }

                        ?>
                    </table>
                    <?php
                    }
                    else
                    {
                        echo '<b>Data Note Found !</b>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
    
</section>
            




