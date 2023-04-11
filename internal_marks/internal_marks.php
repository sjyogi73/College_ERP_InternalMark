<?php 

ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

isAdmin();

$reg_no = $_POST["reg_no"];
$s_id = $_POST["s_id"];
$internal_mark = $_POST["internal_mark"];
$student_name = $_POST["student_name"];

//---------------------------------save/submit----------------------------------

if (isset($_REQUEST["submit"])) {  
    try{       
        $created_by = $_SESSION["user_id"];
        $created_dt = date('Y-m-d H:i:s');

        $i = 0;
       
        foreach ($reg_no as $key => $val) {   

            $is_exist = $dbcon->GetOneRecord("tbl_internal_marks", "s_id", " s_id = '". $s_id[$key] ."' AND del_status", 0);
            if ($is_exist != "") {
                $_SESSION['msg_err'] = "internal marks Entry already exist..!";
                header("location:internal_marks_lst.php");
                die();
            }
    
            $details['reg_no'] = $reg_no[$key];
            $details['s_id'] = $s_id[$key];
            $details['internal_mark'] = $internal_mark[$key];
            $details['student_name'] = $student_name[$key];
           
            $stmt = null;
            $stmt = $con->prepare("INSERT INTO tbl_internal_marks (course_id,s_id,internal_mark, reg_no, student_name, degree_id, study_year ,semester, created_by, created_dt) 
                            VALUE(:course_id,:s_id,:internal_mark, :reg_no, :student_name, :degree_id,:study_year,:semester, :created_by, :created_dt)");
            $data = array(
                ":course_id" => trim(base64_decode($_REQUEST['course_id'])),
                ":s_id" =>trim($details["s_id"]),
                ":internal_mark" => trim($details['internal_mark']),
                ":reg_no" => trim($details['reg_no']),
                ":student_name" =>trim($details['student_name']), 
                ":degree_id" => trim(base64_decode($_REQUEST['degree_id'])),
                ":study_year" => trim(base64_decode($_REQUEST['study_year'])),
                ":semester" => trim(base64_decode($_REQUEST['semester'])),          
                ":created_by" => $created_by,
                ":created_dt" => $created_dt,
            );
            //echo "<pre>"; print_r($data); die(); 
             $stmt->execute($data);           
           
        }
     
        $i++;

        $_SESSION["msg"] = "Saved Successfully";
      
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: internal_marks_lst.php");
    die();
}
//---------------------------------save/submit----------------------------------

//---------------------------------update----------------------------------
if (isset($_REQUEST["update"])) {   
      try{
        $id= $_POST["hid_id"];    
        $updated_by = 0;
        $updated_dt = date('Y-m-d H:i:s');      
       
          $i = 0;         
          foreach ($reg_no as $key => $val) {  
            
              $details['id'] = $id[$key];
              $details['reg_no'] = $reg_no[$key];
              $details['s_id'] = $s_id[$key];
              $details['internal_mark'] = $internal_mark[$key];
              $details['student_name'] = $student_name[$key];
             
              $stmt = null;           
              
              $stmt = $con->prepare("UPDATE tbl_internal_marks SET course_id=:course_id, s_id=:s_id, internal_mark=:internal_mark, reg_no=:reg_no, student_name=:student_name, degree_id=:degree_id, study_year=:study_year, semester=:semester, updated_by=:updated_by, updated_dt=:updated_dt where id=:id");
            
              
              $data = array(
                  ":id" => trim($details["id"]),
                  ":course_id" => trim(base64_decode($_REQUEST['course_id'])),
                  ":s_id" =>trim($details["s_id"]),
                  ":internal_mark" => trim($details['internal_mark']),
                  ":reg_no" => trim($details['reg_no']),
                  ":student_name" =>trim($details['student_name']), 
                  ":degree_id" => trim(base64_decode($_REQUEST['degree_id'])),
                  ":study_year" => trim(base64_decode($_REQUEST['study_year'])),
                  ":semester" => trim(base64_decode($_REQUEST['semester'])),          
                  ":updated_by" => $updated_by,
                  ":updated_dt" => $updated_dt,
              );
              //echo "<pre>"; print_r($data); die(); 
               $stmt->execute($data);    
     
             
          }
       
          $i++;
          $_SESSION["msg"] = "Updated Successfully";
      } catch (Exception $e) {
          $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
          echo $_SESSION['msg_err'] = $str;  
      }
      
      header("location: internal_marks_lst.php");
      die();
  }
//---------------------------------update----------------------------------


//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    try{
            $stmt = null;
            $stmt = $con->query("UPDATE tbl_internal_marks SET del_status=1 WHERE course_id=" . base64_decode($_REQUEST["did"]));
        
            $_SESSION["msg"] = "Deleted Successfully";
        
            header("location: internal_marks_lst.php");
            die();

      } catch (Exception $e) {
          $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
          echo $_SESSION['msg_err'] = $str;  
      }      

}
//---------------------------------delete----------------------------------------


?>