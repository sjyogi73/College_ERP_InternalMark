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
//$menu_permission = explode('||', $_SESSION["menu_permission"]);

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
    try{
        $created_by = $_SESSION["user_id"];
        $created_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO fc_feesmaster (fees_name, amount, created_by, created_dt) 
              VALUE(:fees_name, :amount, :created_by, :created_dt)");
        $data = array(
            ":fees_name" => trim($_REQUEST["fees_name"]),
            ":amount" => trim($_REQUEST["amount"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        $stmt->execute($data);

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: feesmaster.php");
    die();
}
//---------------------------------save/submit----------------------------------

//---------------------------------edit----------------------------------------
if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM fc_feesmaster where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
            $fees_name = $obj->fees_name;
            $amount = $obj->amount;
        }
    }
}
//---------------------------------edit----------------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) {
    try{
        //echo "Update"; die();
        $updated_by = $_SESSION["user_id"];
        $updated_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("UPDATE fc_feesmaster SET 
                        name = :name, 
                        amount = :amount, 
                        updated_by = :updated_by, 
                        updated_dt = :updated_dt
                        WHERE id = :id");

        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
            ":name" => trim($_REQUEST["txt_name"]),
            ":amount" => trim($_REQUEST["txt_amount"]),
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

    header("location:feesmaster.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $sql="UPDATE fc_feesmaster SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]);
    $stmt = $con->query($sql);

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:feesmaster.php");
    die();
}
//---------------------------------delete----------------------------------------
?>
<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Fees Master
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Fees Collection</a></li>
            <li class="active">Fees Master</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <!-------------------------------------------------- Form ------------------------------------------>
            <div class="col-md-6">
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
                    <form id="thisForm" name="thisForm" action="feesmaster.php" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label">Fees Name (In CAPS) <span class="err">*</span></label>
                                <input type="text" class="form-control" name="fees_name" id="fees_name" placeholder="Enter The Fees Name" title="Enter The Fees Name" autocomplete="off" autofocus="autofocus" onKeyPress="return isCapitalWithSpace(event);" required oninvalid="this.setCustomValidity('Please enter the fees name(In CAPS)...!')" oninput="this.setCustomValidity('')" value="<?php echo $fees_name; ?>" />
                            </div>
                            <div class="form-group">
                                <label class="control-label">Amount <span class="err">*</span></label>
                                <input type="text" class="form-control" name="amount" id="amount" placeholder="Enter The Amount" title="Enter The Amount" autocomplete="off" onkeypress="return isNumberKey_With_Dot(event);" required oninvalid="this.setCustomValidity('Please enter the amount...!')" oninput="this.setCustomValidity('')" value="<?php echo $amount; ?>" />
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
            <!-- --------------------------------------------- View -------------------------------------------- -->
            <div class="col-md-6">
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
                                        <th>Fees Name</th>
                                        <th width="40" class="text-center">Amount</th>
                                        <th width="60" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                  
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
            <!-- ------------------------ View ---------------------------------- -->
        </div>
    </section>
</div>
<?php include("includes/footer.php"); ?>
<script>
    $(function () {
    var dataTable = $('#example1').DataTable({
    //$('#example1').DataTable({
        'autoWidth'     : false,
        'responsive'    : true,
        'processing'    : true,
        'serverSide'    : true,
        'pageLength'    : 12,
        'searching'     : false,
        //'scrollY'       : '570px',
        //'scrollCollapse': true,
        //'dom'           : 'Bfrtip',
        'dom'           : "<'row'<'col-sm-12 d-flex col-md-5'lf><'col-sm-12 col-md-7 text-right'B>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row m-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        'ajax'          : {
            'url':'datatable/FeesList.php',
            'type':'POST',
            'data': function(data){
                //alert(data);
                // var searchByValue = $('#searchByValue').val();
                // var searchByDegree = $('#searchByDegree').val();

                // data.searchByValue = searchByValue;
                // data.searchByDegree = searchByDegree;
            }
        },
        
        'columns'       : [
            { data: 'id' },
            { data: 'fees_name' },
            { data: 'amount' },
            { data: 'action' },
        ],

        rowReorder      : true,
        columnDefs      : [
            {
                targets: [0,3],
                className: 'text-center'
            },
			{
                targets: [2],
                className: 'text-right'
            },
            { 
                orderable: true, 
                className: 'reorder', 
                targets: [0,1,2] 
            },
            { 
                orderable: false, 
                targets: '_all' 
            }],

        buttons         : ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
    });

     
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterFeesmasterSubNav').addClass('active');
});
</script>

