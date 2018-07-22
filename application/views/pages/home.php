<div class='jumbotron-background'>
    <div class="jumbotron text-center">
        <div class="container">
            <h1 class='h1'><?php langLine('theme.home.jumbotron.title') ?></h1>
            <p>
                <a class="btn btn-special btn-special-success btn-lg" href="<?php echo base_url('register'); ?>" role="button"><?php langLine('theme.home.jumbotron.registerForFree') ?></a>
            </p>
        </div>
    </div>
</div>
<div class="container-fluid" style='background: #EEE;'>
    <div class='row'>
        <div class='page-header text-center'>
            <h2><?php langLine('theme.home.title2') ?></h2>
        </div>
    </div>
    <div class="row text-center steps-box">
        <div class="col-md-4 col-xs-12">
            <div class='row'>
                <div class='col-xs-4 col-sm-12'>
                    <span class="fa-stack fa-5x" aria-hidden="true" style='color: #F6BB42;'>
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-link fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
                <div class='col-xs-8 col-sm-12 text-sm-right'>
                    <h2><?php langLine('theme.home.h2.1') ?></h2>
                    <p><?php langLine('theme.home.h2.p1') ?></p>                
                </div>
            </div>
        </div><!-- /.col-lg-4 -->
        <div class="col-md-4 col-xs-12">
            <div class='row'>
                <div class='col-xs-4 col-sm-12'>
                    <!--<img class="img-circle" src="" alt="Generic placeholder image" width="140" height="140">-->
                    <span class="fa-stack fa-5x" aria-hidden="true" style='color: #3BAFDA;'>
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-bullhorn fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
                <div class='col-xs-8 col-sm-12 text-sm-right'>
                    <h2><?php langLine('theme.home.h2.2') ?></h2>
                    <p><?php langLine('theme.home.h2.p2') ?></p>
                </div>
            </div>
        </div><!-- /.col-lg-4 -->
        <div class="col-md-4 col-xs-12">
            <div class='row'>
                <div class='col-xs-4 col-sm-12'>
                    <!--<img class="img-circle" src="" alt="Generic placeholder image" width="140" height="140">-->
                    <span class="fa-stack fa-5x" aria-hidden="true" style='color: #8CC152;'>
                        <i class="fa fa-circle fa-stack-2x"></i>
                        <i class="fa fa-line-chart fa-stack-1x fa-inverse"></i>
                    </span>
                </div>
                <div class='col-xs-8 col-sm-12 text-sm-right'>
                    <h2><?php langLine('theme.home.h2.3') ?></h2>
                    <p><?php langLine('theme.home.h2.p3') ?></p>
                </div>
            </div>
        </div><!-- /.col-lg-4 -->
    </div>
</div>
<!-- ads -->
<div class='container-fluid'>
    <div class='row'>
        <div class='col-lg-12'>
            <div class='text-center'>
            <?php
            echo get_ad();
            ?>
            </div>
        </div>
    </div>
</div>
<?php
if (get_config_item('showFakeNumbers'))
{
?>
<!-- show some analytics -->
<div class='container-fluid analytics-box'>
    <div class='row text-center'>
        <div class='col-md-4'>
            <i class='fa fa-fw fa-eye'></i> <?php echo get_config_item('fakeViews');?>
        </div>
        <div class='col-md-4'>
            <i class='fa fa-fw fa-users'></i> <?php echo get_config_item('fakeUsers');?>
        </div>
        <div class='col-md-4'>
            <i class='fa fa-fw fa-link'></i> <?php echo get_config_item('fakeLinks');?>
        </div>
    </div>
</div>
<?php
}
?>

