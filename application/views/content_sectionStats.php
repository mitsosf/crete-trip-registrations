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
        <div class="col-sm-8">
            <section>
                <h3 style="text-align: center">Participant details:</h3>
                <table class="table table-hover" style="margin-bottom: 5%">
                    <thead>
                    <tr>
                        <th>Section</th>
                        <td style="text-align: center">Registrations</td>
                        <td style="text-align: center">Paid Fee</td>
                        <td style="text-align: center">Conversion</td>
                        <td style="text-align: center">Paid Boat</td>
                    </tr>
                    </thead>
                    <?php
                    foreach ($sectionTable as $section) {
                        if ($section == ' ') {       //first item of section is -> ' '
                            continue;
                        } else {
                            $registrations = $model_section->getNumOfRegistrations($section);
                            $paidEventFee = $model_section->getNumOfPaidEventFee($section);
                            $paidBoatFee = $model_section->getNumOfPaidBoatFee($section);

                            echo '<tr>';
                            echo '<th><a href="' . base_url("godmode") . '/seeAsSection/' . $section . '">' . $section . '</a></th>';
                            echo '<td style="text-align: center">'.$registrations.'</td>';
                            echo '<td style="text-align: center">'.$paidEventFee.'</td>';
                            if($registrations==0){   //avoid division by 0
                                echo '<td style="text-align: center"><b>0%</b></td>';
                            }else {
                                echo '<td style="text-align: center"><b>' . round(($paidEventFee / $registrations)*100,2) . '%</b></td>';
                            }
                            echo '<td style="text-align: center">'.$paidBoatFee.'</td>';
                            echo '</tr>';
                        }
                    }
                    ?>
                </table>
                <h5 style="text-align: center"><a href="<?php echo base_url('godmode'); ?>" class="btn btn-danger"
                                                  role="button">Back</a></h5>
            </section>
        </div>
        <div class="col-sm-2">

        </div>

    </div>

</div>