<?php
ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH . "includes/common/connection.php");
require_once(BASEPATH . "includes/common/dbfunctions.php");
require_once(BASEPATH . "includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
$course_id = base64_decode($_REQUEST['course_id']);
$degree_id = base64_decode($_REQUEST['degree_id']);
$semester = base64_decode($_REQUEST['semester']);
$study_year = base64_decode($_REQUEST['study_year']);

//echo $course_id;die();

isAdmin();
//$menu_permission = explode('||', $_SESSION["menu_permission"]);

if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM tbl_internal_marks where del_status = 0 and course_id=" . base64_decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        $sno = 0;
        while ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id[] = $obj->id;
            $internal_mark[] = $obj->internal_mark; 
        }
        $sno++;
    }
}



?>
<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>

<?php

$rs = $con->query("SELECT * FROM tbl_students where del_status = 0 and degree='" . $degree_id . "' and study_year='" . $study_year . "' and semester='" . $semester . "' ");

$row_count = $rs->rowCount();
?>

<div class="content-wrapper">
    <section class="content-header">
    <?php if(isset($_REQUEST["id"])){
                    echo '<h3 class="box-title">Internal Marks Update</h3>';
                }else{
                    echo '<h3 class="box-title">Internal Marks Entry</h3>';
                } ?>      
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-desktop"></i> Transactions</a></li>
            <li class="active">Internal Marks Entry</li>
        </ol>
    </section>

    <section class="content">
        <div class="box box-primary">
            <div class="box-body">
             <!-- <form id="thisForm" name="thisForm" class="form-horizontal" action="internal_marks_entry.php" method="post"> -->
             <div class="box-footer text-right">
                <?php 
                    echo '<h4 class="">Degree: '.$dbcon->GetOneRecord('tbl_degree','dname','id',$degree_id).', Year: '."$study_year".',   Semester: '."$semester".'</h4>';
                ?>         
             </div>
             <form id="thisForm" name="thisForm" class="form-horizontal" action="internal_marks.php?course_id='<?php echo base64_encode($course_id)?>'&degree_id='<?php echo base64_encode($degree_id)?>'&study_year='<?php echo base64_encode($study_year)?>'&semester='<?php echo base64_encode($semester)?>'" method="post">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="table-responsive">
                                <div class="dt-responsive table-responsive">
                                    <table id="example1" class="table table-bordered table-striped">
                                        <thead>
                                            <tr>
                                                <th width="100" class="text-center">#</th>
                                                <th width="150">Reg No</th>
                                                <th width="150">Marks</th>
                                                <th class="text-center">Student Name</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            if ($row_count) {
                                                $sno = 1;
                                                while ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
                                                    if ($sno <= 30) {

                                                        $reg_input = '<input type="hidden" class="form-control" name="s_id[]" value="' . $obj->id . '"><input type="hidden" class="form-control" name="reg_no[]" value="' . $obj->regno . '">';
                                                        $mark_input = '<input type="text" class="form-control" name="internal_mark[]" value="'.iif(($_REQUEST["id"]), $internal_mark[$sno-1], "0").'" id="internal_mark" maxlength="2"  title="Enter the Internal Mark" autocomplete="off" onKeyPress="return isNumberKey(event);" required oninvalid="this.setCustomValidity("Please enter the Internal Mark...!.")" oninput="this.setCustomValidity("")" >';
                                                        $student_name_input = '<input type="hidden" class="form-control" name="student_name[]" value="' . $obj->student_name . '">';
                                            ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $sno; ?></td>
                                                            <td><?php echo  $reg_input . $obj->regno; ?></td>
                                                            <td><?php echo  $mark_input; ?></td>
                                                            <td><?php echo  $student_name_input . $obj->student_name; ?></td>
                                                        </tr>
                                                <?php
                                                        $sno++;
                                                    }
                                                }
                                            } else {
                                                ?>
                                                <tr>
                                                    <td colspan="5" align="center">--No Records Found--</td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                        <?php if ($row_count > 30) {  ?>
                            <div class="col-md-6">
                                <!-- <input type="submit" value="Submit" > -->
                                <div class="table-responsive">
                                    <div class="dt-responsive table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="100" class="text-center">#</th>
                                                    <th width="150">Reg No</th>
                                                    <th width="150">Marks</th>
                                                    <th class="text-center">Student Name</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $rs = $con->query("SELECT * FROM tbl_students where del_status = 0 and degree='" . $degree_id . "' and study_year='" . $study_year . "' and semester='" . $semester . "' LIMIT 5,10");

                                                $sno = 31;
                                                while ($obj = $rs->fetch(PDO::FETCH_OBJ)) {

                                                    if ($sno <= 60) {

                                                        $reg_input = '<input type="hidden" class="form-control" name="s_id[]" value="' . $obj->id . '"><input type="hidden" class="form-control" name="reg_no[]" value="' . $obj->regno . '">';
                                                        $mark_input = '<input type="text" class="form-control" name="internal_mark[]" value="'.iif(($_REQUEST["id"]), $internal_mark[$sno-1], "0").'" id="internal_mark" maxlength="2" value="0" title="Enter the Internal Mark" autocomplete="off" onKeyPress="return isNumberKey(event);" required oninvalid="this.setCustomValidity("Please enter the Internal Mark...!.")" oninput="this.setCustomValidity("")" >';
                                                        $student_name_input = '<input type="hidden" class="form-control" name="student_name[]" value="' . $obj->student_name . '">';
                                                ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $sno; ?></td>
                                                            <td><?php echo  $reg_input . $obj->regno; ?></td>
                                                            <td><?php echo  $mark_input; ?></td>
                                                            <td><?php echo  $student_name_input . $obj->student_name; ?></td>
                                                        </tr>
                                                <?php
                                                        $sno++;
                                                    }
                                                }

                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($row_count > 60) {  ?>
                            <div class="col-md-6">
                                <!-- <input type="submit" value="Submit" > -->
                                <div class="table-responsive">
                                    <div class="dt-responsive table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="100" class="text-center">#</th>
                                                    <th width="150">Reg No</th>
                                                    <th width="150">Marks</th>
                                                    <th class="text-center">Student Name</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $rs = $con->query("SELECT * FROM tbl_students where del_status = 0 and degree='" . $degree_id . "' and study_year='" . $study_year . "' and semester='" . $semester . "' LIMIT 10,15");
                                                $sno = 61;
                                                while ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
                                                    if ($sno <= 90) {

                                                        $reg_input = '<input type="hidden" class="form-control" name="s_id[]" value="' . $obj->id . '"><input type="hidden" class="form-control" name="reg_no[]" value="' . $obj->regno . '">';
                                                        $mark_input = '<input type="text" class="form-control" name="internal_mark[]" value="'.iif(($_REQUEST["id"]), $internal_mark[$sno-1], "0").'" id="internal_mark" maxlength="2" value="0" title="Enter the Internal Mark" autocomplete="off" onKeyPress="return isNumberKey(event);" required oninvalid="this.setCustomValidity("Please enter the Internal Mark...!.")" oninput="this.setCustomValidity("")" >';
                                                        $student_name_input = '<input type="hidden" class="form-control" name="student_name[]" value="' . $obj->student_name . '">';
                                                ?>
                                                        <tr>
                                                            <td class="text-center"><?php echo $sno; ?></td>
                                                            <td><?php echo  $reg_input . $obj->regno; ?></td>
                                                            <td><?php echo  $mark_input; ?></td>
                                                            <td><?php echo  $student_name_input . $obj->student_name; ?></td>
                                                        </tr>
                                                <?php
                                                        $sno++;
                                                    }
                                                }

                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                        <?php if ($row_count > 90) {  ?>
                            <div class="col-md-6">
                                <!-- <input type="submit" value="Submit" > -->
                                <div class="table-responsive">
                                    <div class="dt-responsive table-responsive">
                                        <table id="example1" class="table table-bordered table-striped">
                                            <thead>
                                                <tr>
                                                    <th width="100" class="text-center">#</th>
                                                    <th width="150">Reg No</th>
                                                    <th width="150">Marks</th>
                                                    <th class="text-center">Student Name</th>

                                                </tr>
                                            </thead>
                                            <tbody>
                                                <?php
                                                $rs = $con->query("SELECT * FROM tbl_students where del_status = 0 and degree='" . $degree_id . "' and study_year='" . $study_year . "' and semester='" . $semester . "' LIMIT 10,$row_count");

                                                $sno = 91;
                                                while ($obj = $rs->fetch(PDO::FETCH_OBJ)) {

                                                    $reg_input = '<input type="hidden" class="form-control" name="s_id[]" value="' . $obj->id . '"><input type="hidden" class="form-control" name="reg_no[]" value="' . $obj->regno . '">';
                                                    $mark_input = '<input type="text" class="form-control" name="internal_mark[]" value="'.iif(($_REQUEST["id"]), $internal_mark[$sno-1], "0").'" id="internal_mark" maxlength="2" value="0" title="Enter the Internal Mark" autocomplete="off" onKeyPress="return isNumberKey(event);" required oninvalid="this.setCustomValidity("Please enter the Internal Mark...!.")" oninput="this.setCustomValidity("")" >';
                                                    $student_name_input = '<input type="hidden" class="form-control" name="student_name[]" value="' . $obj->student_name . '">';
                                                ?>
                                                    <tr>
                                                        <td class="text-center"><?php echo $sno; ?></td>
                                                        <td><?php echo  $reg_input . $obj->regno; ?></td>
                                                        <td><?php echo  $mark_input; ?></td>
                                                        <td><?php echo  $student_name_input . $obj->student_name; ?></td>
                                                    </tr>
                                                <?php
                                                    $sno++;
                                                }

                                                ?>

                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="box-footer text-right">
                  <?php if (isset($_REQUEST["id"])) {                 
                       foreach($id as $value)
                      {
                       echo '<input type="hidden" name="hid_id[]" value="'. $value. '">';
                      }
                    ?>
                    <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Update</button>
                    <?php } else if($row_count>0) { ?>
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Save</button>
                    <?php } ?>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>
<?php include("includes/footer.php"); ?>