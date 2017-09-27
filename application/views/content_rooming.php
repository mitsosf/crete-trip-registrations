<div class="content">
    <div class="row">
        <div class="col-sm-2">
        </div>
        <div class="col-sm-4">
            <h1>Rooming Platform</h1>
        </div>

    </div>
    <div class="row" style="margin-bottom: 50px">
        <div class="col-sm-3"></div>
        <div class="col-sm-6">
            <h3>Rooming procedure</h3>
            <p>Welcome to the rooming platform. In order to be assigned to rooms, please either create a new room or
                enter one created by one of your friends. We have 4,3 and 2-bedroom rooms available.</p>
            <p>In case you do not have any rooming preferences, please click the "Random Room" button and you will
                automatically be assigned to a random room, at the end of the process. You could say it is a way to meet
                new people! ;) </p>
            <p>If you have any questions or encounter any problems, don't hesitate to contact the Sections Coordinator
                by email here: <br><a href="mailto:section-c@thecretetrip.org">section-c@thecretetrip.org</a>
            </p>
            <p><b style="color: red">IMPORTANT!</b> The process works under the principle of First Come First Served, meaning that the Room Types are LIMITED. In order to SECURE your room ALL
                roommates have to join the room. </p>
            <p><span style="color: red;">For example</span> , if you created a 3-people room, in order to secure your room, every single one of the three roommates has to enter the room (The first
               one will generate the Room Code and the other two will join by entering it). The room will only be secured when the last roommate completes the process. If you chose a 3-people room
               BUT did not manage to secure it and there are no more 3-people room, you will get an e-mail  that informs you that there are no more 3-people rooms. You will have to begin the
               process again and choose another type of room (for example 2-people or 4-people).</p>

        </div>
    </div>
    <?php
    $pid = $model_participant->get_participant_id_by_mail($this->session->userdata('email')); //get participant id
    $roomExists = $model_event->checkIfParticipantHasRoom($pid);
    $hasRoom = $model_participant->hasRoom($pid);


    if ($roomExists) {
        if (!$hasRoom) {

            ?>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-7">Give these details to your wannabe roommates:<br>Room number: <b style="color: red;"><?php echo $model_event->getParticipantRoom($pid)['rid']; ?></b><br>Room
                    code: <b
                            style="color: red;
"><?php echo
                        $model_event->getParticipantRoom($pid)['code']; ?></b></div>
            </div>
        <?php } elseif ($hasRoom) {
            ?>
            <div class="row">
                <div class="col-sm-3"></div>
                <div class="col-sm-7"><h3 style="margin-left: 15%">Your room submission is complete. See you in Crete!</h3></div>
            </div>
        <?php } ?>
    <?php } elseif (!$roomExists) { //TODO CHECK!?>
        <div class="row">
            <div class="col-sm-3"></div>
            <div class="col-sm-2">
                <a href="<?php echo base_url('rooming') . '/createroom' ?>" class="btn btn-success" role="button">CREATE Room</a>
            </div>

            <div class="col-sm-2">
                <a href="<?php echo base_url('rooming') . '/joinroom' ?>" class="btn btn-info" role="button">JOIN Room</a>
            </div>
            <div class="col-sm-2">
                <a href="<?php echo base_url('rooming') . '/randomroom' ?>" class="btn btn-warning" role="button">RANDOM Room</a>
            </div>
        </div>
    <?php } ?>
    <div class="row" style="margin-top: 3%">
        <div class="col-sm-3"></div>

        <div class="col-sm-1"></div>
        <div class="col-sm-3" style="text-align: center; margin-left: 5%">
            <a href="<?php echo base_url() ?>" style="text-align: center" class="btn btn-danger" role="button">Back</a>
        </div>
    </div>
</div>
