<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-list-ul"></i> <?php echo $title ?> </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-body">
        	<div class='row'>
                <div class="col-md-12"><?php echo get_messages(true) ?></div>

                <form action='' method='post'>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save</button>
                    </div>
                    <?php
                    $country_chunks = array_chunk($countries, ceil(count($countries)/2));

                    foreach($country_chunks as $key => $country_chunk) {
                    ?>
                    <div class='col-md-6'>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Flag</th>
                                    <th>Country</th>
                                    <th>Cost per 1000 Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($country_chunk as $country){ ?>
                                    <tr>
                                        <td><?php echo "<i class='flag-icon flag-icon-".$country->code."'></i></td>" ?>
                                        <td><?php echo $country->name ?></td>
                                        <td>
                                            <?php
                                                echo "<input type='text' name='countries[".$country->country_id."]' value='".$country->price."' placeholder='Publisher Price' class='form-control'>"
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </div>
                    <?php } ?>
                    <div class="col-md-12 text-right">
                        <button type="submit" class="btn btn-primary"><i class="fa fa-fw fa-save"></i> Save</button>
                    </div>
                </form>
        	</div>
        </div>
    </div>
</section>
