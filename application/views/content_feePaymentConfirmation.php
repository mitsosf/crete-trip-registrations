<div id="content">
    <?php if ($this->session->is_logged_in == TRUE) { //if user is logged in

        /*check if participant is member of the section*/

        $participantRealSection = $model_participant->get_participant_Section($participant);
        $lcsection = $this->session->section;


        if ($participantRealSection != $lcsection) {    //if someone was being naughty
            redirect(base_url('manage'));           //redirect to control panel
        } else {

            $this->session->set_userdata('participant', $participant);     //set userID to session, to use for database inserting

            echo "<h1> Fee payment Confirmation</h1>";
            echo "<p>Are you sure <b>" . $model_participant->get_participant_Name($participant) . "</b> has payed the event fee?</p>"; ?>
            <?php
                echo form_open("manage/insertFeePaymentToDB");



            /*create dropdown for ESN UOC*/
            if ($this->session->section == "ESN UOC") { ?>
                <?php echo "<div class='form-group'>"; ?>
                <?php

                echo form_label('Choose the fee amount: *', 'fee');
                echo '<div class="row">';
                echo '<div class="col-sm-2">';
                echo form_error('fee', '<div style="color:red;">', '</div>');

                $data = array(
                    "name" => "fee",
                    "id" => "fee",
                    "placeholder" => "Fee",
                    "class" => "form-control",
                    "value" => set_value("gender"),
                );

                $options = array(               //change this according to each year's different fees for UOC
                    "70" => "Heraklion - 70",
                    "135" => "Rethymno - 135",
                );

                echo form_dropdown($data, $options);
                ?>
                <?php echo "</div>"; ?>
                <?php echo '</div>'; ?>
                <?php echo '</div>'; ?>
                <?php
            }
            ?>
            <div class="row">
                <div class="col-sm-1">
                    <div class="form-group">
                        <?php

                        $data = array(
                            "name" => "submit",
                            "id" => "submit",
                            "value" => "Validate",
                            "class" => "btn btn-success",
                        );

                        echo form_submit($data);
                        ?>
                    </div>
                </div>


                <?php
                echo form_close();

                ?>
                <div class="col-sm-1">
                    <a href="<?php echo base_url('manage');?>" class="btn btn-danger" role="button">Cancel</a>
                </div>
            </div>
            <?php
        }
    } else { //if user is not logged in
        echo redirect(base_url('manage'));
    } ?>
</div>
