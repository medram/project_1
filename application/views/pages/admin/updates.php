<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-calendar"></i> <?php echo $title ?> </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-body">
        	<div class='row'>
        		<div class='col-md-8'>
                    <div>
                        <?php $status = config_item('purchase_code') != ''? "<span class='label label-success'>Active</span>" : "<span class='label label-danger'>Deactive</span>" ?>
                        <h3><i class="fa fa-fw fa-check"></i> License Information: <small title="status"><?php echo $status; ?></small></h3>
                        <div><p><b>Note:</b> you can activate and deactivate your license (purchase code) easily from here.</p></div>
                        <div class="input-group input-group-sm">
                            <input type="text" class="form-control" value="<?php echo config_item('purchase_code');?>" disabled>
                            <!-- <b><a href='license'>Active / Deactivate</a> License.</b> -->       
                            <span class="input-group-btn"><a href='license' class="btn btn-primary">Activate / Deactivate</a></span>
                        </div>
                        <hr>
                    </div>
                    <div>
                    <h3><i class="fa fa-fw fa-wrench"></i> ADLinker Updates:</h3>
                    <?php
                    if (!is_array($update))
                    {
                        echo "<div class='text-center'>{$update}</div><br>";
                    }
                    else
                    {
                        /*
                        echo "<pre>";
                        print_r($update);
                        echo "</pre>";
                        */
                    ?>
                    <div class="panel panel-default">
                        <div class="panel-heading">
                            <div class="row">
                                <div class="col-xs-10">
                                    <b><?php echo "<b>".$update['product_name']." v".$update['product_version'].'</b> is Available Now.<br>'; ?></b>
                                </div>
                                <div class="col-xs-2 text-right">
                                    <a href="#" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-link"></i> Update Now</a>
                                </div>
                            </div>
                        </div>
                        <div class="panel-body">
                            <div class="row">
                                <div class="col-lg-12">
                                    <?php echo '<b>New Features :</b><br><br>'; ?>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="list-group">
                                    <?php
                                    foreach (json_decode($update['features'], true) as $feature)
                                    {
                                        echo "<span class='list-group-item'><i class='fa fa-fw fa-check' style='color: green;'></i> {$feature['desc']}</span>";
                                    }
                                    ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php } ?>
                    </div>
        		</div>
        		<div class='col-md-4'>
                    <div>
                        <?php
                        
                        /*
                        echo "<pre>";
                        print_r($news);
                        echo "</pre>";
                        */
                        
                        if (is_array($news) && count($news)) {
                            echo "<h3><b>MR4Web</b> News:</h3>";
                            foreach ($news as $n) {
                        ?>
                            <div class="panel panel-default">
                                <div class="panel-heading">
                                    <div class="row">
                                        <div class="col-xs-10">
                                            <a href="<?php echo $n['news_URL'] ?>" target="_blank"><b><?php echo $n['title']; ?></b></a>
                                        </div>
                                        <!-- <div class="col-xs-2 text-right">
                                            <a href="#" target="_blank" class="btn btn-xs btn-primary"><i class="fa fa-link"></i> Update Now</a>
                                        </div> -->
                                    </div>
                                </div>
                                <?php if ($n['image_URL'] != ''){ ?>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <a href="<?php echo $n['news_URL'] ?>" target="_blank"><img src="<?php echo $n['image_URL']; ?>" class="img-responsive" title="<?php echo $n['title'] ?>"></a>
                                    </div>
                                </div>
                                <?php } ?>
                                <div class="panel-body">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <?php echo $n['description'];?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php 
                            } // end loop
                        } // end if
                        ?>
                    </div>
                    <div>
                        <h3><i class="fa fa-fw fa-support"></i> Support:</h3>
                        <div>
                            <p>feel free to contact us:</p>
                            <b>support:</b> <a href="mailto:support-adlinker@mr4web.com">support-adlinker@mr4web.com</a><br>
                            <b>contact:</b> <a href="mailto:contact@mr4web.com">contact@mr4web.com</a>
                        </div>
                        <br>
                    </div>
        		</div>
        	</div>
        </div>
    </div>
</section>