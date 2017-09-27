<div class="content">
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <h1>Godmode</h1>
        </div>
        <div class="col-sm-2">
            <h5 style="text-align: center"><a href="<?php echo base_url('godmode') . '/sectionStats'; ?>"
                                              class="btn btn-danger"
                                              role="button">Back</a></h5>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-2">

        </div>

        <?php
        $sectionName = $model_section->retrieveSectionFromURL(3);
        $this->session->set_userdata("viewedSection",$sectionName);

        $this->db->where('esnsection', $sectionName);   //enable or disable this for development to print all entries through all accounts
        $this->db->where('feepayment!=','No');
        $query = $this->db->get('participants');

        $participantNum = 0;
        ?>
        <div class="col-sm-8">
            <section>
                <h3><?php echo $sectionName; ?></h3>
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
                                <p><?php echo $row->name . " " . $row->surname; //name field?></p>
                            </td>
                            <td><a href="mailto:<?php echo $row->email; ?>" class="btn btn-default" role="button"><i
                                            class="glyphicon glyphicon-envelope"></i></a> <?php echo $row->email; ?>
                            </td>

                            <td>
                                <?php if ($row->feepayment == "No") {   //has not  paid fee

                                    echo "0";

                                } else {
                                    echo $row->feepayment;
                                }
                                ?>

                            </td>

                            <?php if ($sectionName != "ESN TUC" && $sectionName != "ESN UOC" && $sectionName != "ESN TEI OF CRETE") {     //don't show boat fee field for Cretan Universities?>
                                <?php echo "<td>";  //has paid tickets?>
                                <?php if ($row->ticketspayment == "No") {

                                    echo "0";

                                } else {
                                    echo $row->ticketspayment;
                                }
                                ?>
                                <?php echo "</td>"; ?>
                            <?php } ?>
                            <td>
                                <?php if ($row->glcomments == "") {   //lc/gl comments
                                    echo "";
                                } else {
                                    echo $row->glcomments;
                                }
                                ?>
                            </td>
                        </tr>
                        <?php
                    } ?>
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
    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">

        </div>
        <div class="col-sm-2">
            <h5 style="text-align: center"><a href="<?php echo base_url('godmode') . '/sectionStats'; ?>"
                                              class="btn btn-danger"
                                              role="button">Back</a></h5>
        </div>
    </div>
</div>



