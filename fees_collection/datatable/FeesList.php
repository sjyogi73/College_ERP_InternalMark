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
//$searchValue = $_POST['search']['value']; // Search value

## Custom Search Field
// $searchByValue = isset($_POST['searchByValue'])? $_POST['searchByValue'] : ''; //searchByValue
// $searchByDegree = isset($_POST['searchByDegree'])? $_POST['searchByDegree'] : ''; //searchByDegree
//echo $searchByValue;
//echo $searchByDegree;

## Search
//$searchQuery = " ";

// if($searchByValue != ''){
//   $searchQuery = " AND (regno LIKE '%". $searchByValue ."%' OR 
//        feemaster_name LIKE '%". $searchByValue ."%' OR
//        study_year LIKE '%". $searchByValue ."%' OR 
//        semester LIKE '%". $searchByValue ."%' OR 
//        mobile_no LIKE '%". $searchByValue ."%' ) ";
// }
if($columnName == '' || $columnName == 'id'){
  $columnName = " id ";
}

## Total number of records without filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM fc_feesmaster WHERE del_status = 0");
$records = $stmt->fetch();
$totalRecords = $records->allcount;

## Total number of records with filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM fc_feesmaster WHERE del_status = 0");
$records = $stmt->fetch();
$totalRecordwithFilter = $records->allcount;

## Fetch records
$data_sql = "SELECT * FROM fc_feesmaster where del_status = 0 ";
//echo $data_sql;
$stmt = $con->query($data_sql);
$records = $stmt->fetchAll();
$data = array();
$sno = 1;
foreach ($records as $row) {

  $action = $edit_link = $delete_link = "";

  //if(in_array('updatefeesmasters',$menu_permission)){
    $edit_link = '<a href="feesmaster.php?id='. $converter->encode($row->id) .'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;';
  //}
  //if(in_array('deletefeesmasters',$menu_permission)){
    $delete_link = '<a href="feesmaster.php?did='. $converter->encode($row->id) .'" title="Delete" onclick="return confirm(\'Are You Sure Want To Delete?\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
  //}

  $action = $edit_link . $delete_link;

  $data[] = array(
    "id"=>$sno,
    "fees_name"=>$row->fees_name,
    "amount"=>$row->amount,
    "action"=>$action
  );

  $sno++;
} 
//echo "<pre>";print_r($data);die();
## Response
$response = array(
  "draw" => intval($draw),
  "iTotalRecords" => $totalRecords,
  "iTotalDisplayRecords" => $totalRecordwithFilter,
  "aaData" => $data
);

echo json_encode($response);
?>