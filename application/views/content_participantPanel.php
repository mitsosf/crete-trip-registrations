<div class="content">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-2">
            <h1>My account</h1>
        </div>

    </div>
    <div class="row">
        <div class="col-sm-2">

        </div>

        <?php


        $partipantName = $this->session->section;
        ?>
        <div class="col-sm-8">
            <section>
                <h3>My progress:</h3>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th style="text-align: center">Registration</th>
                        <th style="text-align: center">Fee Payment</th>
                        <th style="text-align: center">Group travel to/from Crete Payment</th>
                        <th style="text-align: center">Rooming complete</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>

                        <td class="success" style="text-align:center;vertical-align: middle">Completed <i class='glyphicon glyphicon-ok'></i>
                        </td>
                        <td <?php
                            $stepsCounter = 0;
                            $pid = $model_participant->get_participant_id_by_mail($this->session->email);
                            if ($model_participant->has_payed_fee($pid)) {
                                echo 'class="success"';
                                $stepsCounter++;
                            } else {
                                echo 'class="info"';
                            }

                            ?>style="text-align: center;vertical-align: middle"><?php
                            $pid = $model_participant->get_participant_id_by_mail($this->session->email);
                            if ($model_participant->has_payed_fee($pid)) {
                                echo "Completed <i class='glyphicon glyphicon-ok'></i>";
                            } else {
                                echo "Pending <i class='glyphicon glyphicon-time'></i>";
                            } ?></td>
                        <td <?php
                            $pid = $model_participant->get_participant_id_by_mail($this->session->email);
                            if ($model_participant->has_payed_boat($pid)) {
                                echo 'class="success"';
                                $stepsCounter++;
                            } else {
                                echo 'class="info"';
                            }

                            ?>style="text-align: center;vertical-align: middle"><?php
                            $pid = $model_participant->get_participant_id_by_mail($this->session->email);
                            if ($model_participant->has_payed_boat($pid)) {
                                echo "Completed <i class='glyphicon glyphicon-ok'></i>";
                            } else {
                                echo "Pending <i class='glyphicon glyphicon-time'></i>";
                            } ?></td>
                        <td <?php
                            $pid = $model_participant->get_participant_id_by_mail($this->session->email);
                            if ($model_participant->has_completed_rooming($pid)) {
                                echo 'class="success"';
                                $stepsCounter++;
                            } else {
                                echo 'class="info"';
                            }

                            ?>style="text-align: center;vertical-align: middle"><?php
                            $pid = $model_participant->get_participant_id_by_mail($this->session->email);
                            if ($model_participant->has_completed_rooming($pid)) {
                                echo "Completed <i class='glyphicon glyphicon-ok'></i>";
                            } else {
                                echo '<a href="#" class="btn btn-success disabled" role="button">Access Rooming Platform</a>';
                            } ?></td>
                    </tr>
                    </tbody>
                </table>
            </section>
        </div>
        <div class="col-sm-3">

        </div>
        </section>

    </div>
    <?php if($stepsCounter==3){
        echo '<h2 style="text-align: center">Your registration is complete! See you in Crete!</h2>';
    }else{
        echo '<h3 style="text-align: center">You are getting there, '.(3-$stepsCounter).' more steps to go</h3>';
    }?>

    <h5 style="text-align: center">If you have any questions, ask your local coordinator!</h5>

    <?php
    $pid = $model_participant->get_participant_id_by_mail($this->session->email);
    $participantSection = $model_participant->get_participant_section($pid);
    if (($participantSection == "No ESN Section" || $participantSection == "International Guest ESNer" || $participantSection == "Erasmus Guest (not Erasmus in Greece OR Cyprus)")) {    //if participant is registered in these sections

        echo '<div class="row" style="margin-top: 20px">';
        echo '<div class="col-sm-12">';
        echo '<h5 style="text-align: center">Because you registered as '.$participantSection.', <b>once instructed to pay</b>, you have to upload your proof of payment below:</h5>';
        echo '</div>';
        echo '<h4 style="text-align: center"><a href="'.base_url("account").'/bankAndUpload" class="btn btn-info" role="button"><i class ="glyphicon glyphicon-cloud-upload"></i> See Bank Details & <br> Upload Proof of Payment</a></h4>';
        echo "</div>";
    } ?>

    <div class="row" style="margin-top: 50px">
        <div class="col-sm-4">

        </div>

        <?php
        $pid = $model_participant->get_participant_id_by_mail($this->session->email);
        $partTable = $model_participant->get_participant_details($pid);  //participant table
        ?>
        <div class="col-sm-4">
            <section>
                <h3 style="text-align: center">Your details:</h3>
                <h5 style="text-align: center">If you see something wrong, let your local ESN Section know immediately!</h5>
                <table class="table table-hover">
                    <tr>
                        <th>Name</th>
                        <td><?php echo $partTable["name"];?></td>
                    </tr>
                    <tr>
                        <th>Surname</th>
                        <td><?php echo $partTable["surname"];?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $partTable["email"];?></td>
                    </tr>
                    <tr>
                        <th>ID/Passport</th>
                        <td><?php echo $partTable["idorpassport"];?></td>
                    </tr>
                    <tr>
                        <th>Date of birth</th>
                        <td><?php echo $partTable["dateofbirth"];?></td>
                    </tr>
                    <tr>
                        <th>Gender</th>
                        <td><?php echo $partTable["gender"];?></td>
                    </tr>
                    <tr>
                        <th>Phone</th>
                        <td><?php echo $partTable["phone"];?></td>
                    </tr>
                    <tr>
                        <th>Country</th>
                        <td><?php echo $partTable["country"];?></td>
                    </tr>
                    <tr>
                        <th>ESN Section</th>
                        <td><?php echo $partTable["esnsection"];?></td>
                    </tr>
                    <tr>
                        <th>Transportation TO/FROM Crete</th>
                        <td><?php echo $partTable["trips"];?></td>
                    </tr>
                    <tr>
                        <th>City</th>
                        <td><?php echo $partTable["city"];?></td>
                    </tr>
                    <tr>
                        <th>Facebook</th>
                        <td><?php echo $partTable["facebook"];?></td>
                    </tr>
                    <tr>
                        <th>Allergies/Food restrictions</th>
                        <td><?php echo $partTable["allergies"];?></td>
                    </tr>
                    <tr>
                        <th>Comments</th>
                        <td><?php echo $partTable["comments"];?></td>
                    </tr>
                    <tr>
                        <th>Registration Date</th>
                        <td><?php echo $partTable["registrationdate"];?></td>
                    </tr>
                </table>
            </section>
        </div>
        <div class="col-sm-7">

        </div>
        </section>

    </div>
</div>




