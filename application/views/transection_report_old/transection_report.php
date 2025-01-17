<!--main content start-->
<section id="main-content">
    <section class="wrapper site-min-height">
        <div class="row">
            <div class="col-lg-12">
                <section class="panel">
                    <header class="panel-heading">
                        Add Salary Process
                    </header>
                    <div class="panel-body">
                        <form role="form" class="cmxform form-horizontal tasi-form" id="MenuForm"  method="post"  id="commentForm" action="<?php echo site_url('transection_report/salaryProcess'); ?>">
                            <div class="form-group">
                                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">From *</label>
                                <div class="col-lg-2">
                                    <input type="text" class="default-date-picker form-control" placeholder="Enter From" id="date_from"  name="date_from" value="<?php
                                    if (isset($date_from)) {
                                        echo $date_from;
                                    } else {
                                       // echo date('Y-m-d');
                                    }
                                    ?>" required>
                                </div>
                                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">To *</label>
                                <div class="col-lg-2">
                                    <input type="text" class="default-date-picker form-control" placeholder="Enter To" id="date_to"  name="date_to" value="<?php
                                    if (isset($date_to)) {
                                        echo $date_to;
                                    } else {
                                     //   echo date('Y-m-d');
                                    }
                                    ?>" required>
                                </div>

                                <label for="inputSuccess" class="col-sm-2 control-label col-lg-2">Type*</label>
                                <div class="col-lg-2">
                                    <select class="form-control" id="r_type" name="r_type" >  <!-- input-sm m-bot15  -->
                                        <option value="">Select</option>
                                        <option value="1" <?php
                                        if (isset($r_type)) {

                                            if ($r_type == 1) {
                                                echo 'selected';
                                            }
                                        }
                                        ?>>Income</option>
                                        <option value="2" <?php
                                                if (isset($r_type)) {

                                                    if ($r_type == 2) {
                                                        echo 'selected';
                                                    }
                                                }
                                        ?>>Expense</option>
                                    </select>
                                </div>

                            </div>


                            <button type="submit"   class="btn btn-info pull-right ">Submit</button>

                        </form>

                    </div>
                </section>
            </div>
        </div>

        <div class="row">
            <div class="col-sm-12">
                <section class="panel">
                    <header class="panel-heading">
                        Transection Report
                        <span class="tools pull-right">
                            <a href="javascript:;" class="fa fa-chevron-down"></a>
                            <a href="javascript:;" class="fa fa-times"></a>
                        </span>
                    </header>
                    <div class="panel-body">
                        <div class="adv-table">
                            <table class="display table table-bordered" id="hidden-table-info">
                                <thead>
                                    <tr>

                                        <th>Tranx Type</th>
                                        <th>Note</th>
                                        <th>Income</th>
                                        <th>Expense </th>
                                        <th>Date & Time</th>



                                    </tr>
                                </thead>
                                <tbody>
