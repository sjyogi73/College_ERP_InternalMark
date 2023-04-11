<?php
ob_start();
session_start();

define('BASEPATH', '../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();
$converter = new Encryption;

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

isAdmin();
$menu_permission = explode('||', $_SESSION["menu_permission"]);

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
    try{
        $is_exist = $dbcon->GetOneRecord("lib_vendor", "vendor_id", " vendor_id = '". $_REQUEST["vendor_id"] ."' AND del_status", 0);
		if ($is_exist != "") {
			$_SESSION['msg_err'] = "Vendor already exist..!";
			header("location:vendors_lst.php");
			die();
		}
        
        $created_by = 1;
        $created_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO lib_vendor (vendor_id,vendor_tit, vendor_name, vendor_add, vendor_ph_no, vendor_mb_no, vendor_email_id,vendor_note, created_by, created_dt) 
                        VALUE(:vendor_id,:vendor_tit, :vendor_name, :vendor_add, :vendor_ph_no, :vendor_mb_no, :vendor_email_id,:vendor_note, :created_by, :created_dt)");
        $data = array(
			":vendor_id" => trim($_REQUEST["vendor_id"]),	
            ":vendor_tit" => trim(strtoupper($_REQUEST["vendor_tit"])),
            ":vendor_name" => trim(ucwords($_REQUEST["vendor_name"])),
            ":vendor_add" => trim($_REQUEST["vendor_add"]),
            ":vendor_ph_no" => trim($_REQUEST["vendor_ph_no"]),
            ":vendor_mb_no" => trim($_REQUEST["vendor_mb_no"]),			
            ":vendor_email_id" => trim($_REQUEST["vendor_email_id"]),
            ":vendor_note" => trim($_REQUEST["vendor_note"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        $stmt->execute($data);

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: vendors_lst.php");
    die();
}
//---------------------------------save/submit----------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) {
   
   try{
        //echo "Update"; die();
       $updated_by = $_SESSION["user_id"]; 0;
        $updated_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("UPDATE lib_vendor SET vendor_id=:vendor_id, vendor_name=:vendor_name, vendor_add=:vendor_add, vendor_ph_no=:vendor_ph_no, vendor_mb_no=:vendor_mb_no, vendor_email_id=:vendor_email_id ,vendor_note=:vendor_note, updated_by=:updated_by, updated_dt=:updated_dt where id=:id");
        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
			":vendor_id" => trim($_REQUEST["vendor_id"]),	
            ":vendor_tit" => trim(strtoupper($_REQUEST["vendor_tit"])),
            ":vendor_name" => trim(ucwords($_REQUEST["vendor_name"])),
            ":vendor_add" => trim($_REQUEST["vendor_add"]),
            ":vendor_ph_no" => trim($_REQUEST["vendor_ph_no"]),
            ":vendor_mb_no" => trim($_REQUEST["vendor_mb_no"]),			
            ":vendor_email_id" => trim($_REQUEST["vendor_email_id"]),
            ":vendor_note" => trim($_REQUEST["vendor_note"]),
            ":updated_by" => $updated_by,
            ":updated_dt" => $updated_dt
        );
        //print_r($data); die();
        $stmt->execute($data);

        $_SESSION["msg"] = "Updated Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }

    header("location:vendors_lst.php");
    die();
	
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE lib_vendor SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:vendors_lst.php");
    die();
}
//---------------------------------delete----------------------------------------

//---------------------------------edit----------------------------------------
if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM lib_vendor where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
            $vendor_id = $obj->vendor_id;
			$vendor_tit = $obj->vendor_tit;
            $vendor_name = $obj->vendor_name;
            $vendor_add = $obj->vendor_add;
            $vendor_ph_no = $obj->vendor_ph_no;
            $vendor_mb_no = $obj->vendor_mb_no;
            $vendor_email_id = $obj->vendor_email_id;
            $vendor_note = $obj->vendor_note;			
        }
    }
}
?>
<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Vendors
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Vendors</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php if(isset($_REQUEST["id"])){
                    echo '<h3 class="box-title">Edit</h3>';
                }else{
                    echo '<h3 class="box-title">Add</h3>';
                } ?>
                <?php 
                if(in_array('viewVendors',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="vendors_lst.php" class="btn btn-block btn-primary"><i class="fa fa-bars" aria-hidden="true"></i></a>
                </div>
                <?php
                }
                ?>
            </div>
            <br />
            <form id="thisForm" name="thisForm" class="form-horizontal" action="vendors.php" method="post">
                <div class="box-body">
                    <div class="col-md-10 col-md-offset-1">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <!-- <label class="col-sm-4 control-label">Register No. *</label> -->
                                    <label class="col-sm-4 col-form-label">Vendors ID <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="vendor_id" id="vendor_id" placeholder="Enter the Vendors ID" title="Enter The Vendors ID" autocomplete="off" autofocus="autofocus" required oninvalid="this.setCustomValidity('Please enter the Vendors Id...!')" oninput="this.setCustomValidity('')" maxlength="8" value="<?php echo $vendor_id; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Vendors Title <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="vendor_tit" id="vendor_tit" placeholder="Enter the Vendors Title" title="Enter The Vendors Title" autocomplete="off" onKeyPress="return isNameKey(event);" required oninvalid="this.setCustomValidity('Please enter the Vendors Title...!')" oninput="this.setCustomValidity('')" maxlength="250" value="<?php echo $vendor_tit; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Vendors Name </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="vendor_name" id="vendor_name" placeholder="Enter the Vendors Name" title="Enter The Vendors Name" autocomplete="off" onKeyPress="return isNameKey(event);" oninput="this.setCustomValidity('')" maxlength="50" value="<?php echo $vendor_name; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <div >
										<label class="col-sm-4 col-form-label">Address <span class="err">*</span></label> 
										<div class="col-sm-8">										
                                            <textarea class="form-control" name="vendor_add" id="vendor_add" rows="4" required oninvalid="this.setCustomValidity('Please enter the address...!')" oninput="this.setCustomValidity('')"><?php echo $vendor_add; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="col-md-6">
                                
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Mobile No</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="vendor_mb_no" id="vendor_mb_no" maxlength="10" placeholder="Enter the Mobile No" onKeyPress="return isNumberKey(event);"  value="<?php echo $vendor_mb_no; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Phone No</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="vendor_ph_no" id="vendor_ph_no" maxlength="10" placeholder="Enter the Phone No" onKeyPress="return isNumberKey(event);"  value="<?php echo $vendor_ph_no; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Email ID</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="vendor_email_id" id="vendor_email_id" maxlength="50" placeholder="Enter the Email ID"  value="<?php echo $vendor_email_id; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <div >
										<label class="col-sm-4 col-form-label">Notes </label> 
										<div class="col-sm-8">									
                                            <textarea class="form-control" name="vendor_note" id="vendor_note" rows="4" oninput="this.setCustomValidity('')"><?php echo $vendor_note; ?></textarea>
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div class="box-footer text-right">
                    <?php if (isset($_REQUEST["id"])) { ?>
                    <input type="hidden" value="<?php echo $id; ?>" name="hid_id">
                    <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Update</button>
                    <?php } else { ?>
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                    <?php } ?>
                </div>
            </form>
        </div>
    </section>
</div>
<?php include("includes/footer.php"); ?>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterVendorSubNav').addClass('active');
});
</script>