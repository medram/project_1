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
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">
            <i class='fa fa-dashboard'></i> Dashboard
        </h1>
    </div>
</div>
<!-- /.row -->


<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $all_users_verified; ?></div>
                        <div>Users (emails verified)</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url($page_path); ?>/users">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $all_users_no_verified; ?></div>
                        <div>Users (emails not verified yet)</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url($page_path); ?>/users">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-3 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-wifi fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $online; ?></div>
                        <div>Online visitors</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url($page_path); ?>/online">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-link fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $all_links; ?></div>
                        <div>Links</div>
                    </div>
                </div>
            </div>
            <a href="<?php echo base_url($page_path); ?>/links">
                <div class="panel-footer">
                    <span class="pull-left">View Details</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>

</div>
<!-- /.row -->
<div class='row'>

</div>

<!-- users data -->
<div class='row'>
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-eye fa-5x"></i>
                    </div>
                   <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $views_this_day; ?></div>
                        <div>Users views on this day</div>
                    </div> 
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-eye fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $all_views_users_30_day; ?></div>
                        <div>All users views on 30 days</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-eye fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $all_views_users; ?></div>
                        <div>All users views</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
<!-- admin data -->
    <div class="col-lg-4 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-eye fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $views_this_day_admin; ?></div>
                        <div>Admin views on this day</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-eye fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $all_views_admin_30_day; ?></div>
                        <div>All admin views on 30 days</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4 col-md-6">
        <div class="panel panel-info">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-eye fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-right">
                        <div class="huge"><?php echo $all_views_admin; ?></div>
                        <div>All admin views</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<!-- Graph -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-area-chart fa-fw"></i> Views on last 30 days</h3>
            </div>
            <div class="panel-body">
                <div id="graph1"></div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<!-- Graph -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-globe fa-fw"></i> Domains package</h3>
            </div>
            <div class="panel-body">
                <div id="graph-bar"></div>
            </div>
        </div>
    </div>
</div>
<!-- /.row -->

<div class="row">
    <div class="col-lg-7">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-link fa-fw"></i> Last links</h3>
            </div>
            <div class="panel-body">
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
    <div class="col-lg-5">
        <div class="panel panel-green">
            <div class="panel-heading">
                <h3 class="panel-title"><i class="fa fa-users fa-fw"></i> Last users</h3>
            </div>
            <div class="panel-body">
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
<!-- /.row -->

            




