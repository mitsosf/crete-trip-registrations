<div class="content">
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-2">
            <h1>Godmode panel</h1>
        </div>
    </div>

    <div class="row" style="margin-top: 50px">
        <div class="col-sm-2">

        </div>

        <?php
        $sectionTable = $model_getsections->getData();  //Get sections
        ?>
        <div class="col-sm-4">
            <section>
                <h3 style="text-align: center">Cashflows:</h3>
                <table class="table table-hover" style="margin-bottom: 5%">
                    <thead>
                    <tr>
                        <th>Section</th>
                        <td style="text-align: center">Cash</td>
                        <td style="text-align: center">Boats</td>
                        <td style="text-align: center">Total</td>
                    </tr>
                    </thead>
                    <?php
                    $feesSum = 0;
                    $boatSum  = 0;


                    foreach ($sectionTable as $section) {
                        if ($section == ' ') {       //first item of section is -> ' '
                            continue;
                        } else {
                            $eventFeeSum = $model_section->getSumOfEventFees($section);
                            $feesSum = $feesSum + $eventFeeSum;
                            $boatFeeSum = $model_section->getSumOfBoatFees($section);
                            $boatSum = $boatSum +$boatFeeSum;

                            echo '<tr>';
                            echo '<th><a href="' . base_url("godmode") . '/seeAsSection/' . $section . '">' . $section . '</a></th>';
                            echo '<td style="text-align: center">'.$eventFeeSum.'</td>';
                            echo '<td style="text-align: center">'.$boatFeeSum.'</td>';
                            echo '<td style="text-align: center">'.($eventFeeSum+$boatFeeSum).'</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                    <tr>
                        <th>
                            <h3>Total</h3>
                        </th>
                        <td style="text-align: center"><h3><?php echo $feesSum;?></h3></td>
                        <td style="text-align: center"><h3><?php echo $boatSum;?></h3></td>
                        <td style="text-align: center"><h3><?php echo ($feesSum + $boatSum);?></h3></td>
                    </tr>
                </table>
                <h5 style="text-align: center"><a href="<?php echo base_url('godmode'); ?>" class="btn btn-danger"
                                                  role="button">Back</a></h5>
            </section>
        </div>
        <div class="col-sm-2"></div>
        <div class="col-sm-2">
            <section>
                <h3 style="text-align: center">Total sums:</h3>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th style="text-align: center">Fees</th>
                        <th style="text-align: center">Boats</th>
                        <th style="text-align: center">Total</th>
                    </tr>
                    </thead>
                    <tr>
                        <td style="text-align: center"><h3><?php echo $feesSum;?></h3></td>
                        <td style="text-align: center"><h3><?php echo $boatSum;?></h3></td>
                        <td style="text-align: center"><h3><?php echo ($feesSum + $boatSum);?></h3></td>
                    </tr>
                </table>
            </section>
        </div>

    </div>

</div>