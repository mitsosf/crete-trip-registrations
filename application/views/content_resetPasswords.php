<div class="content">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-2">
            <h1>Godmode Panel</h1>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-2">

        </div>

        <?php

        //$this->db->where('feepayment !=', 'No');  //those that have paid the fee, to be used after registrations
        $query = $this->db->get('participants');
        $sectionName = $this->session->section;
        $participantNum = 1;
        ?>
        <div class="col-sm-8">
            <section>
                <div class="col-sm-4">
                    <h3>Participants:</h3>
                </div>

                <table class="table table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Section</th>
                        <th>Password</th>
                    </tr>
                    </thead>
                    <tbody>


                    <?php
                    foreach ($query->result() as $row) { ?>
                        <tr>
                            <td><?php echo $participantNum; ?></td>
                            <td>
                                <b><?php echo $row->name . " " . $row->surname; //name field?></b>
                            </td>
                            <td><?php echo $row->esnsection;?></td>
                            <td>
                                <a href="<?php echo base_url('godmode/resetParticipantPassword/' . $row->id); ?>"
                                       class="btn btn-info" role="button"><i class="glyphicon glyphicon-pencil"></i>
                                        Reset pass </a>
                            </td>
                        </tr>
                    <?php
                    $participantNum++;
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
</div>