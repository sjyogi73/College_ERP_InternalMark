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
$searchByAuthor = isset($_POST['searchByAuthor'])? $_POST['searchByAuthor'] : ''; //searchByAuthor
$searchByBookNo = isset($_POST['searchByBook No'])? $_POST['searchByBook No'] : ''; //searchByBook No
//echo $searchByValue; echo $searchByAuthor; echo $searchByBook No;

## Search
$searchQuery = " ";

if($searchByValue != ''){
  $searchQuery = " AND (bk_acc_no LIKE '%". $searchByValue ."%' OR 
        bk_title LIKE '%". $searchByValue ."%' OR
        bk_author1 LIKE '%". $searchByValue ."%' OR 
        bk_no LIKE '%". $searchByValue ."%' OR
		 bk_location LIKE '%". $searchByValue ."%' OR ";
}

if($searchByAuthor != ''){
  $searchQuery = " AND (bk_author1 = ". $searchByAuthor .") ";
}
}

## Column
if($columnName == '' || $columnName == 'bk_acc_no'){
  $columnName = " bk_acc_no ";
}

## Total number of records without filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM lib_books WHERE del_status = 0".$searchQuery);
$records = $stmt->fetch();
$totalRecords = $records->allcount;

## Total number of records with filtering
$stmt = $con->query("SELECT COUNT(*) AS allcount FROM lib_books WHERE del_status = 0 ".$searchQuery);
$records = $stmt->fetch();
$totalRecordwithFilter = $records->allcount;

## Fetch records
$data_sql = "SELECT * FROM lib_books where del_status = 0 ".$searchQuery." ORDER BY ".$columnName." ".$columnSortOrder." LIMIT ". $row .",". $rowperpage;
//echo $data_sql;
$stmt = $con->query($data_sql);
$staffRecords = $stmt->fetchAll();

$data = array();

$sno = 1;
foreach ($staffRecords as $row) {

  $action = $edit_link = $delete_link = "";

  //if(in_array('updateStudents',$menu_permission)){
    $edit_link = '<a href="Books.php?id='. $converter->encode($row->id) .'" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a> &nbsp;&nbsp;';
  }
  //if(in_array('deleteStudents',$menu_permission)){
    $delete_link = '<a href="Books.php?did='. $converter->encode($row->id) .'" title="Delete" onclick="return confirm(\'Are You Sure Want To Delete?\');"><i class="fa fa-trash-o" aria-hidden="true"></i></a>';
  }

  $action = $edit_link . $delete_link;

  $data[] = array(
    "id"=>$sno,
    "bk_acc_no"=>$row->bk_acc_no,
    "bk_title"=>$row->bk_title,
    "bk_author1"=>$row->bk_author1,
    "bk_no"=>$row->bk_no,
    "bk_location"=>$row->bk_location,
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