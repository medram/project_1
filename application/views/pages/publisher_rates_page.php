<div class="col-md-12 text-center">
    <b>Worldwide Deal(All Countries):</b> <?php echo "{$currency['symbol']}{$world_wide}" ?><br><br>
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
                    <td><?php echo "{$currency['symbol']}{$country->price}" ?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>
<?php } ?>
