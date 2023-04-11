<?php
ob_start();
session_start();
define('BASEPATH', '../../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

//ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

$con = new connection();
$dbcon = new dbfunctions();

isset($_POST["mode"]);

if($_POST["mode"]=="course_id")
{	
    $course_type = $dbcon->GetOneRecord("exam_course", "course_type", "id = ". $_POST["course_id"] ." AND del_status", 0);
	// $srchQuery = "SELECT id FROM exam_course_type WHERE del_status = 0 AND id = ". $_POST["fees_id"];
    // //echo $srchQuery;
    // $srchRecords = $con->query($srchQuery);
    
    // if($row = $srchRecords->fetch())
    // {
    //     $amount = $row->amount;
    // }
    
    echo $course_type;
}

if($_POST["mode"]=="modal_add_tt")
{	
    $url_data = explode("~", $_POST["id"]);
    //print_r($url_data); die;
    $tt_period = explode("-", $url_data[0]);
    $degree_id = $url_data[1];
    $tt_year = $url_data[2];
    $semester = $url_data[3];
    $staff_id = $url_data[4];
    $day_order = $tt_period[0];
    $days_hour = $tt_period[1];

    $html_output ="";
    $html_output ='<div class="row">
        <div class="col-lg-12">
        <div class="row txt-dets">
            <div class="col-md-12" style="line-height:2rem;">
                
                <div class="card-body" style="padding: 0px 15px;">
                    <div class="row">
                        <div class="col-md-2"><label class="col-form-label">Degree</label></div>
                        <div class="col-md-4 text-left">: '. $dbcon->GetOneRecord("tbl_degree", "dname", "id = ". $degree_id ." AND del_status", 0) .'<input type="hidden" name="degree_id" id="degree_id" value="'. $degree_id .'"></div>
                        <div class="col-md-2"><label class="col-form-label">Year</label></div>
                        <div class="col-md-1 text-left">: '. $tt_year .'<input type="hidden" name="tt_year" id="tt_year" value="'. $tt_year .'"></div>
                        <div class="col-md-2"><label class="col-form-label">Semester</label></div>
                        <div class="col-md-1 text-left">: '. $semester .'<input type="hidden" name="semester" id="semester" value="'. $semester .'"></div>
                        <br><br>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><label class="col-form-label">Staff Name</label></div>
                        <div class="col-md-4 text-left">: '. $dbcon->GetOneRecord("tbl_staffs", "staff_name", "id = ". $staff_id ." AND del_status", 0) .'<input type="hidden" name="staff_id" id="staff_id" value="'. $staff_id .'"></div>
                        <div class="col-md-2"><label class="col-form-label">Day Order</label></div>
                        <div class="col-md-1 text-left">: '. $day_order .'<input type="hidden" name="day_order" id="day_order" value="'. $day_order .'"></div>
                        <div class="col-md-2"><label class="col-form-label">Day Hour</label></div>
                        <div class="col-md-1 text-left">: '. $days_hour .'<input type="hidden" name="days_hour" id="days_hour" value="'. $days_hour .'"></div>
                        <br><br>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9">
                            <label class="col-form-label">Course Name <span class="err">*</span></label>
                            <select class="form-control select2" name="course_id" id="course_id" title="Select the Course">
                                <option value=""></option>'.
                                $dbcon->fnFillComboFromTable_Where("id", "concat(course_code, ' - ', course_name)", "exam_course", "course_name", " WHERE degree_id = ". $degree_id ." AND study_year = ". $tt_year ." AND semester = ". $semester ." AND del_status = 0") .'
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">Course Type <span class="err">*</span></label> 
                            <select class="form-control select2" name="course_type" id="course_type" title="Select the Course Type">
                                <option value=""></option>'.
                                $dbcon->fnFillComboFromTable_Where("id", "course_type", "exam_course_type", "course_type", " WHERE del_status = 0") .'
                            </select>
                        </div>          
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>';
    
    echo $html_output ."~". "<b>Timetable - Add Course</b>";
}

if($_REQUEST["mode"]=="save_tt")
{
    try {
        $created_by = $_SESSION["user_id"];
        $created_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO att_timetable (degree_id, tt_year, semester, staff_id, day_order, days_hour, course_id, course_type, created_by, created_dt) 
                        VALUES (:degree_id, :tt_year, :semester, :staff_id, :day_order, :days_hour, :course_id, :course_type, :created_by, :created_dt)");
        $data = array(
            ":degree_id" => trim($_REQUEST["degree_id"]),
            ":tt_year" => trim($_REQUEST["tt_year"]),
            ":semester" => trim($_REQUEST["semester"]),
            ":staff_id" => trim($_REQUEST["staff_id"]),
            ":day_order" => trim($_REQUEST["day_order"]),
            ":days_hour" => trim($_REQUEST["days_hour"]),
            ":course_id" => trim($_REQUEST["course_id"]),
            ":course_type" => trim($_REQUEST["course_type"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        //echo "<pre>"; print_r($data); die();
        $stmt->execute($data);
        $att_id = $con->lastInsertId();

        $tt_p = $dbcon->GetOneRecord("att_timetable", "concat(day_order, '-', days_hour)", "id = ". $att_id ." and del_status", 0);
        $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "id = ". $att_id ." and del_status", 0);
        $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id = ". $course_id ." and del_status", 0);

        $html_output ="";
        $html_output ='<a href="javascript:void(0);" class="delete pull-right" rel="'. $tt_p .'~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" data-popup="tooltip" title="Delete"><i class="fa fa-trash-o"></i></a>
        <a href="" data-toggle="modal" data-target="#modal_edit_tt" data-id="'. $tt_p .'~'. $_POST["degree_id"] ."~". $_POST["tt_year"] ."~". $_POST["semester"] ."~". $_POST["staff_id"] .'" title="Edit" class="fa fa-pencil pull-right" style="padding: 3px 4px;"></a>';

        $string = $tt_p ."^". $course_name ."^". $html_output;
        
        //$_SESSION["msg"] = "Saved Successfully";
        //echo 'delete^'. $day_order .'-'. $days_hour .'^'. $html_output;
        echo "status^1^". $string; exit;
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        //echo $_SESSION['msg_err'] = $str;
        echo "status^0^". $str; exit;
    }
}

if($_POST["mode"]=="modal_edit_tt")
{	
    $url_data = explode("~", $_POST["id"]);
    //print_r($url_data); die;
    $tt_period = explode("-", $url_data[0]);
    $degree_id = $url_data[1];
    $tt_year = $url_data[2];
    $semester = $url_data[3];
    $staff_id = $url_data[4];
    $day_order = $tt_period[0];
    $days_hour = $tt_period[1];

    $att_id = $dbcon->GetOneRecord("att_timetable", "id", "degree_id = ". $degree_id ." AND tt_year = ". $tt_year ." AND semester = ". $semester ." AND staff_id = ". $staff_id ." AND day_order = ". $day_order ." AND days_hour = ". $days_hour ." AND del_status", 0);

    $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "id = ". $att_id ." AND del_status", 0);
    $course_type = $dbcon->GetOneRecord("exam_course", "course_type", "id = ". $course_id ." AND del_status", 0);

    $html_output ="";
    $html_output ='<div class="row">
        <div class="col-lg-12">
        <div class="row txt-dets">
            <div class="col-md-12" style="line-height:2rem;">
                
                <div class="card-body" style="padding: 0px 15px;">
                    <div class="row">
                        <div class="col-md-2"><label class="col-form-label">Degree</label><input type="hidden" name="hid_att_id" id="hid_att_id" value="'. $att_id .'"></div>
                        <div class="col-md-4 text-left">: '. $dbcon->GetOneRecord("tbl_degree", "dname", "id = ". $degree_id ." AND del_status", 0) .'<input type="hidden" name="degree_id" id="degree_id" value="'. $degree_id .'"></div>
                        <div class="col-md-2"><label class="col-form-label">Year</label></div>
                        <div class="col-md-1 text-left">: '. $tt_year .'<input type="hidden" name="tt_year" id="tt_year" value="'. $tt_year .'"></div>
                        <div class="col-md-2"><label class="col-form-label">Semester</label></div>
                        <div class="col-md-1 text-left">: '. $semester .'<input type="hidden" name="semester" id="semester" value="'. $semester .'"></div>
                        <br><br>
                    </div>
                    <div class="row">
                        <div class="col-md-2"><label class="col-form-label">Staff Name</label></div>
                        <div class="col-md-4 text-left">: '. $dbcon->GetOneRecord("tbl_staffs", "staff_name", "id = ". $staff_id ." AND del_status", 0) .'<input type="hidden" name="staff_id" id="staff_id" value="'. $staff_id .'"></div>
                        <div class="col-md-2"><label class="col-form-label">Day Order</label></div>
                        <div class="col-md-1 text-left">: '. $day_order .'<input type="hidden" name="day_order" id="day_order" value="'. $day_order .'"></div>
                        <div class="col-md-2"><label class="col-form-label">Day Hour</label></div>
                        <div class="col-md-1 text-left">: '. $days_hour .'<input type="hidden" name="days_hour" id="days_hour" value="'. $days_hour .'"></div>
                        <br><br>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-9">
                            <label class="col-form-label">Course Name <span class="err">*</span></label>
                            <select class="form-control select2" name="course_id" id="course_id" title="Select the Course">
                                <option value=""></option>'.
                                $dbcon->fnFillComboFromTable_Where("id", "concat(course_code, ' - ', course_name)", "exam_course", "course_name", " WHERE degree_id = ". $degree_id ." AND study_year = ". $tt_year ." AND semester = ". $semester ." AND del_status = 0") .'
                            </select>
                            <script>document.thisFr.course_id.value='. $course_id .';</script>
                        </div>
                        <div class="col-md-3">
                            <label class="col-form-label">Course Type <span class="err">*</span></label> 
                            <select class="form-control select2" name="course_type" id="course_type" title="Select the Course Type">
                                <option value=""></option>'.
                                $dbcon->fnFillComboFromTable_Where("id", "course_type", "exam_course_type", "course_type", " WHERE del_status = 0") .'
                            </select>
                            <script>document.thisFr.course_type.value='. $course_type .';</script>
                        </div>          
                    </div>
                </div>

            </div>
        </div>
        </div>
    </div>';
    
    echo $html_output ."~". "<b>Timetable - Edit Course</b>";
}

if($_REQUEST["mode"]=="edit_tt")
{
    try {
        $updated_by = $_SESSION["user_id"];
        $updated_dt = date('Y-m-d H:i:s');

        $att_id = trim($_REQUEST["hid_att_id"]);

        $stmt = null;
        $stmt = $con->prepare("UPDATE att_timetable SET course_id = :course_id, course_type = :course_type, updated_by = :updated_by, updated_dt = :updated_dt WHERE id = :id");
        $data = array(
            ":id" => trim($_REQUEST["hid_att_id"]),
            ":course_id" => trim($_REQUEST["course_id"]),
            ":course_type" => trim($_REQUEST["course_type"]),
            ":updated_by" => $updated_by,
            ":updated_dt" => $updated_dt,
        );
        //echo "<pre>"; print_r($data); die();
        $stmt->execute($data);
        
        $tt_p = $dbcon->GetOneRecord("att_timetable", "concat(day_order, '-', days_hour)", "id = ". $att_id ." and del_status", 0);
        $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "id = ". $att_id ." and del_status", 0);
        $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id = ". $course_id ." and del_status", 0);

        $string = $tt_p . "~" . $course_name;
        
        //$_SESSION["msg"] = "Updated Successfully";
        echo "status^1^". $string; exit;
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        //echo $_SESSION['msg_err'] = $str;
        echo "status^0^". $str; exit;
    }
}

if($_POST["mode"]=="modal_del_tt")
{
    $url_data = explode("~", $_POST["id"]);
    //print_r($url_data); die;
    $tt_period = explode("-", $url_data[0]);
    $degree_id = $url_data[1];
    $tt_year = $url_data[2];
    $semester = $url_data[3];
    $staff_id = $url_data[4];
    $day_order = $tt_period[0];
    $days_hour = $tt_period[1];

    //$sql = "DELETE FROM att_timetable WHERE degree_id = ". $degree_id ." AND tt_year = ". $tt_year ." AND semester = ". $semester ." AND staff_id = ". $staff_id ." AND day_order = ". $day_order ." AND days_hour = ". $days_hour ." AND del_status = 0";
    $sql = "UPDATE att_timetable SET del_status = 1 WHERE degree_id = ". $degree_id ." AND tt_year = ". $tt_year ." AND semester = ". $semester ." AND staff_id = ". $staff_id ." AND day_order = ". $day_order ." AND days_hour = ". $days_hour;
    //echo $sql; die;
    $con->query($sql);

    $html_output ="";
    $html_output ='<a href="" data-toggle="modal" data-target="#modal_add_tt" data-id="'. $day_order .'-'. $days_hour .'~'. $degree_id .'~'. $tt_year .'~'. $semester .'~'. $staff_id .'" title="Add" class="fa fa-plus-circle pull-right" style="padding: 3px 4px;"></a>';

    echo 'delete^'. $day_order .'-'. $days_hour .'^'. $html_output;
}

if($_POST["mode"]=="att_date")
{
    $dayorder = $dbcon->GetOneRecord("exam_course", "course_type", "del_status", 0);
}
?>