<div id="content">
    <?php if ($this->session->type == "god") { //if user is logged in as god

        /*check if participant is member of the section*/

        $this->session->set_userdata('participant', $participant);     //set userID to session, to use for database inserting

        echo "<h1> New participant Pass</h1>";
        echo "<p>Are you sure you want to reset the pass of the participant <b>" . $model_participant->get_participant_Name($participant) . "</b> ?</p>"; ?>
        <div class="row" style="margin-bottom: 3%">
            <div class="col-sm-1"></div>
            <div class="col-sm-5">
                The new password is : <b><?php echo $model_admin->resetParticipantPassword($participant) ?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>

            <div class="col-sm-1">
                <a href="<?php echo base_url('godmode/resetPasswords'); ?>" class="btn btn-danger"
                   role="button">Go back</a>
            </div>
        </div>
        <?php

    }
    if ($this->session->type == "demigod") { //if user is logged in as god

        /*check if participant is member of the section*/


        $participantRealSection = $model_participant->get_participant_Section($participant);
        $lcsection = $this->session->section;

    if ($participantRealSection != $lcsection) {    //if someone was being naughty
        redirect(base_url('manage'));           //redirect to control panel
    } else {

        $this->session->set_userdata('participant', $participant);     //set userID to session, to use for database inserting

        echo "<h1> New participant Pass</h1>";
        echo "<p><b>". $model_participant->get_participant_Name($participant) . "</b> has a new password, <b  style='color: red'>write it down!</b></p>"; ?>
        <div class="row" style="margin-bottom: 3%">
            <div class="col-sm-1"></div>
            <div class="col-sm-5">
                The new password is : <b><?php echo $model_admin->resetParticipantPassword($participant) ?></b>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-1"></div>

            <div class="col-sm-1">
                <a href="<?php echo base_url('manage'); ?>" class="btn btn-danger"
                   role="button">Go back</a>
            </div>
        </div>
        <?php
    }

    } else { //if user is not logged in
        echo redirect(base_url('godmode'));
    } ?>
</div>