<?php
foreach ($get_report_data as $row) :
    $id = $row->id;
    $table_id = $row->table_id;
    $table_type = $row->table_type;
    $transaction_type = $row->transaction_type;
    $date = $row->date;


    $query_1 = $this->db->query("select * from table_relation where id='$table_type'");
    $result_1 = $query_1->result();
    foreach ($result_1 as $row_add):
        $table_name = $row_add->name;
        $trx_type = $row_add->type;
    endforeach;



    if ($table_type == 1):

        $query_1 = $this->db->query("select * from $table_name where id='$table_id'");
        $result_1 = $query_1->result();
        foreach ($result_1 as $row_add):
            $note = '';
            $gross_salary = $row_add->gross_salary;

            $salary_add = $row_add->salary_add;
            $salary_add_arr = explode('-', $salary_add);

            $salary_deduct = $row_add->salary_deduct;
            $salary_deduct_arr = explode('-', $salary_deduct);

            $sum_add = 0;
            $sum_deduct = 0;
            if (count($salary_add_arr) > 0):
                foreach ($salary_add_arr as $value) :

                    $query_2 = $this->db->query("select * from employee_salary_add where id='$value'");
                    $result_2 = $query_2->result();
                    foreach ($result_2 as $row2):
                        $amount = $row2->amount;
                        $sum_add +=$amount;
                    endforeach;

                endforeach;
            endif;

            if (count($salary_deduct_arr) > 0):
                foreach ($salary_deduct_arr as $value) :

                    $query_2 = $this->db->query("select * from employee_salary_deduct where id='$value'");
                    $result_2 = $query_2->result();
                    foreach ($result_2 as $row2):
                        $amount = $row2->amount;
                        $sum_deduct +=$amount;
                    endforeach;

                endforeach;
            endif;


            $expense = ($gross_salary + $sum_add) - $sum_deduct;
            $note = '';
            $income = '';


        endforeach;

    elseif ($table_type == 2):

        $query_1 = $this->db->query("select * from $table_name where id='$table_id'");
        $result_1 = $query_1->result();
        foreach ($result_1 as $row_add):
            $expense = $row_add->amount;
            $note = $row_add->note;
            $income = '';
        endforeach;

    elseif ($table_type == 3):

        $query_1 = $this->db->query("select * from $table_name where id='$table_id'");
        $result_1 = $query_1->result();
        foreach ($result_1 as $row_add):
            $expense = '';
            $note = $row_add->note;
            $income = $row_add->amount;
        endforeach;


    elseif ($table_type == 4):

        $query_1 = $this->db->query("select * from $table_name where id='$table_id'");
        $result_1 = $query_1->result();
        foreach ($result_1 as $row_add):
            $expense = '';
            $note = $row_add->note;
            $income = $row_add->payment;
        endforeach;

    elseif ($table_type == 5):

        $query_1 = $this->db->query("select * from $table_name where id='$table_id'");
        $result_1 = $query_1->result();
        foreach ($result_1 as $row_add):
            $expense = $row_add->payment;
            $note = $row_add->note;
            $income = '';
        endforeach;

    endif;
    ?>
                                        <tr>

                                            <td><?php echo $trx_type ?></td>
                                            <td><?php echo $note ?></td>
                                            <td><?php echo $income ?></td>
                                            <td><?php echo $expense ?></td>
                                            <td><?php echo $date ?></td>


                                        </tr>

<?php endforeach; ?>
                                </tbody>
                            </table>

                        </div>
                    </div>
                </section>
            </div>
        </div>

        <!-- Modal -->
        <div class="modal fade" id="myModalDelete" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <form method="post" action="<?= site_url('add_menu/deleteMenu') ?>">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                            <h4 class="modal-title">Delete Menu Confirmation</h4>
                        </div>
                        <div class="modal-body">

                            Do You Want To Delete This Menu?
                            <input type="hidden" id="delete_menu_id" name="delete_menu_id" />
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-success" type="submit">Yes</button>
                            <button data-dismiss="modal" class="btn btn-default" type="button">No</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
        <!-- modal -->

        <!-- Modal -->
        <div class="modal fade" id="myModalEdit" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                        <h4 class="modal-title">Edit Type Confirmation</h4>
                    </div>

                    <div class="modal-body">
                        <form role="form" class="form-horizontal" method="post" action="<?php echo site_url('salary_add_type/editMenu'); ?>">
                            <div class="form-group">
                                <label class="col-lg-3 col-sm-3 control-label" for="name">Type</label>
                                <div class="col-lg-9">
                                    <input type="text" placeholder="Enter Type Name" id="edit_type_name" name="edit_type_name" class="form-control">
                                    <input type="hidden" id="edit_type_id" name="edit_type_id" />
                                </div>
                            </div>
                            <div class="form-group">
                                <div class="col-lg-offset-3 col-lg-9">
                                    <button class="btn btn-success" type="submit">Submit</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button data-dismiss="modal" class="btn btn-default" type="button">Close</button>
                    </div>

                </div>
            </div>
        </div>
        <!-- modal -->

    </section>
</section>
<!--main content end-->
