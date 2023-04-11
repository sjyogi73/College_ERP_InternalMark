<?php
ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();
$converter = new Encryption;

// ini_set('display_errors', '1'); // ini_set('display_startup_errors', '1'); // error_reporting(E_ALL);

isAdmin();
//$menu_permission = explode('||', $_SESSION["menu_permission"]);

$img_name = "image_holder.jpg";
$img_path = "resources/courseImages/image_holder.jpg";

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
    try{
        $created_by = $_SESSION["user_id"];
        $created_dt = date('Y-m-d H:i:s');

        if ($_FILES['image_file']['name'] != "") {
            $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $customfilename = 'Course-' . trim($_REQUEST["course_code"]) . '.' . $ext;
            $_REQUEST['image_file'] = post_img($customfilename, $_FILES['image_file']['tmp_name'], "resources/courseImages/");
        }

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO exam_course (course_code, course_name, course_type, course_part, degree_id, study_year, semester, hours_week, credits, exam_hours, max_int, max_ext, max_tot, syllabus_file, created_by, created_dt) 
                        VALUE(:course_code, :course_name, :course_type, :course_part, :degree_id, :study_year, :semester, :hours_week, :credits, :exam_hours, :max_int, :max_ext, :max_tot, :syllabus_file, :created_by, :created_dt)");
        $data = array(
            ":course_code" => trim(strtoupper($_REQUEST["course_code"])),
            ":course_name" => trim(ucwords($_REQUEST["course_name"])),
            ":course_type" => trim($_REQUEST["course_type"]),
            ":course_part" => trim($_REQUEST["course_part"]),
            ":degree_id" => trim($_REQUEST["degree_id"]),
            ":study_year" => trim($_REQUEST["study_year"]),
            ":semester" => trim($_REQUEST["semester"]),
            ":hours_week" => trim($_REQUEST["hours_week"]),
            ":credits" => trim($_REQUEST["credits"]),
            ":exam_hours" => trim($_REQUEST["exam_hours"]),
            ":max_int" => trim($_REQUEST["max_int"]),
            ":max_ext" => trim($_REQUEST["max_ext"]),
            ":max_tot" => trim($_REQUEST["max_tot"]),
            ":syllabus_file" => trim($_REQUEST['image_file']),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        //echo "<pre>"; print_r($data); die();
        $stmt->execute($data);

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: course_lst.php");
    die();
}
//---------------------------------save/submit----------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) {
    try{
        //echo "Update"; die();
       $updated_by = $_SESSION["user_id"]; 0;
        $updated_dt = date('Y-m-d H:i:s');

        if ($_FILES['image_file']['name'] != "") {
            if ($_REQUEST["hide_image_file"] != "") {
                removeFile("resources/staffImages/" . $_REQUEST["hide_image_file"]);
            }
            $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $customfilename = 'Course-' . trim($_REQUEST["course_code"]) . '.' . $ext;
            $_REQUEST['image_file'] = post_img($customfilename, $_FILES['image_file']['tmp_name'], "resources/courseImages/");
        } else {
            $_REQUEST['image_file'] = $_REQUEST["hide_image_file"];
        }

        $stmt = null;
        $stmt = $con->prepare("UPDATE exam_course SET course_code=:course_code, course_name=:course_name, course_type=:course_type, course_part=:course_part, degree_id=:degree_id, study_year=:study_year, semester=:semester, hours_week=:hours_week, credits=:credits, exam_hours=:exam_hours, max_int=:max_int, max_ext=:max_ext, max_tot=:max_tot, syllabus_file=:syllabus_file, updated_by=:updated_by, updated_dt=:updated_dt where id=:id");
        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
            ":course_code" => trim(strtoupper($_REQUEST["course_code"])),
            ":course_name" => trim(ucwords($_REQUEST["course_name"])),
            ":course_type" => trim($_REQUEST["course_type"]),
            ":course_part" => trim($_REQUEST["course_part"]),
            ":degree_id" => trim($_REQUEST["degree_id"]),
            ":study_year" => trim($_REQUEST["study_year"]),
            ":semester" => trim($_REQUEST["semester"]),
            ":hours_week" => trim($_REQUEST["hours_week"]),
            ":credits" => trim($_REQUEST["credits"]),
            ":exam_hours" => trim($_REQUEST["exam_hours"]),
            ":max_int" => trim($_REQUEST["max_int"]),
            ":max_ext" => trim($_REQUEST["max_ext"]),
            ":max_tot" => trim($_REQUEST["max_tot"]),
            ":syllabus_file" => trim($_REQUEST['image_file']),
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

    header("location:course_lst.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE exam_course SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:course_lst.php");
    die();
}
//---------------------------------delete----------------------------------------

if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM exam_course where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
            $course_code = $obj->course_code;
            $course_name = $obj->course_name;
            $course_type = $obj->course_type;
            $course_part = $obj->course_part;
            $degree_id = $obj->degree_id;
            $study_year = $obj->study_year;
            $semester = $obj->semester;
            $hours_week = $obj->hours_week;
            $credits = $obj->credits;
            $exam_hours = $obj->exam_hours;
            $max_int = $obj->max_int;
            $max_ext = $obj->max_ext;
            $max_tot = $obj->max_tot;

            $image_file = $obj->syllabus_file;
            if ($image_file != '') {
                $img_name = $image_file;
                $img_path = "resources/courseImages/". $image_file;
            }
        }
    }
}
?>

