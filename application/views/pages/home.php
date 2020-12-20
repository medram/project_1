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
<div class="container-fluid">
    <div class='row'>
        <div class='page-header text-center'>
            <h2><?php langLine('theme.home.title2') ?></h2>
        </div>
    </div>
    <div class="row text-center steps-box">
        <div class="container">
            <div class="col-md-4 col-xs-12">
                <div class='row'>
                    <div class='col-xs-4 col-sm-12'>
                        <img src="img/create_more_links.png" width="300">
                    </div>
                    <div class='col-xs-8 col-sm-12 text-sm-right'>
                        <h2 class="primary-color"><?php langLine('theme.home.h2.1') ?></h2>
                        <p><?php langLine('theme.home.h2.p1') ?></p>
                    </div>
                </div>
            </div><!-- /.col-lg-4 -->

            <div class="col-md-4 col-xs-12">
                <div class='row'>
                    <div class='col-xs-4 col-sm-12'>
                        <!--<img class="img-circle" src="" alt="Generic placeholder image" width="140" height="140">-->
                        <img src="img/share_on_social_media.png" width="300">
                    </div>
                    <div class='col-xs-8 col-sm-12 text-sm-right'>
                        <h2 class="primary-color"><?php langLine('theme.home.h2.2') ?></h2>
                        <p><?php langLine('theme.home.h2.p2') ?></p>
                    </div>
                </div>
            </div><!-- /.col-lg-4 -->
            <div class="col-md-4 col-xs-12">
                <div class='row'>
                    <div class='col-xs-4 col-sm-12'>
                        <!--<img class="img-circle" src="" alt="Generic placeholder image" width="140" height="140">-->
                        <img src="img/earn_more_profit.png" width="300">
                    </div>
                    <div class='col-xs-8 col-sm-12 text-sm-right'>
                        <h2 class="primary-color"><?php langLine('theme.home.h2.3') ?></h2>
                        <p><?php langLine('theme.home.h2.p3') ?></p>
                    </div>
                </div>
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
<div class='container-fluid contact-us-box'>
    <div class='row'>
        <div class='col-md-5'>
            <img src="img/help.png" style="float:right">
        </div>
        <div class='col-md-6'>
            <div class='text'>
                <h2>Need help? Contact us</h2>
                <p>For any help or suggestions please feel free to contact us.</p>
                <a class="btn btn-success" href="<?php echo base_url('p/contact') ?>">Contact us!</a>
            </div>
        </div>
    </div>
</div>

