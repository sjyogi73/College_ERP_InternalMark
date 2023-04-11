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
    try {
        $created_by = $_SESSION["user_id"];
        $created_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO fc_feesstructure (degree_id, fees_year, semester, total_amount, created_by, created_dt) 
                        VALUES (:degree_id, :fees_year, :semester, :total_amount, :created_by, :created_dt)");
        $data = array(
            ":degree_id" => trim($_REQUEST["degree_id"]),
            ":fees_year" => trim($_REQUEST["fees_year"]),
            ":semester" => trim($_REQUEST["semester"]),
            ":total_amount" => trim($_REQUEST["hid_total_amount"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        //echo "<pre>"; print_r($data); die();
        $stmt->execute($data);
        $id = $con->lastInsertId();

        /* details */
        $stmt1 = null;
        $stmt1 = $con->prepare("INSERT INTO fc_feesstructure_details (fs_id, sno, fees_id, amount) VALUES (:fs_id, :sno, :fees_id, :amount)");
        for ($x = 0; $x < count($_REQUEST['hid_fees_id']); $x++) {
            $data1 = array(
                ':fs_id' => $id,
                ':sno' => $x + 1,
                ':fees_id' => trim($_REQUEST['hid_fees_id'][$x]),
                ':amount' => trim($_REQUEST['hid_amount'][$x]),
            );
            $stmt1->execute($data1);
        }
        //print_r($data1); die();
        /* details */

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;
    }

    header("location: fees_structure_lst.php");
    die();
}
//---------------------------------save/submit----------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) {
    try {
        //echo "Update"; die();
       $updated_by = $_SESSION["user_id"]; 0;
        $updated_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("UPDATE fc_feesstructure SET degree_id=:degree_id, fees_year=:fees_year, semester=:semester, total_amount=:total_amount, updated_by=:updated_by, updated_dt=:updated_dt where id=:id");
        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
            ":degree_id" => trim($_REQUEST["degree_id"]),
            ":fees_year" => trim($_REQUEST["fees_year"]),
            ":semester" => trim($_REQUEST["semester"]),
            ":total_amount" => trim($_REQUEST["hid_total_amount"]),
            ":updated_by" => $updated_by,
            ":updated_dt" => $updated_dt
        );
        //print_r($data); die();
        $stmt->execute($data);

        /* details */
        $delete_details  = $con->query('DELETE FROM fc_feesstructure_details WHERE fs_id = ' . trim($_REQUEST["hid_id"]));
        $stmt1 = null;
        $stmt1 = $con->prepare("INSERT INTO fc_feesstructure_details (fs_id, sno, fees_id, amount) VALUES (:fs_id, :sno, :fees_id, :amount)");
        for ($x = 0; $x < count($_REQUEST['hid_fees_id']); $x++) {
            $data1 = array(
                ':fs_id' => trim($_REQUEST["hid_id"]),
                ':sno' => $x + 1,
                ':fees_id' => trim($_REQUEST['hid_fees_id'][$x]),
                ':amount' => trim($_REQUEST['hid_amount'][$x]),
            );
            $stmt1->execute($data1);
        }
        //print_r($data1); die();
        /* details */

        $_SESSION["msg"] = "Updated Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;
    }

    header("location:fees_structure_lst.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE fc_feesstructure SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:fees_structure_lst.php");
    die();
}
//---------------------------------delete----------------------------------------

if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM fc_feesstructure where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {

            $update = "update";

            $id = $obj->id;
            $degree_id = $obj->degree_id;
            $fees_year = $obj->fees_year;
            $semester = $obj->semester;
            $community = $obj->community;
            $total_amount = $obj->total_amount;
        }
    }
}

