<?php
ob_start();
session_start();
define('BASEPATH', '../../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();
$converter = new Encryption;

ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

## Reading value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
//$searchValue = $_POST['search']['value']; // Search value

## Custom Search Field
//$searchByValue = isset($_POST['searchByValue'])? $_POST['searchByValue'] : ''; //searchByValue
$searchByDegree = isset($_POST['searchByDegree'])? $_POST['searchByDegree'] : ''; //searchByDegree
$searchByYear = isset($_POST['searchByYear'])? $_POST['searchByYear'] : ''; //searchByYear
$searchBySemester = isset($_POST['searchBySemester'])? $_POST['searchBySemester'] : ''; //searchBySemester
$searchByStaff = isset($_POST['searchByStaff'])? $_POST['searchByStaff'] : ''; //searchByStaff
//echo $searchByValue;
//echo $searchByDegree;

## Search
$searchQuery = " ";

// if($searchByValue != ''){
//   $searchQuery = " AND (regno LIKE '%". $searchByValue ."%' OR 
//        student_name LIKE '%". $searchByValue ."%' OR
//        study_year LIKE '%". $searchByValue ."%' OR 
//        semester LIKE '%". $searchByValue ."%' OR 
//        mobile_no LIKE '%". $searchByValue ."%' ) ";
// }

if($searchByDegree != ''){
  $searchQuery = " AND (degree_id = ". $searchByDegree .") ";
}

if($searchByYear != ''){
  $searchQuery = " AND (tt_year = ". $searchByYear .") ";
}

if($searchBySemester != ''){
  $searchQuery = " AND (semester = ". $searchBySemester .") ";
}

if($searchByStaff != ''){
  $searchQuery = " AND (staff_id = ". $searchByStaff .") ";
}

## Column
if($columnName == '' || $columnName == 'regno'){
  $columnName = " degree_id, tt_year, semester, day_order, days_hour ";
}

## Total number of records without filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM att_timetable WHERE del_status = 0".$searchQuery);
$records = $stmt->fetch();
$totalRecords = $records->allcount;

## Total number of records with filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM att_timetable WHERE del_status = 0 ".$searchQuery);
$records = $stmt->fetch();
$totalRecordwithFilter = $records->allcount;

## Fetch records
$data_sql = "SELECT * FROM att_timetable where del_status = 0 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ". $row .",". $rowperpage;
//echo $data_sql;
$stmt = $con->query($data_sql);
$records = $stmt->fetchAll();

$data = array();

$sno = 1;
foreach ($records as $row) {

  $action = $edit_link = $delete_link = "";

  $edit_link = '<a href="students.php?id='. $converter->encode($row->id) .'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;';
  $delete_link = '<a href="students.php?did='. $converter->encode($row->id) .'" title="Delete" onclick="return confirm(\'Are You Sure Want To Delete?\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
  
  $action = $edit_link . $delete_link;

  $degree = $dbcon->GetOneRecord("tbl_degree", "dname", "id = ". $row->degree_id ." AND del_status", 0) ."<br><small> <b>Year: </b>". $row->tt_year ."&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <b>Semester: </b>". $row->semester;
  $course = $dbcon->GetOneRecord("exam_course", "concat(course_code, ' - ', course_name)", "id = ". $row->course_id ." AND del_status", 0) ." (". $dbcon->GetOneRecord("exam_course_type", "course_type", "id = ". $row->course_type ." AND del_status", 0) .") <br><small><b>Handled by: </b>". $dbcon->GetOneRecord("tbl_staffs", "staff_name", "id = ". $row->staff_id ." AND del_status", 0);
  //$course = "XXX";

  $data[] = array(
    "id" => $sno,
    "day_order" => $row->day_order,
    "days_hour" => $row->days_hour,
    "degree_id" => $degree,
    "course_id" => $course,
    "action"=>$action
  );

  $sno++;
}

## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>