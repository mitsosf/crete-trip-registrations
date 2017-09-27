<div class="content">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-2">
            <h1>Control Panel</h1>
        </div>

        <div class="col-sm-2">
            <a href="mailto:it@esngreece.gr" class="btn btn-warning" role="button">Mail Tech Support</a>
        </div>
        <div class="col-sm-2">
            <a target="_blank" href="https://m.me/frangiadakis.dimitris" class="btn btn-info" role="button">Facebook
                Tech Support</a>
        </div>
        <div class="col-sm-1">
            <a target="_blank" href="https://m.me/antwnis21" class="btn btn-success" role="button">Facebook
                Sections Coordinator</a>
        </div>
    </div>
    <div class="row" style="margin-bottom: 1%">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <h5 style="text-align: center">Your Stats:</h5>
            <table class="table table-hover">

                <thead>

                <tr>
                    <th style="text-align: center" class="col-sm-3 bg-primary">Registered</th>
                    <th style="text-align: center" class="col-sm-3 success">Paid Fee</th>
                    <th style="text-align: center" class="col-sm-3 info">Conversion Rate</th>
                </tr>

                </thead>
                <tbody>


                <tr>
                    <?php
                    $registrations = $model_participant->get_number_of_registrations($this->session->section);
                    $participants = $model_participant->get_number_of_participants($this->session->section);
                    ?>
                    <td style="text-align: center"><?php echo $registrations; ?></td>
                    <td style="text-align: center"><?php echo $participants ?></td>
                    <td style="text-align: center"><?php echo floor(($participants / $registrations) * 100) . "%"; ?></td>
                </tr>

                </tbody>
            </table>

        </div>
        <div id='3' class="col-sm-3">
        </div>
    </div>

    <div class="row " style="margin-bottom: 3%">
        <div class="col-sm-3">

        </div>
        <div class="col-sm-6">
            <h5 style="text-align: center">Number of places left: </h5><h4 class="text-danger" style="text-align: center"><?php
                //Display available positions
                echo "No places left, please use the  waiting list form!";
                echo '<h3 style="margin-top: 2%;text-align: center"><a href="https://goo.gl/forms/PNK8AxWBtvfMUatB3">https://goo.gl/forms/PNK8AxWBtvfMUatB3</a></h3>'?></h4>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">

        </div>

        <?php

        $this->db->where('esnsection', $this->session->section);   //enable or disable this for development to print all entries through all accounts
        $this->db->where('feepayment !=','No');  //those that have paid the fee, to be used after registrations
        $query = $this->db->get('participants');
        $sectionName = $this->session->section;
        $participantNum = 0;
        ?>
        <div class="col-sm-8">
            <section>
                <div class="col-sm-4">
                    <h3>Your registrations:</h3>
                </div>
                <div class="col-sm-2">
                    <a href="<?php echo base_url('manage').'/bankAndUpload'?>" class="btn btn-info" role="button">
                        <i class ="glyphicon glyphicon-cloud-upload"></i> See Bank Details & <br>Upload Proof of Payment</a>
                </div>
                <div class="col-sm-3"></div>
                <div class="col-sm-2">
                    <a href="#" class="btn btn-success disabled" role="button">
                        <i class ="glyphicon glyphicon-save-file"></i> Export list to CSV (coming soon)</a>
                </div>
                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Fee</th>
                        <?php if ($sectionName != "ESN TUC" && $sectionName != "ESN UOC" && $sectionName != "ESN TEI OF CRETE") {     //don't show boat fee field for Cretan Universities
                            echo "<th> Boat Tickets</th>";
                        } ?>
                        <th>Comments</th>
                    </tr>
                    </thead>
                    <tbody>


                    <?php
                    foreach ($query->result() as $row) { ?>
                        <tr
                            <?php
                            $participantNum++;
                            if ($sectionName == "ESN TUC" || $sectionName == "ESN UOC" || $sectionName == "ESN TEI OF CRETE") {   //make table line green when fee is paid for cretan sections
                                if ($row->feepayment == "No") {
                                    echo 'class="active"';
                                } elseif ($row->feepayment != "No") {
                                    echo 'class="success"';
                                }
                            } else {                   //make table line blue when fee is paid and green when both fee and boat are paid
                                if ($row->feepayment == "No" && $row->ticketspayment == "No") {
                                    echo 'class="active"';
                                } elseif ($row->feepayment != "No" && $row->ticketspayment == "No") {
                                    echo 'class="info"';
                                } elseif ($row->feepayment != "No" && $row->ticketspayment != "No") {
                                    echo 'class="success"';
                                }
                            }
                            ?>>
                            <td><?php echo $participantNum; ?></td>
                            <td>
                                <a href="manage/participant/<?php echo $row->id ?>"><?php echo $row->name . " " . $row->surname; //name field?></a>
                            </td>
                            <td><a href="mailto:<?php echo $row->email; ?>" class="btn btn-default" role="button"><i
                                            class="glyphicon glyphicon-envelope"></i></a> <?php echo $row->email; ?>
                            </td>

                            <td>
                                <?php if ($row->feepayment == "No") {   //has paid fee
                                    ?>
                                    <a href="<?php echo base_url('manage/feePaymentConfirmation/' . $row->id); ?>"
                                       class="btn btn-primary" role="button"><i class="glyphicon glyphicon-list-alt"></i>
                                        Enter Waiting List</a>
                                    <?php
                                } else {
                                    echo $row->feepayment;
                                }
                                ?>

                            </td>

                            <?php if ($sectionName != "ESN TUC" && $sectionName != "ESN UOC" && $sectionName != "ESN TEI OF CRETE") {     //don't show boat fee field for Cretan Universities?>
                                <?php echo "<td>";  //has paid tickets?>
                                <?php if ($row->ticketspayment == "No") {

                                    echo '<a href= "' . base_url("manage/boatPaymentConfirmation/") . $row->id . '" class="btn btn-success" role="button"><i class="glyphicon glyphicon-euro"></i> Pay Tickets</a>';

                                } else {
                                    echo $row->ticketspayment;
                                }
                                ?>
                                <?php echo "</td>"; ?>
                            <?php } ?>
                            <td>
                                <?php if ($row->glcomments == "") {   //lc/gl comments
                                    ?>
                                    <a href="<?php echo base_url('manage/commentOnParticipant/' . $row->id); ?>"
                                       class="btn btn-info" role="button"><i class="glyphicon glyphicon-pencil"></i>
                                        Write comment </a>
                                    <?php
                                } else {
                                    echo "<div class='row'>";
                                    echo "<div class='col-sm-10'>";
                                    echo $row->glcomments;
                                    echo "</div>";
                                    echo "<div class='col-sm-1'>";
                                    echo '<a href="manage/commentOnParticipant/' . $row->id . '"  class="btn btn-info" role="button"><i class="glyphicon glyphicon-pencil"></i></a>';
                                    echo "</div>";
                                    echo "</div>";
                                }
                                ?>
                            </td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
                <?php if ($participantNum == 0) {
                    echo "</h3>You don't have any registrations yet, keep up the promo ;)</h3>";
                }

                ?>
            </section>
        </div>
        <div class="col-sm-2">

        </div>

        </section>
    </div>
</div>



