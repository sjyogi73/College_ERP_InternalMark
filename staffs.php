<?php
ob_start();
session_start();

require_once("includes/common/connection.php");
require_once("includes/common/dbfunctions.php");
require_once("includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();
$converter = new Encryption;

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

isAdmin();
$menu_permission = explode('||', $_SESSION["menu_permission"]);

$img_name = "image_holder.jpg";
$img_path = "resources/staffImages/image_holder.jpg";

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
    try{
        $is_exist = $dbcon->GetOneRecord("tbl_staffs", "staff_id", " staff_id = '". $_REQUEST["staff_id"] ."' AND del_status", 0);
		if ($is_exist != "") {
			$_SESSION['msg_err'] = "Staff already exist..!";
			header("location:staffs_lst.php");
			die();
		}
        
        $created_by = 1;
        $created_dt = date('Y-m-d H:i:s');

        if ($_FILES['image_file']['name'] != "") {
            $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $customfilename = 'Staff-' . trim($_REQUEST["staff_id"]) . '.' . $ext;
            $_REQUEST['image_file'] = post_img($customfilename, $_FILES['image_file']['tmp_name'], "resources/staffImages/");
        }

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO tbl_staffs (staff_id, staff_name, staff_type, gender, staff_dob, qualification, mobile_no, email_id, designation, staff_username, staff_password, image_file, staff_address, created_by, created_dt) 
                        VALUES (:staff_id, :staff_name, :staff_type, :gender, :staff_dob, :qualification, :mobile_no, :email_id, :designation, :staff_username, :staff_password, :image_file, :staff_address, :created_by, :created_dt)");
        $data = array(
            ":staff_id" => trim($_REQUEST["staff_id"]),
            ":staff_name" => trim(ucwords($_REQUEST["staff_name"])),
            ":staff_type" => trim($_REQUEST["staff_type"]),
            ":gender" => trim($_REQUEST["gender"]),
            ":staff_dob" => trim($_REQUEST["staff_dob"]),
            ":qualification" => trim($_REQUEST["qualification"]),
            ":mobile_no" => trim($_REQUEST["mobile_no"]),
            ":email_id" => trim($_REQUEST["email_id"]), 
            ":designation" => trim($_REQUEST["designation"]), 
            ":staff_username" => trim($_REQUEST["staff_username"]), 
            ":staff_password" => trim($_REQUEST["staff_password"]), 
            ":image_file" => trim($_REQUEST["image_file"]), 
            ":staff_address" => trim($_REQUEST["staff_address"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        $stmt->execute($data);
        
        if($_REQUEST["staff_username"] != "" && $_REQUEST["staff_password"] != ""){
            $stmt = null;
            $stmt = $con->prepare("INSERT INTO tbl_users (uname, mobile_no, email, status, username, password, hint_password, created_by, created_dt) 
                            VALUES (:uname, :mobile_no, :email, :status, :username, :password, :hint_password, :created_by, :created_dt)");
            $data = array(
                ":uname" => trim(ucwords($_REQUEST["staff_name"])),
                ":mobile_no" => trim($_REQUEST["mobile_no"]),
                ":email" => trim($_REQUEST["email_id"]),
                ":status" => 1,
                ":username" => trim($_REQUEST["staff_username"]),
                ":password" => md5(sha1($_REQUEST["staff_password"])),
                ":hint_password" => trim($_REQUEST["staff_password"]),
                ":created_by" => $created_by,
                ":created_dt" => $created_dt,
            );
            //print_r($data); die();
            $stmt->execute($data);
        }

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: staffs_lst.php");
    die();
}
//---------------------------------save/submit----------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) {
    try{
        //echo "Update"; die();
       $updated_by = $_SESSION["user_id"]; 0;
        $updated_dt = date('Y-m-d H:i:s');

        if ($_FILES['image_file']['name'] != "") {
            if ($_REQUEST["hide_image_file"] != "") {
                removeFile("resources/staffImages/" . $_REQUEST["hide_image_file"]);
            }
            $ext = pathinfo($_FILES['image_file']['name'], PATHINFO_EXTENSION);
            $customfilename = 'Staff-' . trim($_REQUEST["staff_id"]) . '.' . $ext;
            $_REQUEST['image_file'] = post_img($customfilename, $_FILES['image_file']['tmp_name'], "resources/staffImages/");
        } else {
            $_REQUEST['image_file'] = $_REQUEST["hide_image_file"];
        }

        $stmt = null;
        $stmt = $con->prepare("UPDATE tbl_staffs SET staff_id=:staff_id, staff_name=:staff_name, staff_type=:staff_type, gender=:gender, staff_dob=:staff_dob, qualification=:qualification, mobile_no=:mobile_no, email_id=:email_id, designation=:designation, staff_username=:staff_username, staff_password=:staff_password, image_file=:image_file, staff_address=:staff_address, updated_by=:updated_by, updated_dt=:updated_dt where id=:id");
        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
            ":staff_id" => trim($_REQUEST["staff_id"]),
            ":staff_name" => trim(ucwords($_REQUEST["staff_name"])),
            ":staff_type" => trim($_REQUEST["staff_type"]),
            ":gender" => trim($_REQUEST["gender"]),
            ":staff_dob" => trim($_REQUEST["staff_dob"]),
            ":qualification" => trim($_REQUEST["qualification"]),
            ":mobile_no" => trim($_REQUEST["mobile_no"]),
            ":email_id" => trim($_REQUEST["email_id"]), 
            ":designation" => trim($_REQUEST["designation"]), 
            ":staff_username" => trim($_REQUEST["staff_username"]), 
            ":staff_password" => trim($_REQUEST["staff_password"]), 
            ":image_file" => trim($_REQUEST["image_file"]), 
            ":staff_address" => trim($_REQUEST["staff_address"]),
            ":updated_by" => $updated_by,
            ":updated_dt" => $updated_dt
        );
        //print_r($data); die();
        $stmt->execute($data);

        if($_REQUEST["staff_username"] != "" && $_REQUEST["staff_password"] != ""){
            $stmt = null;
            $stmt = $con->prepare("UPDATE tbl_users SET uname=:uname,email=:email, status=:status, username=:username, password=:password, hint_password=:hint_password, updated_by=:updated_by, updated_dt=:updated_dt where mobile_no=:mobile_no");
            $data = array(
                ":uname" => trim(ucwords($_REQUEST["staff_name"])),
                ":mobile_no" => trim($_REQUEST["mobile_no"]),
                ":email" => trim($_REQUEST["email_id"]),
                ":status" => 1,
                ":username" => trim($_REQUEST["staff_username"]),
                ":password" => md5(sha1($_REQUEST["staff_password"])),
                ":hint_password" => trim($_REQUEST["staff_password"]),
                ":updated_by" => $updated_by,
                ":updated_dt" => $updated_dt
            );
            //print_r($data); die();
            $stmt->execute($data);
        }

        $_SESSION["msg"] = "Updated Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }

    header("location:staffs_lst.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE tbl_staffs SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:staffs_lst.php");
    die();
}
//---------------------------------delete----------------------------------------

if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM tbl_staffs where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
            $staff_id = $obj->staff_id;
            $staff_name = $obj->staff_name;
            $staff_type = $obj->staff_type;
            $gender = $obj->gender;
            $staff_dob = $obj->staff_dob;
            $qualification = $obj->qualification;
            $mobile_no = $obj->mobile_no;
            $email_id = $obj->email_id;
            $designation = $obj->designation;
            $staff_username = $obj->staff_username;
            $staff_password = $obj->staff_password;
            
            $image_file = $obj->image_file;
            if ($image_file != '') {
                $img_name = $image_file;
                $img_path = "resources/staffImages/". $image_file;
            }

            $staff_address = $obj->staff_address;
        }
    }
}
?>

<link href="assets/dist/css/bootstrap-imageupload.css" rel="stylesheet">

<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Staffs
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Staffs</li>
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
                if(in_array('viewStudents',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="staffs_lst.php" class="btn btn-block btn-primary"><i class="fa fa-bars" aria-hidden="true"></i></a>
                </div>
                <?php
                }
                ?>
            </div>
            <br />
            <form id="thisForm" name="thisForm" class="form-horizontal" action="staffs.php" method="post" enctype="multipart/form-data">
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Staff Id. (In CAPS) <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="staff_id" id="staff_id" placeholder="Enter the Staff Id." title="Enter The Staff Id." autocomplete="off" autofocus="autofocus" onKeyPress="return isCapitalNumericNoSpace(event);" required oninvalid="this.setCustomValidity('Please enter the staff id....!')" oninput="this.setCustomValidity('')" maxlength="8" value="<?php echo $staff_id; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Staff Name <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="staff_name" id="staff_name" placeholder="Enter the Staff Name" title="Enter The Staff Name" autocomplete="off" onKeyPress="return isNameKey(event);" required oninvalid="this.setCustomValidity('Please enter the staff name...!')" oninput="this.setCustomValidity('')" maxlength="50" value="<?php echo $staff_name; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Staff Type <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="staff_type" id="staff_type" title="Select the Staff Type" required oninvalid="this.setCustomValidity('Please select the staff type...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <option value="1">Teaching Staff</option>
                                            <option value="2">Non-Teaching Staff</option>
                                        </select>
                                        <script>document.thisForm.staff_type.value = "<?php echo $staff_type; ?>"</script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Gender <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="gender" id="gender" title="Select the Gender" required oninvalid="this.setCustomValidity('Please select the gender...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <option value="1">Male</option>
                                            <option value="2">Female</option>
                                        </select>
                                        <script>document.thisForm.gender.value = "<?php echo $gender; ?>"</script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">DOB <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="staff_dob" id="staff_dob" title="Select The DOB" autocomplete="off" required oninvalid="this.setCustomValidity('Please select the dob...!')" oninput="this.setCustomValidity('')" value="<?php echo $staff_dob; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Qualification <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="qualification" id="qualification" placeholder="Enter the Qualification" title="Enter The Qualification" autocomplete="off" required oninvalid="this.setCustomValidity('Please enter the qualification...!')" oninput="this.setCustomValidity('')" maxlength="50" value="<?php echo $qualification; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Mobile No. <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" name="mobile_no" id="mobile_no" maxlength="10" placeholder="Enter the Mobile No" title="Enter The Mobile No" autocomplete="off" onKeyPress="return isNumberKey(event);" required oninvalid="this.setCustomValidity('Please enter the mobile no...!')" oninput="this.setCustomValidity('')" value="<?php echo $mobile_no; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Email Id</label>
                                    <div class="col-sm-8">
                                    <input type="text" class="form-control" name="email_id" id="email_id" placeholder="Enter the Email Id" title="Enter The Email Id" autocomplete="off" onKeyPress="return isEmailKey(event);" value="<?php echo $email_id; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Designation <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="designation" id="designation" title="Select the Designation" required oninvalid="this.setCustomValidity('Please select the designation...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <?php
                                                echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_designation", "dname", " WHERE del_status = 0");
                                            ?>
                                        </select>
                                        <script>document.thisForm.designation.value = "<?php echo $designation; ?>"</script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Username</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="staff_username" id="staff_username" placeholder="Enter the Username" title="Enter The Username" autocomplete="off" onKeyPress="return isNameKey(event);" value="<?php echo $staff_username; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Password</label>
                                    <div class="col-sm-8">
                                        <input type="password" class="form-control" name="staff_password" id="staff_password" placeholder="Enter the Password" title="Enter The Password" autocomplete="off" value="<?php echo $staff_password; ?>">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="row">
                                    <div class="col-md-12" style="padding: 0px !important;">
                                        <input type="hidden" name="hide_image_file" value="<?php echo $image_file; ?>">
                                        <!-- ------------------- Image Upload ---------------------- -->
                                        <div class="imageupload panel panel-default">
                                            <div class="panel-heading clearfix">
                                                <h3 class="panel-title pull-left">Staff Image</h3>
                                                <div class="btn-group pull-right">
                                                    <button type="button" class="btn btn-default active">File</button>
                                                    <button type="button" class="btn btn-default">URL</button>
                                                </div>
                                            </div>
                                            <div class="file-tab panel-body">
                                                <label class="btn btn-default btn-file">
                                                    <span>Browse</span>
                                                    <!-- The file is stored here. -->
                                                    <input type="file" name="image_file">
                                                </label>
                                                <button type="button" class="btn btn-default">Remove</button>
                                            </div>
                                            <div class="url-tab panel-body">
                                                <div class="input-group">
                                                    <input type="text" class="form-control hasclear" placeholder="Image URL">
                                                    <div class="input-group-btn">
                                                        <button type="button" class="btn btn-default">Submit</button>
                                                    </div>
                                                </div>
                                                <button type="button" class="btn btn-default">Remove</button>
                                                <!-- The URL is stored here. -->
                                                <input type="hidden" name="image-url">
                                            </div>
                                        </div>
                                        <!-- ------------------- Image Upload ---------------------- -->
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-12">
                                        <label class="col-form-label">Address <span class="err">*</span></label>
                                        <div class="form-group">
                                            <textarea class="form-control" name="staff_address" id="staff_address" rows="4" required oninvalid="this.setCustomValidity('Please enter the address...!')" oninput="this.setCustomValidity('')"><?php echo $staff_address; ?></textarea>
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

<script src="assets/dist/js/bootstrap-imageupload.js"></script>

<script type="text/javascript">
var $imageupload = $('.imageupload');
$imageupload.imageupload({ 
    allowedFormats: [ 'jpg', 'jpeg', 'png', 'gif' ],
    maxWidth: 500,
    maxHeight: 500,
    maxFileSizeKb: 1024,
    imgSrc: "<?php echo $img_path; ?>" 
});

$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterStaffSubNav').addClass('active');
});
</script>