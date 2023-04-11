<?php
ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);
  
isAdmin();
//$menu_permission = explode('||', $_SESSION["menu_permission"]);


//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
   
    try{
        $is_exist = $dbcon->GetOneRecord("internal_course_mapping", "course_id", " course_id = '". $_REQUEST["course_id"] ."' AND del_status", 0);
        if ($is_exist != "") {
            $_SESSION['msg_err'] = "course mapping already exist..!";
            header("location:course_mapping.php");
            die();
        }

        $created_by = $_SESSION["user_id"];
        $created_dt = date('Y-m-d H:i:s');

        ## Fetch Course records
        $data_sql ="SELECT course_code, course_name, degree_id, study_year, semester FROM exam_course WHERE del_status = 0 And id =".$_REQUEST['course_id'];   
        $courseRecords = $con->query($data_sql)->fetch();

        ## Fetch Staff records
        $data_sql ="SELECT staff_name FROM tbl_staffs WHERE del_status = 0 And id =".$_REQUEST['staff_id'];   
        $staffRecords = $con->query($data_sql)->fetch();

      
        $stmt = null;

        $stmt = $con->prepare("INSERT INTO internal_course_mapping (course_id, staff_id, staff_name, course_code, course_name, degree_id, study_year, semester, created_by, created_dt) 
                        VALUE(:course_id, :staff_id, :staff_name, :course_code, :course_name, :degree_id, :study_year, :semester, :created_by, :created_dt)");
        $data = array(
            ":course_id" => trim($_REQUEST['course_id']),
            ":staff_id" => trim($_REQUEST['staff_id']),
            ":staff_name" => trim($staffRecords->staff_name),
            ":course_code" => trim($courseRecords->course_code),
            ":course_name" => trim($courseRecords->course_name), 
            ":degree_id" => trim($courseRecords->degree_id),
            ":study_year" => trim($courseRecords->study_year),
            ":semester" => trim($courseRecords->semester),                    
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        // echo "<pre>"; print_r($data); die();
        $stmt->execute($data);        
        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: course_mapping_lst.php");
    die();
}
//---------------------------------save/submit----------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) {
    try{
        //echo "Update"; die();
        $updated_by = 0;
        $updated_dt = date('Y-m-d H:i:s');

        $data_sql ="SELECT course_code, course_name, degree_id, study_year, semester FROM exam_course WHERE del_status = 0 And id =".$_REQUEST['course_id'];   
        $courseRecords = $con->query($data_sql)->fetch();

        ## Fetch Staff records
        $data_sql ="SELECT staff_name FROM tbl_staffs WHERE del_status = 0 And id =".$_REQUEST['staff_id'];   
        $staffRecords = $con->query($data_sql)->fetch();

        $stmt = null;
        $stmt = $con->prepare("UPDATE internal_course_mapping SET course_id=:course_id, staff_id=:staff_id, staff_name=:staff_name, course_code=:course_code, course_name=:course_name, degree_id=:degree_id, study_year=:study_year, semester=:semester, updated_by=:updated_by, updated_dt=:updated_dt where id=:id");
        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
            ":course_id" => trim($_REQUEST["course_id"]),
            ":staff_id" => trim($_REQUEST["staff_id"]),
            ":staff_name" => trim($staffRecords->staff_name),
            ":course_code" => trim($courseRecords->course_code),
            ":course_name" => trim($courseRecords->course_name), 
            ":degree_id" => trim($courseRecords->degree_id),
            ":study_year" => trim($courseRecords->study_year),
            ":semester" => trim($courseRecords->semester),             
            ":updated_by" => $updated_by,
            ":updated_dt" => $updated_dt
        );
        //echo "<pre>"; print_r($data); die();
        $stmt->execute($data);
        $_SESSION["msg"] = "Updated Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }

    header("location:course_mapping_lst.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE internal_course_mapping SET del_status=1 WHERE id=" . base64_decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:course_mapping_lst.php");
    die();
}
//---------------------------------delete----------------------------------------

if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM internal_course_mapping where id=" . base64_decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
            $course_id = $obj->course_id;
            $staff_id = $obj->staff_id;           
        }
    }
}
?>


<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Course Mapping
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Course Mapping</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php 
                if (isset($_REQUEST["id"])){
                ?>
                <h3 class="box-title">Update</h3>
                <?php
                }else {
                ?>
                  <h3 class="box-title">Add</h3>
                <?php
                }
                ?>
                <?php 
                //if(in_array('viewStudents',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="course_mapping_lst.php" class="btn btn-block btn-primary"><i class="fa fa-bars" aria-hidden="true"></i></a>
                </div>
                <?php
                //}
                ?>
            </div>
            <br />
            <form id="thisForm" name="thisForm" action="course_mapping.php" method="post">
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">                                                            
                                <div class="form-group">
                                    <label class="col-form-label">Staff Id <span class="err">*</span></label>
                                    <select class="form-control select2" name="staff_id" id="staff_id" title="Select the Degree" required oninvalid="this.setCustomValidity('Please select the staff...!')" onchange="this.setCustomValidity('')">
                                        <option value=""></option>
                                        <?php
                                            echo $dbcon->fnFillComboFromTable_Where("id", "staff_name", "tbl_staffs", "staff_name", " WHERE del_status = 0");
                                        ?>
                                    </select>
                                    <script>document.thisForm.staff_id.value = "<?php echo $staff_id; ?>"</script>
                                </div>                               
                              
                            </div>

                            <div class="col-md-6">
                            <div class="form-group">
                                    <label class="col-form-label">Course<span class="err">*</span></label>
                                    <select class="form-control select2" name="course_id" id="course_id" title="Select the Degree" required oninvalid="this.setCustomValidity('Please select the course...!')" onchange="this.setCustomValidity('')">
                                        <option value=""></option>
                                        <?php
                                            echo $dbcon->fnFillComboFromTable_Where("id", "course_name", "exam_course", "course_name", " WHERE del_status = 0");
                                        ?>
                                    </select>
                                    <script>document.thisForm.course_id.value = "<?php echo $course_id; ?>"</script>
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
    </section>
</div>
<?php include("includes/footer.php"); ?>
<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masteCourseSubNav').addClass('active');
});

</script>