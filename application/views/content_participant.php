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

    <div class="row" style="margin-top: 50px">
        <div class="col-sm-4">

        </div>

        <?php
        $pid = $participant;
        $partTable = $model_participant->get_participant_details($pid);  //participant table
        ?>
        <div class="col-sm-4">
            <section>
                <h3 style="text-align: center">Participant details:</h3>
                <table class="table table-hover">
                    <tr>
                        <th>Unique ID</th>
                        <td><?php echo $partTable["id"];?></td>
                    </tr>
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
                <h5 style="text-align: center" ;><a href="<?php echo base_url('manage')."/resetParticipantPassword/".$participant;?>" class="btn btn-warning" role="button">Reset password</a></h5>
                <h5 style="text-align: center"><a href="<?php echo base_url('manage');?>" class="btn btn-danger" role="button">Back</a></h5>
            </section>
        </div>
        <div class="col-sm-7">

        </div>
        </section>

    </div>

</div>




