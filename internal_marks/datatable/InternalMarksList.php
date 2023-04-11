
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
$searchByYear = isset($_POST['searchByYear'])? $_POST['searchByYear'] : '';
$searchBySemester = isset($_POST['searchBySemester'])? $_POST['searchBySemester'] : '';

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

if($searchByYear != ''){
  $searchQuery = " AND (study_year = ". $searchByYear .") ";
}
if($searchBySemester != ''){
  $searchQuery = " AND (semester = ". $searchBySemester .") ";
}
if($searchByDegree != '' && $searchByStaff != '')
{ 
  $searchQuery = " AND (degree_id = ". $searchByDegree .")"." AND (staff_id = ". $searchByStaff .") ";
}
if($searchByDegree != '' && $searchByStaff != '' && $searchByYear != '')
{ 
  $searchQuery = " AND (degree_id = ". $searchByDegree .")"." AND (staff_id = ". $searchByStaff .") "." AND (study_year = ". $searchByYear .") ";
}
if($searchByDegree != '' && $searchByStaff != '' && $searchByYear != '' && $searchBySemester != '')
{ 
  $searchQuery = " AND (degree_id = ". $searchByDegree .")"." AND (staff_id = ". $searchByStaff .") "." AND (study_year = ". $searchByYear .") "." AND (semester = ". $searchBySemester .") ";
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

  //$actions = $entry_link ="";
  //if(in_array('updateStudents',$menu_permission)){
  $is_exist = $dbcon->GetOneRecord("tbl_internal_marks", "course_id", " course_id = '". $row->course_id ."' AND del_status", 0);
  // $pdf_url="print_pdf.php?d="+ 12 +"&y="+ 1 +"&s="+ 1 +"&st="+1;
  $entry_link = '<a href="internal_marks_entry.php?course_id='. base64_encode($row->course_id) .'&degree_id='. base64_encode($row->degree_id) .'&study_year='. base64_encode($row->study_year) .'&semester='. base64_encode($row->semester) .'"  title="Entry"><i class="fa fa-plus-circle"></i></a> &nbsp;&nbsp;';
  $report_link = '<a  href="internal_marks_lst.php?course_id='. base64_encode($row->course_id) .'&degree_id='. base64_encode($row->degree_id) .'&study_year='. base64_encode($row->study_year) .'&semester='. base64_encode($row->semester) .'"><i class="fa fa-file-pdf-o"></i></a> &nbsp;&nbsp;';
  $update_link = '<a href="internal_marks_entry.php?id='. base64_encode($row->course_id) .'&course_id='. base64_encode($row->course_id) .'&degree_id='. base64_encode($row->degree_id) .'&study_year='. base64_encode($row->study_year) .'&semester='. base64_encode($row->semester) .'" title="Update"><i class="fa fa-pencil"></i></a> &nbsp;&nbsp;';
  $delete_link = '<a href="internal_marks.php?did='. base64_encode($row->course_id) .'" title="Delete" onclick="return confirm(\'Are You Sure Want To Delete?\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';

  //}
  $actions =$is_exist != ""?$report_link . $update_link . $delete_link:$entry_link;
  

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

?>












