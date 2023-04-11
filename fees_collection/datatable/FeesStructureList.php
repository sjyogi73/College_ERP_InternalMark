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
$searchByValue = isset($_POST['searchByValue'])? $_POST['searchByValue'] : ''; //searchByValue
$searchByDegree = isset($_POST['searchByDegree'])? $_POST['searchByDegree'] : ''; //searchByDegree
//echo $searchByValue;
//echo $searchByDegree;

## Search
//$searchQuery = " ";

if($searchByValue != ''){
  $searchQuery = " AND (fees_year LIKE '%". $searchByValue ."%' OR 
       semester LIKE '%". $searchByValue ."%' OR 
       total_amount LIKE '%". $searchByValue ."%' ) ";
}

if($searchByDegree != ''){
    $searchQuery = " AND (degree_id = ". $searchByDegree .") ";
}

## Column
if($columnName == '' || $columnName == 'id'){
  $columnName = " id ";
}

## Total number of records without filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM fc_feesstructure WHERE del_status = 0".$searchQuery);
$records = $stmt->fetch();
$totalRecords = $records->allcount;

## Total number of records with filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM fc_feesstructure WHERE del_status = 0".$searchQuery);
$records = $stmt->fetch();
$totalRecordwithFilter = $records->allcount;

## Fetch records
$data_sql = "SELECT * FROM fc_feesstructure where del_status = 0 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ". $row .",". $rowperpage;
//echo $data_sql;
$stmt = $con->query($data_sql);
$records = $stmt->fetchAll();
$data = array();
$sno = 1;
foreach ($records as $row) {

  $action = $edit_link = $delete_link = "";

  //if(in_array('updatefeesmasters',$menu_permission)){
    $edit_link = '<a href="fees_structure.php?id='. $converter->encode($row->id) .'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;';
  //}
  //if(in_array('deletefeesmasters',$menu_permission)){
    $delete_link = '<a href="fees_structure.php?did='. $converter->encode($row->id) .'" title="Delete" onclick="return confirm(\'Are You Sure Want To Delete?\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
  //}

  $fs_show = ' <a href="" data-toggle="modal" data-target="#modal_fs_show" data-id="'. $row->id .'" title="Fees Structure Details"><i class="fa fa-eye" aria-hidden="true"></i></a>';

  $action = $edit_link . $delete_link;

  $data[] = array(
    "id"=>$sno,
    "degree_id"=>$dbcon->GetOneRecord("tbl_degree", "dname", " id = '". $row->degree_id ."' AND del_status", 0) . $fs_show,
    "fees_year"=>$row->fees_year,
    "semester"=>$row->semester,
    "total_amount"=>$row->total_amount,
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