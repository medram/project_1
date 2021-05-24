<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-credit-card'></i> <?php echo $title; ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-body">
        	<div class="row">
                <div class="col-md-12"><?php echo get_messages(true) ?></div>
                <div class='col-lg-12 text-right'>
                    <a href='./payment_methods/add' class='btn btn-primary'><i class='fa fa-plus-circle fa-fw'></i> Add Payment Method</a>
                    <br>
                    <br>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Minimum Amount</th>
                                <th>status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $currency = get_currency();
                            if ($payment_methods)
                                foreach($payment_methods as $method)
                                {
                                    if ($method->status == 1)
                                        $status = "<span class='label label-success'>Active</span>";
                                    else
                                        $status = "<span class='label label-warning'>Inctive</span>";

                                    echo "<tr>
                                        <td>{$method->id}</td>
                                        <td>{$method->name}</td>
                                        <td>{$currency['symbol']}{$method->min_amount}</td>
                                        <td>{$status}</td>
                                        <td>
                                            <a href='payment_methods/edit/{$method->id}' class='btn btn-xs btn-primary'><i class='fa fa-fw fa-pencil'></i> Edit</a>
                                            <a class='btn btn-xs btn-danger deletePaymentMethod' id='{$method->id}'><i class='fa fa-fw fa-trash'></i>Delete</a>
                                        </td>
                                    </tr>";
                                }
                            else
                            {
                                echo "<tr><td colspan='3' class='text-center'>No payment methods.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

