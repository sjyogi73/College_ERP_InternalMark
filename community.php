<?php
ob_start();
session_start();

require_once("includes/common/connection.php");
require_once("includes/common/dbfunctions.php");
require_once("includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();
$converter = new Encryption;

// ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

isAdmin();
//$menu_permission = explode('||', $_SESSION["menu_permission"]);

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
    try{
        $created_by = 1;
        $created_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO tbl_community (comm_name, cdescription, created_by, created_dt) 
              VALUES (:comm_name, :cdescription, :created_by, :created_dt)");
        $data = array(
            ":comm_name" => trim($_REQUEST["comm_name"]),
            ":cdescription" => trim($_REQUEST["cdescription"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        $stmt->execute($data);

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: community.php");
    die();
}
//---------------------------------save/submit----------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) {
    try{
        //echo "Update"; die();
        $updated_by = $_SESSION["user_id"];
        $updated_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("UPDATE tbl_community SET comm_name = :comm_name, cdescription = :cdescription,
                        updated_by = :updated_by, updated_dt = :updated_dt WHERE id = :id");

        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
            ":comm_name" => trim($_REQUEST["comm_name"]),
            ":cdescription" => trim($_REQUEST["cdescription"]),
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

    header("location:community.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE tbl_community SET del_status = 1 WHERE id=" . $converter->decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:community.php");
    die();
}
//---------------------------------delete----------------------------------------
//---------------------------------edit----------------------------------------
if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM tbl_community where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
            $comm_name = $obj->comm_name;
            $cdescription = $obj->cdescription;
        }
    }
}
//---------------------------------edit----------------------------------------
?>
<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Community
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Community</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <?php 
            //if(in_array('createDegree',$menu_permission)){
            ?>
            <!-------------------------------------------------- Form ------------------------------------------>
            <div class="col-md-4">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">
                        <?php if(isset($_REQUEST["id"])){
                            echo "Edit";
                        }else{
                            echo "Add";
                        }
                        ?>
                        </h3>
                    </div>
					<br />
                    <form id="thisForm" name="thisForm" action="community.php" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label">Community (In CAPS) <span class="err">*</span></label>
                                <input type="text" class="form-control" name="comm_name" id="comm_name" maxlength="4" placeholder="Enter the Community Name" title="Enter the Community Name" autocomplete="off" autofocus="autofocus" value="<?php echo $comm_name; ?>" onKeyPress="return isCapitalNoSpace(event);" required oninvalid="this.setCustomValidity('Please enter the community name...!')" oninput="this.setCustomValidity('')" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description </label>
                                <input type="text" class="form-control" name="cdescription" id="cdescription" placeholder="Enter the Description" title="Enter the Description" autocomplete="off" value="<?php echo $cdescription; ?>" />
                            </div>
                        </div>
                        <div class="box-footer">
							<div class="pull-right">
								<?php if (isset($_REQUEST["id"])) { ?>
								<input type="hidden" value="<?php echo $id; ?>" name="hid_id">
								<button type="submit" name="update" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Update</button>
								<?php
								} else { ?>
								<button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
								<?php } ?>
							</div>
                        </div>
                    </form>
                </div>
            </div>
            <!-- ----------------------------------------------- Form ------------------------------------------ -->
            <?php
            //}
            //if(in_array('viewDegree',$menu_permission)){
            ?>
            <!-- --------------------------------------------- View -------------------------------------------- -->
            <div class="col-md-8">
                <div class="box box-primary">
                    <div class="box-header with-border">
                        <h3 class="box-title">List</h3>
                    </div>
                    <div class="box-body">
                        <div class="dt-responsive table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="8">#</th>
                                        <th width="100" class="text-center">Community</th>
                                        <th>Description</th>
                                        <th width="60" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rs = $con->query("SELECT * FROM tbl_community where del_status = 0 order by comm_name");
                                    if ($rs->rowCount()) {
                                        $sno=1;
                                        while ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td class="text-center"><?php echo $obj->comm_name; ?></td>
                                        <td><?php echo $obj->cdescription; ?></td>
                                        <td class="text-center">
                                            <?php //if(in_array('updateDegree',$menu_permission)){ ?>
                                            <a href="community.php?id=<?php echo $converter->encode($obj->id); ?>" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                            <?php //}
                                            //if(in_array('deleteDegree',$menu_permission)){
                                            ?>
                                            <a href="community.php?did=<?php echo $converter->encode($obj->id); ?>" title="Delete" onclick="return confirm('Are You Sure Want To Delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                            <?php //} ?>
                                        </td>
                                    </tr>
                                    <?php
                                            $sno++;
                                        }
                                    } else {
                                    ?>
                                    <tr>
                                        <td colspan="4" align="center">--No Records Found--</td>
                                    </tr>
                                    <?php
                                    }
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- ------------------------ View ---------------------------------- -->
            <?php
            //}
            ?>
        </div>
    </section>
</div>
<?php include("includes/footer.php"); ?>
<script>
$(function () {
    $('#example1').DataTable({
        'responsive'    : true,
        'pageLength'    : 10,
        'searching'     : false,
        'autoWidth'     : false,
        //'dom'           : 'Bfrtip',
        'dom'           : "<'row'<'col-sm-12 d-flex col-md-5'lf><'col-sm-12 col-md-7 text-right'B>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row m-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                            
        buttons         : ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print'],

        rowReorder      : true,
        columnDefs      : [
            { orderable: true, className: 'reorder', targets: [0,1,2,3,4] },
            { orderable: false, targets: '_all' }
        ]
    })
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterCommunitySubNav').addClass('active');
});
</script>
