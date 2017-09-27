<div class="content">

    <div class="row">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-2">
            <h1>Godmode panel</h1>
        </div>
    </div>
    <div class="row" style="margin-bottom: 5%">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <h3>Sections proofs of Payment:</h3>
            <table class="table table-hover">

                <thead>

                <tr>
                    <th class="col-sm-1 ">#</th>
                    <th class="col-sm-2 ">Amount</th>
                    <th class="col-sm-2 ">File</th>
                    <th class="col-sm-4 ">Participants</th>
                    <th class="col-sm-4 ">Comments</th>
                    <th class="col-sm-1 ">Approve</th>

                </tr>

                </thead>
                <tbody>


                <?php
                $table = $this->model_admin->getUnverifiedProofsOfPayment();
                $ai = 1;
                foreach ($table as $row) {
                    ?>

                    <tr>
                        <td><?php echo $ai; ?></td>
                        <td><?php echo $row->amount; ?></td>
                        <td><a href="<?php echo base_url($row->path);?>" class="btn btn-info" role="button"><i class="glyphicon glyphicon-file"></i> View file</a></td>
                        <td><?php echo $row->participants; ?></td>
                        <td><?php echo $row->comments; ?></td>
                        <td><a href="<?php echo base_url('godmode').'/validateProofOfPayment/'.$row->id;?>" class="btn btn-success" role="button"><i class="glyphicon glyphicon-ok"></i> Approve</a></td>


                    </tr>
                    <?php
                    $ai++;
                } ?>
                </tbody>
            </table>
            <h5 style="text-align: center"><a href="<?php echo base_url('godmode'); ?>" class="btn btn-danger"
                                              role="button">Back</a></h5>

        </div>
        <div id='3' class="col-sm-3">
        </div>
    </div>

    <div class="row" style="margin-bottom: 5%">
        <div class="col-sm-3">
        </div>
        <div class="col-sm-6">
            <h3>Individual proofs of Payment:</h3>
            <table class="table table-hover">

                <thead>

                <tr>
                    <th class="col-sm-1 ">#</th>
                    <th class="col-sm-2 ">Amount</th>
                    <th class="col-sm-2 ">File</th>
                    <th class="col-sm-4 ">Reference</th>
                    <th class="col-sm-4 ">Comments</th>
                    <th class="col-sm-1 ">Approve</th>

                </tr>

                </thead>
                <tbody>


                <?php
                $table = $this->model_admin->getIndividualUnverifiedProofsOfPayment();
                $ai = 1;
                foreach ($table as $row) {
                    ?>

                    <tr>
                        <td><?php echo $ai; ?></td>
                        <td><?php echo $row->amount; ?></td>
                        <td><a href="<?php echo base_url($row->path);?>" class="btn btn-info" role="button"><i class="glyphicon glyphicon-file"></i> View file</a></td>
                        <td><?php echo $row->individual; ?></td>
                        <td><?php echo $row->comments; ?></td>
                        <td><a href="<?php echo base_url('godmode').'/validateProofOfPayment/'.$row->id;?>" class="btn btn-success" role="button"><i class="glyphicon glyphicon-ok"></i> Approve</a></td>


                    </tr>
                    <?php
                    $ai++;
                } ?>
                </tbody>
            </table>
            <h5 style="text-align: center"><a href="<?php echo base_url('godmode'); ?>" class="btn btn-danger"
                                              role="button">Back</a></h5>

        </div>
        <div id='3' class="col-sm-3">
        </div>
    </div>


</div>
