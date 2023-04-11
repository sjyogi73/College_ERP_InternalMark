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

//ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

isAdmin();
//$menu_permission = explode('||', $_SESSION["menu_permission"]);

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
    try{
        $created_by = 1;
        $created_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO att_dayorder (do_date, do_desc, dayorder, do_wday, created_by, created_dt) 
              VALUES (:do_date, :do_desc, :dayorder, :do_wday, :created_by, :created_dt)");

        $data = array(
            ":do_date" => date("Y-m-d", strtotime($_REQUEST["do_date"])),
            ":do_desc" => trim($_REQUEST["do_desc"]),
            ":dayorder" => trim($_REQUEST["dayorder"]),
            ":do_wday" => trim($_REQUEST["do_wday"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        $stmt->execute($data);

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: dayorder.php");
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
        $stmt = $con->prepare("UPDATE att_dayorder SET do_date = :do_date, do_desc = :do_desc, dayorder = :dayorder, do_wday = :do_wday,
                        updated_by = :updated_by, updated_dt = :updated_dt WHERE id = :id");

        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
            ":do_date" => date("Y-m-d", strtotime($_REQUEST["do_date"])),
            ":do_desc" => trim($_REQUEST["do_desc"]),
            ":dayorder" => trim($_REQUEST["dayorder"]),
            ":do_wday" => trim($_REQUEST["do_wday"]),
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

    header("location:dayorder.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE att_dayorder SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:dayorder.php");
    die();
}
//---------------------------------delete----------------------------------------
//---------------------------------edit----------------------------------------
if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM att_dayorder where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
            $do_date = $obj->do_date;
            $do_desc = $obj->do_desc;
            $dayorder = $obj->dayorder;
            $do_wday = $obj->do_wday;
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
            Day Order
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Day Order</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <?php 
            //if(in_array('createDepartment',$menu_permission)){
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
                    <form id="thisForm" name="thisForm" action="dayorder.php" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label">Date <span class="err">*</span></label>
                                <input type="date" class="form-control" name="do_date" id="do_date" title="Select the Date" value="<?php echo $do_date; ?>" autofocus="autofocus" required oninvalid="this.setCustomValidity('Please select the date...!')" oninput="this.setCustomValidity('')" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Description </label>
                                <input type="text" class="form-control" name="do_desc" id="do_desc" placeholder="Enter the Description" title="Enter the Description" autocomplete="off" onKeyPress="return isAlphaOnly(event);" value="<?php echo $do_desc; ?>" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Day Order <span class="err">*</span></label>
                                <select class="form-control select2" name="dayorder" id="dayorder" title="Select the Day Order" required oninvalid="this.setCustomValidity('Please select the day order...!')" onchange="this.setCustomValidity('')">
                                    <option value=""></option>
                                    <option value="1">I</option>
                                    <option value="2">II</option>
                                    <option value="3">III</option>
                                    <option value="4">IV</option>
                                    <option value="5">V</option>
                                    <option value="6">VI</option>
                                </select>
                                <script>document.thisForm.dayorder.value = "<?php echo $dayorder; ?>"</script>
                            </div>
                            <div class="form-group">
                                <label class="control-label">Current Working Day <span class="err">*</span></label>
                                <input type="text" class="form-control" name="do_wday" id="do_wday" maxlength="2" placeholder="Enter the Current Working Day" title="Enter the Current Working Day" autocomplete="off" onKeyPress="return isNumberKey(event);" value="<?php echo $do_wday; ?>" required oninvalid="this.setCustomValidity('Please enter the current working day...!')" oninput="this.setCustomValidity('')" />
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
            //if(in_array('viewDepartment',$menu_permission)){
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
                                        <th width="60" class="text-center">Date</th>
                                        <th>Description</th>
                                        <th width="60" class="text-center">Day Order</th>
                                        <th width="80" class="text-center">Working Day</th>
                                        <th width="60" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rs = $con->query("SELECT * FROM att_dayorder where del_status = 0 order by do_wday desc");
                                    if ($rs->rowCount()) {
                                        $sno=1;
                                        while ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $sno; ?></td>
                                        <td class="text-center"><?php echo date("d-m-Y", strtotime($obj->do_date)); ?></td>
                                        <td><?php echo $obj->do_desc; ?></td>
                                        <td class="text-center"><?php echo $obj->dayorder; ?></td>
                                        <td class="text-center"><?php echo $obj->do_wday; ?></td>
                                        <td class="text-center">
                                            <?php //if(in_array('updateDepartment',$menu_permission)){ ?>
                                            <a href="dayorder.php?id=<?php echo $converter->encode($obj->id); ?>" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                            <?php //}
                                            //if(in_array('deleteDepartment',$menu_permission)){
                                            ?>
                                            <a href="dayorder.php?did=<?php echo $converter->encode($obj->id); ?>" title="Delete" onclick="return confirm('Are You Sure Want To Delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i>
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
                                        <td colspan="6" align="center">--No Records Found--</td>
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
            { orderable: true, className: 'reorder', targets: [0,1] },
            { orderable: false, targets: '_all' }
        ]
    })
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterDayorderSubNav').addClass('active');
});
</script>
