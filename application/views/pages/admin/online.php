<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class='fa fa-wifi'></i> <?php echo $title; ?></h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-header with-border">
            <h3 class="box-title">Visitors information (<?php echo $online->num_rows() ?>)</h3>
        </div>
        <div class="box-body">
            <div class="row">
                <div class="col-lg-12">
                    <?php
                    if ($online->num_rows() > 0)
                    {

                    ?>
                    <table class='table table-hover'>
                        <thead>
                            <td><b>ip</b></td>
                            <td><b>Platform</b></td>
                            <td><b>Agent</b></td>
                        </tead>
                        <?php
                        foreach ($online->result_array() as $row)
                        {
                            echo "<tr>";
                                echo "<td>".$row['ip']."</td>";
                                echo "<td>".$row['platform']."</td>";
                                echo "<td>".$row['agent']."</td>";
                            echo "</tr>";
                        }
                        ?>
                    </table>
                    <?php

                    }
                    else
                    {
                        echo "<div class='alert alert-warning'><i class='fa fa-fw fa-info-circle'></i> Data not found !</div>";
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

</section>

