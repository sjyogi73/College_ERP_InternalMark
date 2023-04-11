<?php
ob_start();
session_start();

require_once("../includes/common/connection.php");
require_once("../includes/common/dbfunctions.php");
require_once("../includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

$menu_permission = explode('||', $_SESSION["menu_permission"]);

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
  $searchQuery = " AND (regno LIKE '%". $searchByValue ."%' OR 
       student_name LIKE '%". $searchByValue ."%' OR
       study_year LIKE '%". $searchByValue ."%' OR 
       semester LIKE '%". $searchByValue ."%' OR 
       mobile_no LIKE '%". $searchByValue ."%' ) ";
}

if($searchByDegree != ''){
  $searchQuery = " AND (degree = ". $searchByDegree .") ";
}

## Column
if($columnName == '' || $columnName == 'regno'){
  $columnName = " regno ";
}

## Total number of records without filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM tbl_students WHERE del_status = 0".$searchQuery);
$records = $stmt->fetch();
$totalRecords = $records->allcount;

## Total number of records with filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM tbl_students WHERE del_status = 0 ".$searchQuery);
$records = $stmt->fetch();
$totalRecordwithFilter = $records->allcount;

## Fetch records
$data_sql = "SELECT * FROM tbl_students where del_status = 0 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ". $row .",". $rowperpage;
//echo $data_sql;
$stmt = $con->query($data_sql);
$studentRecords = $stmt->fetchAll();

$data = array();

$sno = 1;
foreach ($studentRecords as $row) {

  $actions = $edit_link = $delete_link = "";

  if(in_array('updateStudents',$menu_permission)){
    $edit_link = '<a href="students.php?id='. base64_encode($row->id) .'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;';
  }
  if(in_array('deleteStudents',$menu_permission)){
    $delete_link = '<a href="students.php?did='. base64_encode($row->id) .'" title="Delete" onclick="return confirm(\'Are You Sure Want To Delete?\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
  }

  $actions = $edit_link . $delete_link;

  $data[] = array(
    "id"=>$sno,
    "regno"=>$row->regno,
    "student_name"=>$row->student_name,
    "degree"=>$dbcon->GetOneRecord("tbl_degree", "dname", "id", $row->degree),
    "study_year"=>$row->study_year,
    "semester"=>$row->semester,
    "mobile_no"=>iif($row->mobile_no=="", "-", $row->mobile_no),
    "actions"=>$actions
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