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
$searchByVendorsID = isset($_POST['searchByVendorsID'])? $_POST['searchByVendorsID'] : ''; //searchByVendorsID
//echo $searchByValue;
//echo $searchByVendorsID;

## Search
$searchQuery = " ";

if($searchByValue != ''){
  $searchQuery = " AND (vendor_id LIKE '%". $searchByValue ."%' OR 
       vendor_tit LIKE '%". $searchByValue ."%' OR
       vendor_name LIKE '%". $searchByValue ."%' OR 
       vendor_add LIKE '%". $searchByValue ."%' OR 
       vendor_ph_no LIKE '%". $searchByValue ."%' OR
       vendor_mb_no LIKE '%". $searchByValue ."%' OR 
       vendor_email_id LIKE '%". $searchByValue ."%' OR 
       vendor_note LIKE '%". $searchByValue ."%' ) ";
}

if($searchByVendorsID != ''){
  $searchQuery = " AND (vendor_id = ". $searchByVendorsID .") ";
}

## Column
if($columnName == '' || $columnName == 'vendor_id'){
  $columnName = " vendor_id ";
}

## Total number of records without filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM lib_vendor WHERE del_status = 0".$searchQuery);
$records = $stmt->fetch();
$totalRecords = $records->allcount;

## Total number of records with filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM lib_vendor WHERE del_status = 0 ".$searchQuery);
$records = $stmt->fetch();
$totalRecordwithFilter = $records->allcount;

## Fetch records
$data_sql = "SELECT * FROM lib_vendor where del_status = 0 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ". $row .",". $rowperpage;
//echo $data_sql;
$stmt = $con->query($data_sql);
$vendorRecords = $stmt->fetchAll();

$data = array();

$sno = 1;
foreach ($vendorRecords as $row) {

  $action = $edit_link = $delete_link = "";

  //if(in_array('updateVendors',$menu_permission))
  {
    $edit_link = '<a href="vendors.php?id='. $converter->encode($row->id) .'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;';
  }
  //if(in_array('deleteVendorss',$menu_permission))
 {
    $delete_link = '<a href="vendors.php?did='. $converter->encode($row->id) .'" title="Delete" onclick="return confirm(\'Are You Sure Want To Delete?\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
  }

  $action = $edit_link . $delete_link;

  $data[] = array(
    "id"=>$sno,
    "vendor_id"=>$row->vendor_id,
    "vendor_tit"=>$row->vendor_tit,	
    "vendor_name"=>$row->vendor_name,
    "vendor_add"=>$row->vendor_add,
	"vendor_ph_no"=>$row->vendor_ph_no,
    "vendor_mb_no"=>iif($row->vendor_mb_no=="", "-", $row->vendor_mb_no),
	"vendor_email_id"=>$row->vendor_email_id,
    "vendor_note"=>$row->vendor_note,
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