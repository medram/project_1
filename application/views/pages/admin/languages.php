<div class="row">
    <div class="col-md-12">
        <h1 class="page-header">
            <i class="fa fa-fw fa-language"></i> Languages
        </h1>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <div class='well well-sm'>
            <h3>Important :</h3>
            <p>
                After adding a new language from the "Add language" button, you should translate the english files to the new language that you added, at this folder.<br>
                <code>application/language/{NEW_LANGUAGE}</code><br>
                after the translate active the language if you want :D<br>
                <br>
                <b>For example:</b><br>
                if you added "japan" language from the button below, go to the japan folder <code>application/language/japan</code><br>
                and translate all the files on this folder, and active this language.<br><br>
                <b>Note:</b> you can active the language from the <b>Edit</b> option. 

            </p>
        </div>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12 text-right'>
            <a href='./languages/add' class='btn btn-primary'><i class='fa fa-plus-circle fa-fw'></i> Add language</a>
            <br>
            <br>
    </div>
</div>
<div class='row'>
    <div class='col-lg-12'>
        <table class='table'>
            <tr>
                <th>ID</th>
                <th>Language name</th>
                <th>Symbol</th>
                <th>Status</th>
                <th>Options</th>
            </tr>
            <?php
            $i = 1;
            foreach ($result as $k => $row)
            {
                echo "<tr>";
                    echo "<td>".$row['id']."</td>";
                    echo "<td>".$row['name']."</td>";
                    echo "<td><span class='label label-info'>".ucfirst($row['symbol'])."</span></td>";
                    echo "<td>";
                    if ($row['active'])
                        echo "<span class='badge badge-success' title='Available to use on the website'>On</span>";
                    else
                        echo "<span class='badge badge-danger' title='is not Available to use on the website'>Off</span>";
                    echo "</td>";

                    echo "<td>";
                        echo "<a href='".base_url($page_path."/languages/edit/".$row['id'])."' class='btn btn-primary btn-xs'><i class='fa fa-pencil fa-fw'></i> Edit</a> ";
                        if (!$row['undeletable'])
                        {
                            echo "<span class='btn btn-danger btn-xs deleteLang' id='".$row['id']."'><i class='fa fa-times fa-fw'></i> Delete</span> ";
                        }
                    echo "</td>";
                echo "</tr>";
                $i++;
            }
            ?>
        </table>
    </div>
</div>