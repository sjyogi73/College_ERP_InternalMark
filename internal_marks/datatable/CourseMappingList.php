<?php
ob_start();
session_start();
define('BASEPATH', '../../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

//$menu_permission = explode('||', $_SESSION["menu_permission"]);

## Reading value
$draw = $_POST['draw'];
$row = $_POST['start'];
$rowperpage = $_POST['length']; // Rows display per page
$columnIndex = $_POST['order'][0]['column']; // Column index
$columnName = $_POST['columns'][$columnIndex]['data']; // Column name
$columnSortOrder = $_POST['order'][0]['dir']; // asc or desc

## Custom Search Field
$searchByValue = isset($_POST['searchByValue'])? $_POST['searchByValue'] : ''; //searchByValue

$searchByStaff = isset($_POST['searchByStaff'])? $_POST['searchByStaff'] : '';
$searchByDegree = isset($_POST['searchByDegree'])? $_POST['searchByDegree'] : '';



# Search
$searchQuery = " ";

if($searchByValue != ''){
  $searchQuery = " AND (course_code LIKE '%". $searchByValue ."%' OR
        staff_name LIKE '%". $searchByValue ."%' OR         
        course_name LIKE '%". $searchByValue ."%' OR
        study_year LIKE '%". $searchByValue ."%' OR 
        semester LIKE '%". $searchByValue ."%') ";
}

if($searchByDegree != ''){
  $searchQuery = " AND (degree_id = ". $searchByDegree .") ";
}

if($searchByStaff != ''){
  $searchQuery = " AND (staff_id = ". $searchByStaff .") ";
}

if($searchByDegree != '' && $searchByStaff != '')
{ 
  $searchQuery = " AND (degree_id = ". $searchByDegree .")"." AND (staff_id = ". $searchByStaff .") ";
}


## Column
if($columnName == '' || $columnName == 'staff_id'){
  $columnName = " staff_id ";
}

## Total number of records without filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM internal_course_mapping WHERE del_status = 0".$searchQuery);
$records = $stmt->fetch();
$totalRecords = $records->allcount;

## Total number of records with filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM internal_course_mapping WHERE del_status = 0 ".$searchQuery);
$records = $stmt->fetch();
$totalRecordwithFilter = $records->allcount;

## Fetch records
$data_sql = "SELECT * FROM internal_course_mapping where del_status = 0 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ". $row .",". $rowperpage;
$stmt = $con->query($data_sql);
$courseMappingRecords = $stmt->fetchAll();

$data = array();

$sno = 1;
foreach ($courseMappingRecords as $row) {


  $actions = $edit_link = $delete_link = "";

  //if(in_array('updateStudents',$menu_permission)){
    $edit_link = '<a href="course_mapping.php?id='. base64_encode($row->id) .'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;';
  //}
  //if(in_array('deleteStudents',$menu_permission)){
    $delete_link = '<a href="course_mapping.php?did='. base64_encode($row->id) .'" title="Delete" onclick="return confirm(\'Are You Sure Want To Delete?\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
  //}

  $actions = $edit_link . $delete_link;

  $data[] = array(
    "id" => $sno,    
    "course_name" => $row->course_name." - (".($row->course_code).")",
    "staff_name" => $row->staff_name,
    "degree_id" => $dbcon->GetOneRecord("tbl_degree", "dname", "id", $row->degree_id),
    "study_year"=>$row->study_year,
    "semester"=>$row->semester,
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