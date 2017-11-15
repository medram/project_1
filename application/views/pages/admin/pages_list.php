<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            <i class="fa fa-bars"></i> Manage pages
        </h1>
        <ol class="breadcrumb">
            <li class="active">
                <i class="fa fa-dashboard"></i> Dashboard / Manage pages
            </li>
        </ol>
    </div>
</div>
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
                <th>id</th>
                <th>Title</th>
                <th>Slug</th>
                <th>Modified</th>
                <th>Created</th>
                <th>Actions</th>
            </tr>
            <?php
            $i = 1;
            foreach ($pages as $row)
            {
                echo "<tr>";
                    echo "<td>".$i."</td>";
                    echo "<td>".$row['title']."</td>";
                    echo "<td>".$row['slug']."</td>";
                    echo "<td>".date(config_item('time_format'),$row['modified'])."</td>";
                    echo "<td>".date(config_item('time_format'),$row['created'])."</td>";
                    echo "<td>";
                        echo "<a href='".base_url($page_path."/pages/edit/".$row['id'])."' target='_blank' class='btn btn-primary btn-xs'><i class='fa fa-pencil fa-fw'></i> Edit</a> ";
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