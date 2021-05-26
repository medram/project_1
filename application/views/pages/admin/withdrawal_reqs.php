<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-usd'></i> <?php echo $title; ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-body">
        	<div class="row">
                <div class="col-md-12"><?php echo get_messages(true) ?></div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>User</th>
                                <th>Amount</th>
                                <th>Withdrawal Method</th>
                                <th>Withdrawal Account</th>
                                <th>Created</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            $currency = get_currency();
                            if ($result)
                                foreach($result as $row)
                                {
                                    /*
                                    if ($row->status == 1)
                                        $status = "<span class='label label-success'>Active</span>";
                                    else
                                        $status = "<span class='label label-warning'>Inctive</span>";
                                    */
                                    echo "<tr>
                                        <td style='vertical-align: middle;'>{$row->id}</td>
                                        <td style='vertical-align: middle;'>
                                            <a href='u/edit/{$row->user_id}'>
                                                <img src='/uploads/users/profile-images/".md5($row->user_token).".png?v=".time()."' class='img-circle' width='50' >
                                                <b>{$row->username}</b> ({$row->email})
                                            </a>
                                        </td>
                                        <td style='vertical-align: middle;'>{$currency['symbol']}{$row->min_amount}</td>
                                        <td style='vertical-align: middle;'>{$row->name}</td>
                                        <td style='vertical-align: middle;'>{$row->withdrawal_account}</td>
                                        <td style='vertical-align: middle;'>".date(get_config_item('time_format'), strtotime($row->created))."</td>
                                        <td style='vertical-align: middle;'>
                                            <select name='status' class='form-control statusSelector'>
                                                <option value='0' ".($row->status == 0 ? 'selected' : '').">Pending</option>
                                                <option value='1' ".($row->status == 1 ? 'selected' : '').">Approved</option>
                                                <option value='2' ".($row->status == 2 ? 'selected' : '').">Completed</option>
                                                <option value='3' ".($row->status == 3 ? 'selected' : '').">Cancelled</option>
                                                <option value='4' ".($row->status == 4 ? 'selected' : '').">Returned</option>
                                            </select>
                                        </td>
                                        <td style='vertical-align: middle;'>
                                            <a class='btn btn-xs btn-primary saveWithdrowRequestStatus' data-status-id='{$row->status}' id='{$row->id}'><i class='fa fa-fw fa-check'></i> Save status</a>
                                            <a class='btn btn-xs btn-danger deleteWithdrowRequest' id='{$row->id}'><i class='fa fa-fw fa-trash'></i>Delete withdraw</a>
                                        </td>
                                    </tr>";
                                }
                            else
                            {
                                echo "<tr><td colspan='8' class='text-center'>No withdrawal requests.</td></tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
                <div class="col-lg-12">
                    <ul>
                        <li><b>Pending</b>: The payment is being checked.</li>
                        <li><b>Approved</b>: The payment has been approved and is waiting to be sent.</li>
                        <li><b>Complete</b>: The payment has been successfully sent to your payment account.</li>
                        <li><b>Cancelled</b>: The payment has been cancelled.</li>
                        <li><b>Returned</b>: The payment has been returned to your account.</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>

