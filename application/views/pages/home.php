<div class=''>
    <div class="jumbotron">
        <div class="row">
            <div class="container">
                <div class="left-box">
                    <h1 class='h1'><?php langLine('theme.home.jumbotron.title') ?></h1>
                    <p>
                        <a class="btn btn-special btn-special-success btn-lg" style="font-size: 2.5rem; margin-top: 0.5em" href="<?php echo base_url('register'); ?>" role="button"><?php langLine('theme.home.jumbotron.registerForFree') ?></a>
                    </p>
                </div>
                <div class="right-box">
                    <img src="<?php echo base_url('img/1-tra.png') ?>" width="600">
                </div>
            </div>
        </div>
    </div>
</div>
<div class="container-fluid">
    <div class='row'>
        <div class='page-header text-center'>
            <h2><?php langLine('theme.home.title2') ?></h2>
        </div>
    </div>
    <div class="row text-center steps-box">
        <div class="container">
            <div class="col-md-4 col-xs-12">
                <img src="img/create_more_links.png" width="300">
                <h2 class="primary-color"><?php langLine('theme.home.h2.1') ?></h2>
                <p><?php langLine('theme.home.h2.p1') ?></p>
            </div><!-- /.col-lg-4 -->

            <div class="col-md-4 col-xs-12">
                <!--<img class="img-circle" src="" alt="Generic placeholder image" width="140" height="140">-->
                <img src="img/share_on_social_media.png" width="300">
                <h2 class="primary-color"><?php langLine('theme.home.h2.2') ?></h2>
                <p><?php langLine('theme.home.h2.p2') ?></p>
            </div><!-- /.col-lg-4 -->
            <div class="col-md-4 col-xs-12">
                <!--<img class="img-circle" src="" alt="Generic placeholder image" width="140" height="140">-->
                <img src="img/earn_more_profit.png" width="300">
                <h2 class="primary-color"><?php langLine('theme.home.h2.3') ?></h2>
                <p><?php langLine('theme.home.h2.p3') ?></p>
            </div><!-- /.col-lg-4 -->
        </div>
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
    <div class="container">
        <div class='row text-center'>
            <div class='col-md-4'>
                +<?php echo get_config_item('fakeViews');?>
                <i class='fa fa-fw fa-eye'></i>
            </div>
            <div class='col-md-4'>
                +<?php echo get_config_item('fakeUsers');?>
                <i class='fa fa-fw fa-users'></i>
            </div>
            <div class='col-md-4'>
                +<?php echo get_config_item('fakeLinks');?>
                <i class='fa fa-fw fa-link'></i>
            </div>
        </div>
    </div>
</div>
<?php
}
?>
<!-- Contact us -->
<div class='container-fluid'>
    <div class="container contact-us-box">
        <img src="img/help.png">
        <div class='text'>
            <h2><?php echo langLine('theme.home.h2.4') ?></h2>
            <p><?php echo langLine('theme.home.h2.p4') ?></p>
            <a class="btn btn-success" href="<?php echo base_url('p/contact') ?>"><?php echo langLine('theme.home.h2.button') ?></a>
        </div>
    </div>
</div>