//die();
?>
<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Fees Structure
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Fees Collection</a></li>
            <li class="active">Fees Structure</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <?php if (isset($_REQUEST["id"])) {
                    echo '<h3 class="box-title">Edit</h3>';
                } else {
                    echo '<h3 class="box-title">Add</h3>';
                } ?>
                <?php
                //if(in_array('viewStudents',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="fees_structure_lst.php" class="btn btn-block btn-primary"><i class="fa fa-bars" aria-hidden="true"></i></a>
                </div>
                <?php
                //}
                ?>
            </div>
            <br />
            <form id="thisForm" name="thisForm" action="fees_structure.php" method="post" onsubmit="return fnValid();">
                <div class="box-body">
                    <div class="row" style="padding-bottom:15px;">
                        <div class="form-group">
                            <div class="col-md-4">
                                <label class="col-form-label">Degree <span class="err">*</span></label>
                                <select class="form-control select2" name="degree_id" id="degree_id" title="Select the Degree">
                                    <option value=""></option>
                                    <?php
                                    echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_degree", "dname", " WHERE del_status = 0");
                                    ?>
                                </select>
                                <script>
                                    document.thisForm.degree_id.value = "<?php echo $degree_id; ?>"
                                </script>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Year <span class="err">*</span></label>
                                <select class="form-control select2" name="fees_year" id="fees_year" title="Select the Year">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                                <script>
                                    document.thisForm.fees_year.value = "<?php echo $fees_year; ?>"
                                </script>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Semester <span class="err">*</span></label>
                                <select class="form-control select2" name="semester" id="semester" title="Select the Semester">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                    <option value="4">4</option>
                                    <option value="5">5</option>
                                    <option value="6">6</option>
                                </select>
                                <script>
                                    document.thisForm.semester.value = "<?php echo $semester; ?>"
                                </script>
                            </div>
                            <div class="col-md-2">
                                <label class="col-form-label">Community <span class="err">*</span></label>
                                <select class="form-control select2" name="community" id="community" title="Select the Community">
                                    <option value=""></option>
                                    <option value="0">--Nil--</option>
                                    <?php
                                    echo $dbcon->fnFillComboFromTable_Where("id", "comm_name", "tbl_community", "comm_name", " WHERE del_status = 0");
                                    ?>
                                </select>
                                <script>
                                    document.thisForm.community.value = "<?php echo $community; ?>"
                                </script>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="padding-bottom:15px;">
                        <div class="form-group">
                            <div class="col-lg-4">
                                <label class="col-form-label">&nbsp;Fees Name <span class="err">*</span></label>
                                <select class="form-control select2" name="fees_name" id="fees_name">
                                    <option value="">--Select --</option>
                                    <?php
                                    echo $dbcon->fnFillComboFromTable_Where("id", "fees_name", "fc_feesmaster", "fees_name", " WHERE del_status = 0");
                                    ?>
                                </select>
                            </div>
                            <div class="col-lg-2">
                                <label class="col-form-label">Amount</label>
                                <input type="text" class="form-control text-right" name="amount" id="amount" readonly value="">
                            </div>
                            <div class="col-lg-1" style="padding-top: 24px;">
                                <button class="btn btn-icon btn-success btn_add" style="width:35px; height:35px; padding:0px 8px; border-radius:0.12rem;" type="button" name="btn_add" id="btn_add"><i class="fa fa-plus-circle"></i></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-12">
                            <table class="table table-border table-hover table-sm" id="feesStructureTable">
                                <thead>
                                    <tr>
                                        <th class="text-center" style="padding: 0.5rem;" width="5%">#</th>
                                        <th class="text-center" style="padding: 0.5rem;">Fees Name</th>
                                        <th class="text-center" style="padding: 0.5rem;" width="10%">Amount</th>
                                        <th class="text-center" style="padding: 0.5rem;" width="2%">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    if (isset($update) == "update") {
                                        $sql = "SELECT * FROM fc_feesstructure_details where fs_id = " . $id . " ORDER BY sno";
                                        $res = $con->query($sql);
                                        if ($res->rowCount() > 0) {
                                            $records = $res->fetchAll();
                                            $sno = 1;
                                            foreach ($records as $row) {
                                                echo '<tr id="tr_' . $sno . '">';
                                                echo '    <td class="text-center" style="padding: 0.3rem;">' . $sno . '</td>';
                                                echo '    <td class="text-left" style="padding: 0.3rem;">' . $dbcon->GetOneRecord("fc_feesmaster", "fees_name", "id", $row->fees_id) . '<input type="hidden" name="hid_fees_id[]" id="hid_fees_id_' . $sno . '" value="' . $row->fees_id . '"></td>';
                                                echo '    <td class="text-right" style="padding: 0.3rem;">' . $row->amount . '<input type="hidden" name="hid_amount[]" id="hid_amount_' . $sno . '" class="hid_amount" value="' . $row->amount . '"></td>';
                                                echo '    <td class="text-center" style="padding-top:8px; padding: 0.3rem;"><a href="javascript:;" class="remove"><i class="fa fa-trash-o" title="Remove"></i></a></td>';
                                                echo '</tr>';
                                                $sno++;
                                            }
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2" class="text-right" style="padding: 0.3rem;">Total</td>
                                        <td class="text-right" style="padding: 0.3rem;">
                                            <span id="total_amount"><?php echo iif($total_amount == 0, "0.00", $total_amount); ?></span>
                                            <input type="hidden" value="<?php echo $total_amount; ?>" name="hid_total_amount" id="hid_total_amount">
                                        </td>
                                        <td style="padding: 0.3rem;">&nbsp;</td>
                                    </tr>
                                </tfoot>
                            </table>
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
//----------Fees name based fetch amount ----------
$('#fees_name').change(function() {
    var fees_id = $(this).val();

    if (fees_id != "") {
        $.ajax({
            type: "POST",
            url: "ajax/get_list.php",
            data: {
                mode: 'fees_id',
                fees_id: fees_id,
            }
        }).done(function(msg) {
            //alert(msg);
            $('#amount').val(msg);
        });
    }
}).trigger('change');
//----------Fees name based fetch amount ----------

//--------------btn_add--------------------
var rowIdx = 0;
$('#btn_add').on("click", function(e) {
    var fees_id = parseInt($('#fees_name').val());

    if (isNaN(fees_id)) fees_id = 0;

    if (fees_id == 0) {
        swal({
            title: "Please select the fees name..!",
            //text: "Please select the course name..!",
            closeModal: false,
        },
        function(){
            $('#fees_name').select2('open');
        });
        return false;
    }

    var total = 0;
    $.ajax({
        type: "POST",
        url: "ajax/get_list.php",
        data: {
            mode: 'fees_add',
            fees_id: fees_id,
        }
    }).done(function(msg) {
        var data = msg.split('~');

        html_tr = '';
        html_tr += '<tr id="tr_' + (++rowIdx) + '">';
        html_tr += '    <td class="text-center">' + rowIdx + '</td>';
        html_tr += '    <td class="text-left">' + data[1] + '<input type="hidden" name="hid_fees_id[]" id="hid_fees_id_' + rowIdx + '" value="' + data[0] + '"></td>';
        html_tr += '    <td class="text-right">' + data[2] + '<input type="hidden" name="hid_amount[]" id="hid_amount_' + rowIdx + '" class="hid_amount" value="' + data[2] + '"></td>';
        html_tr += '    <td class="text-center" style="padding-top:8px;"><a href="javascript:;" class="remove"><i class="fa fa-trash-o" title="Remove"></i></a></td>';
        html_tr += '</tr>';

        $('#feesStructureTable tbody').append(html_tr);

        calc(); // To Calculate the total price
        $('#fees_name').focus();
    });
    $('#fees_name').val(null).trigger('change');
    $('#amount').val("");
});
//--------------btn_add--------------------

$('#feesStructureTable tbody').on("click", '.remove', function() {
    $(this).closest("tr").remove();
    calc(); // To Calculate the total price
});

function calc() {
    var total_amount = 0;

    $(".hid_amount").each(function() {
        var hid_amount = $(this).val();
        if ($.isNumeric(hid_amount)) {
            total_amount += parseFloat(hid_amount);
        }
    });

    $("#total_amount").html(total_amount.toFixed(2));
    $("#hid_total_amount").val(total_amount.toFixed(2));
}

$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterFeesStructureSubNav').addClass('active');
});

function fnValid(){
    if(document.thisForm.degree_id.value == ""){ 
        swal({
            title: "Please select the degree..!",
            //text: "Please select the course name..!",
            closeModal: false,
        },
        function(){
            $('#degree_id').select2('open');
        });
        return false; 
    }
    
    if(document.thisForm.fees_year.value == ""){ 
        swal({
            title: "Please select the year..!",
            //text: "Please select the course name..!",
            closeModal: false,
        },
        function(){
            $('#fees_year').select2('open');
        });
        return false; 
    }
    
    if(document.thisForm.semester.value == ""){ 
        swal({
            title: "Please select the semester..!",
            //text: "Please select the course name..!",
            closeModal: false,
        },
        function(){
            $('#semester').select2('open');
        });
        return false; 
    }

    if(document.thisForm.community.value == ""){ 
        swal({
            title: "Please select the community..!",
            //text: "Please select the course name..!",
            closeModal: false,
        },
        function(){
            $('#community').select2('open');
        });
        return false; 
    }
}
</script>