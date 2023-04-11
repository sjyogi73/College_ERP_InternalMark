<?php
ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

//ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

isAdmin();

// Include the main TCPDF library (search for installation path).
require_once(BASEPATH .'includes/common/tcpdf_include.php');

// create new PDF document
$pdf = new TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);

// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);

// set default monospaced font
$pdf->setDefaultMonospacedFont(PDF_FONT_MONOSPACED);

// set margins
//$pdf->setMargins(PDF_MARGIN_LEFT-15, PDF_MARGIN_TOP-29, PDF_MARGIN_RIGHT-16);
$pdf->setMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP-19, PDF_MARGIN_RIGHT);

// set auto page breaks
$pdf->setAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

// set image scale factor
$pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

// add a page
$pdf->AddPage();

// set font
$pdf->SetFont('helvetica', 'B', 20);
$pdf->Write(0, 'Sri Ramakrishna Mission Vidyalaya', '', 0, 'C', true, 0, false, false, 0);     //---Add Heading---
$pdf->Write(0, 'College of Arts and Science', '', 0, 'C', true, 0, false, false, 0);     //---Add Heading---
$pdf->SetFont('helvetica', 'B', 10);
$pdf->Write(0, 'Coimbatore - 641 020', '', 0, 'C', true, 0, false, false, 0);     //---Add Heading---

$pdf->writeHTML('<br><br>', true, false, true, false, '');

// $pdf->SetFont('helvetica', 'B', 14);
// $pdf->Write(0, 'TIME TABLE', '', 0, 'C', true, 0, false, false, 0);     //---Add Heading---
$pdf->writeHTMLCell(0, 0, '', '', '<h2><u>TIME TABLE</u></h2>', 0, 1, 0, true, 'C', true);  // Ref. www.rubydoc.info/gems/rfpdf/1.17.1/TCPDF:writeHTMLCell

$pdf->SetFont('helvetica', '', 10);

$degree_id = $_REQUEST["d"];
$degree_name = $dbcon->GetOneRecord("tbl_degree", "dname", "id = ". $degree_id ." AND del_status", 0);
$tt_year = $_REQUEST["y"];
$semester = $_REQUEST["s"];
$staff_id = $_REQUEST["st"];
//iif is not working here
if($staff_id == "All"){ $staff_name = "All"; }else{ $staff_name = $dbcon->GetOneRecord("tbl_staffs", "staff_name", "id=". $staff_id ." AND del_status", 0); }    
//echo $staff_name; die;

$tbl = '';
$tbl .= '
<br><br><br>
<table border="0" cellpadding="0" width="100%">
    <tr>
        <td width="50%" style="border-bottom: 0.2mm solid black;"><b>Degree: </b>'. $degree_name .'</td>
        <td width="10%" style="border-bottom: 0.2mm solid black;"><b>Year: </b>'. $tt_year .'</td>
        <td width="10%" style="border-bottom: 0.2mm solid black;"><b>Semester: </b>'. $semester .'</td>
        <td width="30%" align="right" style="border-bottom: 0.2mm solid black;"><b>Staff Name: </b>'. $staff_name .'</td>
    </tr>
</table>

