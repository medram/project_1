<!-- Content Header (Page header) -->
<section class="content-header">
    <h1><i class="fa fa-fw fa-file-text-o"></i> Pages</h1>
</section>

<!-- Main content -->
<section class="content">
    <div class="box box-warning">
        <div class="box-body">
            <div class='row'>
                <div class='col-lg-12 text-right'>
                        <a href='./pages/add' class='btn btn-primary'><i class='fa fa-plus-circle fa-fw'></i> Add page</a>
                        <br>
                        <br>
                </div>
            </div>
            <div class='row'>
                <div class='col-lg-12'>
                    <table class='table'>
                        <tr>
                            <th>ID</th>
                            <th>Name</th>
                            <th>Language</th>
                            <th>Slug</th>
                            <th>Modified</th>
                            <th>Created</th>
                            <th>Actions</th>
                        </tr>
                        <?php
                        $i = 1;
                        foreach ($pages as $k => $row)
                        {
                            echo "<tr>";
                                echo "<td>".$i."</td>";
                                echo "<td>".$row['title']."</td>";
                                echo "<td><span class='label label-info'>".ucfirst($pageLangData[$k])."</span></td>";
                                echo "<td>".$row['slug']."</td>";
                                echo "<td>".date(config_item('time_format'),$row['modified'])."</td>";
                                echo "<td>".date(config_item('time_format'),$row['created'])."</td>";
                                echo "<td>";
                                    echo "<a href='".base_url($page_path."/pages/edit/".$row['id'])."' class='btn btn-primary btn-xs'><i class='fa fa-pencil fa-fw'></i> Edit</a> ";
                                    echo "<a href='".base_url($page_path."/demo/".$row['id'])."' target='_blank' class='btn btn-success btn-xs'><i class='fa fa-eye fa-fw'></i> Demo</a> ";
                                    if ($row['uneditable'] == 0)
                                    {
                                        echo "<span class='btn btn-danger btn-xs deletePage' id='".$row['id']."'><i class='fa fa-times fa-fw'></i> Delete</span> ";
                                    }
                                echo "</td>";
                            echo "</tr>";
                            $i++;
                        }
                        ?>
                    </table>
                </div>
            </div>
        </div>
    </div>
</section>