<link href="<?php echo BASEPATH; ?>assets/dist/css/bootstrap-imageupload.css" rel="stylesheet">

<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Course
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Course</li>
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
                //if(in_array('viewStudents',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="course_lst.php" class="btn btn-block btn-primary"><i class="fa fa-bars" aria-hidden="true"></i></a>
                </div>
                <?php
                //}
                ?>
            </div>
            <br />
            <form id="thisForm" name="thisForm" action="course.php" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-4">
                                <div class="form-group">
                                    <!-- <label class="col-sm-4 control-label">Register No. *</label> -->
                                    <label class="col-form-label">Course Code (CAPS) <span class="err">*</span></label>
                                    <input type="text" class="form-control" name="course_code" id="course_code" placeholder="Enter the Course Code" title="Enter the Course Code" autocomplete="off" autofocus="autofocus" onKeyPress="return isCapitalNumericNoSpace(event);" required oninvalid="this.setCustomValidity('Please enter the course code...!')" oninput="this.setCustomValidity('')" maxlength="20" value="<?php echo $course_code; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Course Name <span class="err">*</span></label>
                                    <input type="text" class="form-control" name="course_name" id="course_name" placeholder="Enter the Course Name" title="Enter the Course Name" autocomplete="off" onKeyPress="return isNameKey(event);" required oninvalid="this.setCustomValidity('Please enter the course name...!')" oninput="this.setCustomValidity('')" maxlength="50" value="<?php echo $course_name; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Course Type <span class="err">*</span></label>
                                    <select class="form-control select2" name="course_type" id="course_type" title="Select the Course Type" required oninvalid="this.setCustomValidity('Please select the course type...!')" onchange="this.setCustomValidity('')">
                                        <option value=""></option>
                                        <?php
                                            echo $dbcon->fnFillComboFromTable_Where("id", "course_type", "exam_course_type", "course_type", " WHERE del_status = 0");
                                        ?>
                                    </select>
                                    <script>document.thisForm.course_type.value = "<?php echo $course_type; ?>"</script>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Course Part <span class="err">*</span></label>
                                    <select class="form-control select2" name="course_part" id="course_part" title="Select the Course Part" required oninvalid="this.setCustomValidity('Please select the course part...!')" onchange="this.setCustomValidity('')">
                                        <option value=""></option>
                                        <option value="1">I</option>
                                        <option value="2">II</option>
                                        <option value="3">III</option>
                                        <option value="4">IV</option>
                                        <option value="5">V</option>
                                        <option value="6">VI</option>
                                    </select>
                                    <script>document.thisForm.course_part.value = "<?php echo $course_part; ?>"</script>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Degree <span class="err">*</span></label>
                                    <select class="form-control select2" name="degree_id" id="degree_id" title="Select the Degree" required oninvalid="this.setCustomValidity('Please select the degree...!')" onchange="this.setCustomValidity('')">
                                        <option value=""></option>
                                        <?php
                                            echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_degree", "dname", " WHERE del_status = 0");
                                        ?>
                                    </select>
                                    <script>document.thisForm.degree_id.value = "<?php echo $degree_id; ?>"</script>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Year <span class="err">*</span></label>
                                    <select class="form-control select2" name="study_year" id="study_year" title="Select the Studying Year" required oninvalid="this.setCustomValidity('Please select the studying year...!')" onchange="this.setCustomValidity('')">
                                        <option value=""></option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                    </select>
                                    <script>document.thisForm.study_year.value = "<?php echo $study_year; ?>"</script>
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Semester <span class="err">*</span></label>
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label">Hours/Week</label>
                                    <input type="text" class="form-control" name="hours_week" id="hours_week" maxlength="2" placeholder="Enter the Hours/Week" title="Enter the Hours/Week" autocomplete="off" onKeyPress="return isNumberKey(event);" value="<?php echo $hours_week; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Credits <span class="err">*</span></label>
                                    <input type="text" class="form-control" name="credits" id="credits" maxlength="2" placeholder="Enter the Credits" title="Enter the Credits" autocomplete="off" onKeyPress="return isNumberKey(event);" required oninvalid="this.setCustomValidity('Please enter the credits...!')" oninput="this.setCustomValidity('')" value="<?php echo $credits; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Exam Hours</label>
                                    <input type="text" class="form-control" name="exam_hours" id="exam_hours" maxlength="2" placeholder="Enter the Exam Hours" title="Enter the Exam Hours" autocomplete="off" onKeyPress="return isNumberKey(event);" value="<?php echo $exam_hours; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Maximum Internal Mark</label>
                                    <input type="text" class="form-control" name="max_int" id="max_int" maxlength="2" placeholder="Enter the Maximum Internal Mark" title="Enter the Maximum Internal Mark" autocomplete="off" onKeyPress="return isNumberKey(event);" value="<?php echo $max_int; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Maximum External Mark</label>
                                    <input type="text" class="form-control" name="max_ext" id="max_ext" maxlength="2" placeholder="Enter the Maximum External Mark" title="Enter the Maximum External Mark" autocomplete="off" onKeyPress="return isNumberKey(event);" value="<?php echo $max_ext; ?>">
                                </div>
                                <div class="form-group">
                                    <label class="col-form-label">Maximum Total Mark</label>
                                    <input type="text" class="form-control" name="max_tot" id="max_tot" maxlength="3" placeholder="Enter the Maximum Total Mark" title="Enter the Maximum Total Mark" autocomplete="off" onKeyPress="return isNumberKey(event);" value="<?php echo $max_tot; ?>">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group" style="padding: 0px !important;">
                                    <input type="hidden" name="hide_image_file" value="<?php echo $image_file; ?>">
                                    <!-- ------------------- Image Upload ---------------------- -->
                                    <div class="imageupload panel panel-default">
                                        <div class="panel-heading clearfix">
                                            <h3 class="panel-title pull-left">Syllabus Image</h3>
                                            <div class="btn-group pull-right">
                                                <button type="button" class="btn btn-default active">File</button>
                                                <button type="button" class="btn btn-default">URL</button>
                                            </div>
                                        </div>
                                        <div class="file-tab panel-body">
                                            <label class="btn btn-default btn-file">
                                                <span>Browse</span>
                                                <!-- The file is stored here. -->
                                                <input type="file" name="image_file">
                                            </label>
                                            <button type="button" class="btn btn-default">Remove</button>
                                        </div>
                                        <div class="url-tab panel-body">
                                            <div class="input-group">
                                                <input type="text" class="form-control hasclear" placeholder="Image URL">
                                                <div class="input-group-btn">
                                                    <button type="button" class="btn btn-default">Submit</button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-default">Remove</button>
                                            <!-- The URL is stored here. -->
                                            <input type="hidden" name="image-url">
                                        </div>
                                    </div>
                                    <!-- ------------------- Image Upload ---------------------- -->
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

<script src="<?php echo BASEPATH; ?>assets/dist/js/bootstrap-imageupload.js"></script>

<script type="text/javascript">
var $imageupload = $('.imageupload');
    $imageupload.imageupload({
    allowedFormats: [ 'jpg', 'jpeg', 'png', 'gif' ],
    maxWidth: 500,
    maxHeight: 500,
    maxFileSizeKb: 1024,
    imgSrc: "<?php echo $img_path; ?>" 
});

$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterCourseSubNav').addClass('active');
});
</script>