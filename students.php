<?php
ob_start();
session_start();

require_once("includes/common/connection.php");
require_once("includes/common/dbfunctions.php");
require_once("includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();
$converter = new Encryption;

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

isAdmin();
$menu_permission = explode('||', $_SESSION["menu_permission"]);

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
    try{
        $created_by = 1;
        $created_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO tbl_students (regno, student_name, degree, study_year, semester, mobile_no, created_by, created_dt) 
                        VALUES (:regno, :student_name, :degree, :study_year, :semester, :mobile_no, :created_by, :created_dt)");
        $data = array(
            ":regno" => trim(strtoupper($_REQUEST["regno"])),
            ":student_name" => trim(ucwords($_REQUEST["student_name"])),
            ":degree" => trim($_REQUEST["degree"]),
            ":study_year" => trim($_REQUEST["study_year"]),
            ":semester" => trim($_REQUEST["semester"]),
            ":mobile_no" => trim($_REQUEST["mobile_no"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        $stmt->execute($data);

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: students_lst.php");
    die();
}
//---------------------------------save/submit----------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) {
    try{
        //echo "Update"; die();
       $updated_by = $_SESSION["user_id"]; 0;
        $updated_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("UPDATE tbl_students SET regno=:regno, student_name=:student_name, degree=:degree, study_year=:study_year, semester=:semester, mobile_no=:mobile_no, updated_by=:updated_by, updated_dt=:updated_dt where id=:id");
        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
            ":regno" => trim(strtoupper($_REQUEST["regno"])),
            ":student_name" => trim(ucwords($_REQUEST["student_name"])),
            ":degree" => trim($_REQUEST["degree"]),
            ":study_year" => trim($_REQUEST["study_year"]),
            ":semester" => trim($_REQUEST["semester"]),
            ":mobile_no" => trim($_REQUEST["mobile_no"]),
            ":updated_by" => $updated_by,
            ":updated_dt" => $updated_dt
        );
        //print_r($data); die();
        $stmt->execute($data);

        $_SESSION["msg"] = "Updated Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }

    header("location:students_lst.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE tbl_students SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:students_lst.php");
    die();
}
//---------------------------------delete----------------------------------------
//---------------------------------upload----------------------------------------
if (isset($_REQUEST["upload"])) {
    $filename=$_FILES["stud_file"]["tmp_name"];
    if($_FILES["stud_file"]["size"] > 0)
    {
        $file = fopen($filename, "r");
        fgetcsv($file);
        
        //$counter=0;
        while(($emapData = fgetcsv($file, 10000, ",")) !== FALSE)
        {
            //if($counter==0)
            //{ } 
            //else {
            
            //echo $emapData[0].$emapData[1].$emapData[2].$emapData[3].$emapData[4].$emapData[5];
            //die();
            
            //It wiil insert a row to our subject table from our csv file`
            $sql = "INSERT into tbl_students(regno, student_name, degree, study_year, semester, mobile_no) values ('$emapData[0]','$emapData[1]','$emapData[2]','$emapData[3]','$emapData[4]','$emapData[5]')";
            //we are using mysql_query function. it returns a resource on true else False on error
            $result=$con->query($sql);
            //echo $sql;
            //die();
            if(!$result)
            {
                echo "<script type=\"text/javascript\">
                            alert(\" Invalid File:Please Upload CSV File.\");
                            window.location = \"excel.php\"
                        </script>";
                
            }
            //}
            //$counter++;
        }
        fclose($file);
        //throws a message if data successfully imported to mysql database from excel file
        // echo "<script type=\"text/javascript\">
        //         alert(\"CSV File has been successfully Imported.\");
        //         window.location = \"excel.php\"
        //         </script>";
        //close of connection 
    }

    $_SESSION["msg"] = "CSV File has been successfully Imported";

    header("location:students_lst.php");
    die();
}
//---------------------------------upload----------------------------------------

if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM tbl_students where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
            $regno = $obj->regno;
            $student_name = $obj->student_name;
            $degree = $obj->degree;
            $study_year = $obj->study_year;
            $semester = $obj->semester;
            $mobile_no = $obj->mobile_no;
        }
    }
}
?>
<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Students
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Students</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php if(isset($_REQUEST["id"])){
                    echo '<h3 class="box-title">Edit</h3>';
                }else{
                    echo '<h3 class="box-title">Add</h3>';
                } ?>
                <?php 
                if(in_array('viewStudents',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="students_lst.php" class="btn btn-block btn-primary"><i class="fa fa-bars" aria-hidden="true"></i></a>
                </div>
                <?php
                }
                ?>
            </div>
            <br />
            <form id="thisForm" name="thisForm" class="form-horizontal" action="students.php" method="post">
                <div class="box-body">
                    <!-- <div class="col-md-10 col-md-offset-1"> -->
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <!-- <label class="col-sm-4 control-label">Register No. *</label> -->
                                    <label class="col-sm-4 col-form-label">Reg No. (CAPS) <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="regno" id="regno" placeholder="Enter the Register Number" title="Enter The Register Number" autocomplete="off" autofocus="autofocus" onKeyPress="return isCapitalNumericNoSpace(event);" required oninvalid="this.setCustomValidity('Please enter the register number...!')" oninput="this.setCustomValidity('')" maxlength="8" value="<?php echo $regno; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Student Name <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="student_name" id="student_name" placeholder="Enter the Student Name" title="Enter The Student Name" autocomplete="off" onKeyPress="return isNameKey(event);" required oninvalid="this.setCustomValidity('Please enter the student name...!')" oninput="this.setCustomValidity('')" maxlength="50" value="<?php echo $student_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Degree <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="degree" id="degree" title="Select the Degree" required oninvalid="this.setCustomValidity('Please select the degree...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <?php
                                                echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_degree", "dname", " WHERE del_status = 0");
                                            ?>
                                        </select>
                                        <script>document.thisForm.degree.value = "<?php echo $degree; ?>"</script>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Year <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="study_year" id="study_year" title="Select the Studying Year" required oninvalid="this.setCustomValidity('Please select the studying year...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                        </select>
                                        <script>document.thisForm.study_year.value = "<?php echo $study_year; ?>"</script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Semester <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="semester" id="semester" title="Select the Semester" required oninvalid="this.setCustomValidity('Please select the semester...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <option value="1">1</option>
                                            <option value="2">2</option>
                                            <option value="3">3</option>
                                            <option value="4">4</option>
                                            <option value="5">5</option>
                                            <option value="6">6</option>
                                        </select>
                                        <script>document.thisForm.semester.value = "<?php echo $semester; ?>"</script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Mobile No</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="mobile_no" id="mobile_no" maxlength="10" placeholder="Enter the Mobile No" onKeyPress="return isNumberKey(event);"  value="<?php echo $mobile_no; ?>">
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <?php if (isset($_REQUEST["id"])) { ?>
                    <input type="hidden" value="<?php echo $id; ?>" name="hid_id">
                    <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Update</button>
                    <?php } else { ?>
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                    <?php } ?>
                </div>
            </form>
        </div>

        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Student Details Upload</h3>
            </div>
            <br>
            <form id="thisForm" name="thisForm" class="form-horizontal" action="students.php" method="post" enctype="multipart/form-data">
            <div class="box-body">
                <div class="col-md-6 col-md-offset-3">
                    <div class="row">
                        <div class="form-group">
                            <label class="col-sm-5 control-label">Import Student CSV/Excel file <span class="err">*</span></label>
                            <div class="col-sm-5">
                                <input type="file" class="form-control" name="stud_file" id="stud_file" title="Browse and select the file to upload" required oninvalid="this.setCustomValidity('Please select the file to upload...!')" oninput="this.setCustomValidity('')" value="<?php echo $regno; ?>">
                                Click Here to Download the Sample Student File <a href="students.csv">Students.csv</a>
                            </div>
                            <div class="col-sm-2">
                                <button type="submit" name="upload" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Upload</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
        </div>
    </section>
</div>
<?php include("includes/footer.php"); ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterStudentSubNav').addClass('active');
});
</script>