<br><br>
<table border="0" cellpadding="4" cellspacing="0" style="border: 0.2mm solid black;" width="100%">
    <tr>
        <th height="40" width="5%" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>Day Order</b></th>
        <th width="15%" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>I <br>(09:30 : 10:30)</b></th>
        <th width="15%" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>II <br>(10:30 : 11:30)</b></th>
        <th width="15%" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>III <br>(11:45 : 01:00)</b></th>
        <th width="5%" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b> Break</b></th>
        <th width="15%" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>IV <br>(02:00 : 03:00)</b></th>
        <th width="15%" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>V <br>(03:00 : 04:00)</b></th>
        <th width="15%" align="center" style="border-bottom: 0.2mm solid black;"><b>VII <br>(04:00 : 05:00)</b></th>
    </tr>
    <!-- ------------------------------------------- Day Order - I ------------------------------------------------- -->
    <tr>
        <td height="40" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>I</b></td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 1 and days_hour = 1 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 1 and days_hour = 1 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 1 and days_hour = 2 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 1 and days_hour = 2 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 1 and days_hour = 3 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 1 and days_hour = 3 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td rowspan="6" align="center" style="border-right: 0.2mm solid black;"><h3><br> L <br><br> U <br><br> N <br><br> C <br><br> H </h3></td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 1 and days_hour = 4 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 1 and days_hour = 4 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 1 and days_hour = 5 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 1 and days_hour = 5 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 1 and days_hour = 6 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 1 and days_hour = 6 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
    </tr>
    <!-- ------------------------------------------- Day Order - II ------------------------------------------------- -->
    <tr>
        <td height="40" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>II</b></td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 2 and days_hour = 1 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 2 and days_hour = 1 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 2 and days_hour = 2 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 2 and days_hour = 2 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 2 and days_hour = 3 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 2 and days_hour = 3 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 2 and days_hour = 4 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 2 and days_hour = 4 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 2 and days_hour = 5 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 2 and days_hour = 5 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 2 and days_hour = 6 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 2 and days_hour = 6 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
    </tr>
    <!-- ------------------------------------------- Day Order - III ------------------------------------------------- -->
    <tr>
        <td height="40" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>III</b></td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 3 and days_hour = 1 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 3 and days_hour = 1 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 3 and days_hour = 2 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 3 and days_hour = 2 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 3 and days_hour = 3 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 3 and days_hour = 3 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 3 and days_hour = 4 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 3 and days_hour = 4 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 3 and days_hour = 5 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 3 and days_hour = 5 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 3 and days_hour = 6 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 3 and days_hour = 6 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
    </tr>
    <!-- ------------------------------------------- Day Order - IV ------------------------------------------------- -->
    <tr>
        <td height="40" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>IV</b></td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 4 and days_hour = 1 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 4 and days_hour = 1 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 4 and days_hour = 2 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 4 and days_hour = 2 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 4 and days_hour = 3 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 4 and days_hour = 3 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 4 and days_hour = 4 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 4 and days_hour = 4 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 4 and days_hour = 5 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 4 and days_hour = 5 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 4 and days_hour = 6 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 4 and days_hour = 6 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
    </tr>
    <!-- ------------------------------------------- Day Order - V ------------------------------------------------- -->
    <tr>
        <td height="40" align="center" style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;"><b>V</b></td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 5 and days_hour = 1 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 5 and days_hour = 1 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 5 and days_hour = 2 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 5 and days_hour = 2 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 5 and days_hour = 3 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 5 and days_hour = 3 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 5 and days_hour = 4 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 5 and days_hour = 4 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black; border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 5 and days_hour = 5 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 5 and days_hour = 5 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-bottom: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 5 and days_hour = 6 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 5 and days_hour = 6 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
    </tr>
    <!-- ------------------------------------------- Day Order - VI ------------------------------------------------- -->
    <tr>
        <td height="40" align="center" style="border-right: 0.2mm solid black;"><b>VI</b></td>
        <td style="border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 6 and days_hour = 1 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 6 and days_hour = 1 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 6 and days_hour = 2 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 6 and days_hour = 2 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 6 and days_hour = 3 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 6 and days_hour = 3 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 6 and days_hour = 4 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 6 and days_hour = 4 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td style="border-right: 0.2mm solid black;">';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 6 and days_hour = 5 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 6 and days_hour = 5 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
        <td>';
            if($staff_id == "All"){
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and day_order = 6 and days_hour = 6 and del_status", 0);
            }else{
                $course_id = $dbcon->GetOneRecord("att_timetable", "course_id", "degree_id = ". $degree_id ." and tt_year = ". $tt_year ." and semester = ". $semester ." and staff_id = ". $staff_id ." and day_order = 6 and days_hour = 6 and del_status", 0);
            }
            $course_name = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id", $course_id);
            $tbl .= iif($course_name == "", "-Nil-", $course_name) .'
        </td>
    </tr>
</table>';

$pdf->writeHTML($tbl, true, false, true, false, '');
//$pdf->writeHTMLCell(0, 0, '', '', $tbl, 0, 1, 0, true, '', true);

//$pdf->lastPage();
ob_end_clean();

//Close and output PDF document
$pdf->Output('timetable.pdf', 'I');

//============================================================+
// END OF FILE
//============================================================+
?>