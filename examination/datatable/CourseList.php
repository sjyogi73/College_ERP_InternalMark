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

// ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

//$menu_permission = explode('||', $_SESSION["menu_permission"]);

## Reading value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc
//$searchValue = $_POST['search']['value']; // Search value

## Custom Search Field
$searchByValue = isset($_POST['searchByValue'])? $_POST['searchByValue'] : ''; //searchByValue
$searchByDegree = isset($_POST['searchByDegree'])? $_POST['searchByDegree'] : ''; //searchByDegree
//echo $searchByValue;
//echo $searchByDegree;

## Search
$searchQuery = " ";

if($searchByValue != ''){
  $searchQuery = " AND (course_code LIKE '%". $searchByValue ."%' OR 
        course_name LIKE '%". $searchByValue ."%' OR
        study_year LIKE '%". $searchByValue ."%' OR 
        semester LIKE '%". $searchByValue ."%') ";
}

if($searchByDegree != ''){
  $searchQuery = " AND (degree_id = ". $searchByDegree .") ";
}

## Column
if($columnName == '' || $columnName == 'course_code'){
  $columnName = " course_code ";
}

## Total number of records without filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM exam_course WHERE del_status = 0".$searchQuery);
$records = $stmt->fetch();
$totalRecords = $records->allcount;

## Total number of records with filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM exam_course WHERE del_status = 0 ".$searchQuery);
$records = $stmt->fetch();
$totalRecordwithFilter = $records->allcount;

## Fetch records
$data_sql = "SELECT * FROM exam_course where del_status = 0 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ". $row .",". $rowperpage;
//echo $data_sql;
$stmt = $con->query($data_sql);
$courseRecords = $stmt->fetchAll();

$data = array();

$sno = 1;
foreach ($courseRecords as $row) {

  $action = $edit_link = $delete_link = "";

  //if(in_array('updateStudents',$menu_permission)){
    $edit_link = '<a href="course.php?id='. $converter->encode($row->id) .'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;';
  //}
  //if(in_array('deleteStudents',$menu_permission)){
    $delete_link = '<a href="course.php?did='. $converter->encode($row->id) .'" title="Delete" onclick="return confirm(\'Are You Sure Want To Delete?\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
  //}

  $action = $edit_link . $delete_link;

  $cpart = "";
  switch ($row->course_part) {
    case 1:
      $cpart = "I";
      break;
    case 2:
      $cpart = "II";
      break;
    case 3:
      $cpart = "III";
      break;
    case 4:
      $cpart = "IV";
      break;
    case 5:
      $cpart = "V";
      break;
    case 6:
      $cpart = "VI";
      break;
  }

  $data[] = array(
    "id" => $sno,
    "course_code" => $row->course_code,
    "course_name" => $row->course_name,
    "course_part" => $cpart,
    "degree_id" => $dbcon->GetOneRecord("tbl_degree", "dname", "id", $row->degree_id),
    "study_year"=>$row->study_year,
    "semester"=>$row->semester,
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