<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-list-ul"></i> <?php echo $title ?> </h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-body">
        	<div class='row'>
        		<div class='col-md-12'>
                    <form action='' method='post'>
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>Flag</th>
                                    <th>Country</th>
                                    <th>Cost per 1000 Views</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($countries as $country){ ?>
                                    <tr>
                                        <td><?php echo "<i class='flag-icon flag-icon-".$country->code."'></i></td>" ?>
                                        <td><?php echo $country->name ?></td>
                                        <td>
                                            <?php
                                                echo "<input type='text' name='countries[]' value='".$country->price."' placeholder='Publisher Price' class='form-control'>"
                                            ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            </tbody>
                        </table>
                    </form>
                </div>
        	</div>
        </div>
    </div>
</section>
