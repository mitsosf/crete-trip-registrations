<div class="content">

    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-2">
            <h1>Godmode panel</h1>
        </div>
    </div>
    <div class="row" style="margin-bottom: 3%">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <h3 style="text-align: center"><b>Hotels:</b></h3>
            <table class="table table-hover">

                <thead>

                <tr>
                    <th class="col-sm-2 success" style="text-align: center"></th>
                    <th class="col-sm-2 info" style="text-align: center">2-bed</th>
                    <th class="col-sm-2 info" style="text-align: center">3-bed</th>
                    <th class="col-sm-2 info" style="text-align: center">4-bed</th>
                </tr>

                </thead>
                <tbody>
                <tr>
                    <?php
                    $givtwobeds = $model_event->getGivenRooms("Marilena", 2);
                    $givthreebeds = $model_event->getGivenRooms("Marilena", 3);
                    $givfourbeds= $model_event->getGivenRooms("Marilena", 4);

                    $fintwobeds = $model_event->getNumberOfFinalisedRooms("Marilena", 2);
                    $finthreebeds = $model_event->getNumberOfFinalisedRooms("Marilena", 3);
                    $finfourbeds= $model_event->getNumberOfFinalisedRooms("Marilena", 4);

                    $twobeds = $givtwobeds - $fintwobeds;
                    $threebeds = $givthreebeds - $finthreebeds;
                    $fourbeds = $givfourbeds - $finfourbeds;

                    ?>
                    <td style="text-align: center">Marilena</td>
                    <td style="text-align: center"><?php echo $twobeds; ?></td>
                    <td style="text-align: center"><?php echo $threebeds ?></td>
                    <td style="text-align: center"><?php echo $fourbeds ?></td>
                </tr>


                <tr>
                    <?php
                    $givtwobeds = $model_event->getGivenRooms("Vanisko", 2);
                    $givthreebeds = $model_event->getGivenRooms("Vanisko", 3);
                    $givfourbeds= $model_event->getGivenRooms("Vanisko", 4);

                    $fintwobeds = $model_event->getNumberOfFinalisedRooms("Vanisko", 2);
                    $finthreebeds = $model_event->getNumberOfFinalisedRooms("Vanisko", 3);
                    $finfourbeds= $model_event->getNumberOfFinalisedRooms("Vanisko", 4);

                    $twobeds = $givtwobeds - $fintwobeds;
                    $threebeds = $givthreebeds - $finthreebeds;
                    $fourbeds = $givfourbeds - $finfourbeds;

                    ?>
                    <td style="text-align: center">Vanisko</td>
                    <td style="text-align: center"><?php echo $twobeds; ?></td>
                    <td style="text-align: center"><?php echo $threebeds ?></td>
                    <td style="text-align: center"><?php echo $fourbeds ?></td>
                </tr>


                </tbody>
            </table>

        </div>
        <div id='3' class="col-sm-3">
        </div>
    </div>
    <div class="row" style="margin-bottom: 3%">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <h3>Stats:</h3>
            <table class="table table-hover">

                <thead>

                <tr>
                    <th class="col-sm-3 bg-primary">Registered</th>
                    <th class="col-sm-3 success">Paid</th>
                    <th class="col-sm-6 info">Conversion Rate</th>
                </tr>

                </thead>
                <tbody>


                <tr>
                    <?php
                    $registrations = $model_participant->get_number_of_registrations();
                    $participants = $model_participant->get_number_of_participants();
                    ?>
                    <td><?php echo $registrations; ?></td>
                    <td><?php echo $participants ?></td>
                    <td><?php echo round(($participants / $registrations) * 100, 2) . "%"; ?></td>
                </tr>

                </tbody>
            </table>

        </div>
        <div id='3' class="col-sm-3">
        </div>
    </div>
    <div class="row" style="margin-bottom: 3%">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <h5 style="text-align: center">Tickets:</h5>
            <table class="table table-hover">

                <thead>

                <tr>
                    <th class="col-sm-3 success">Both Ways</th>
                    <th class="col-sm-3 info">TO Crete</th>
                    <th class="col-sm-6 info">FROM Crete</th>
                </tr>

                </thead>
                <tbody>


                <tr>
                    <?php
                    $registrations = $model_participant->get_number_of_registrations();
                    $participants = $model_participant->get_number_of_participants();
                    $ticketsbothways = $model_participant->getNumberOfTickets('Travel BOTH WAYS with the group');
                    $ticketstocrete = $model_participant->getNumberOfTickets('Travel WITH THE GROUP to Crete and return INDIVIDUALLY');
                    $ticketsfromcrete = $model_participant->getNumberOfTickets('Travel INDIVIDUALLY to Crete and return WITH THE GROUP');

                    ?>
                    <td><?php echo $ticketsbothways; ?></td>
                    <td><?php echo $ticketstocrete ?></td>
                    <td><?php echo $ticketsfromcrete ?></td>
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
            <h5 style="text-align: center">Number of hotel places left: </h5><h4 class="text-danger" style="text-align: center"><?php
                //Display available positions
                echo 'Well done team'; ?></h4>
        </div>
    </div>

    <div class="row " style="margin-bottom: 3%">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-2">
            <a href="<?php echo base_url('godmode') . '/sectionStats' ?>" class="btn btn-success" role="button">Sections
                Stats</a>
        </div>
        <div class="col-sm-2">
            <a href="#" class="btn btn-info disabled" role="button">Edit participant</a>
        </div>
        <div class="col-sm-1">
            <a href="<?php echo base_url('godmode') . '/cashflow' ?>" class="btn btn-warning" role="button">Cashflow</a>
        </div>
    </div>

    <div class="row" style="margin-bottom: 3%">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-2">
            <a href="<?php echo base_url('godmode') . '/resetPasswords' ?>" class="btn btn-danger" role="button">Reset Passwords</a>
        </div>
        <div class="col-sm-2">

        </div>
        <div class="col-sm-1">
            <a href="<?php echo base_url('godmode') . '/proofsOfPayment' ?>" class="btn btn-primary" role="button">Review Proofs of Payment</a>
        </div>
    </div>


</div>

