<?php
ob_start();
session_start();

define("BASEPATH", "../");

require_once(BASEPATH . "includes/common/connection.php");
require_once(BASEPATH . "includes/common/dbfunctions.php");
require_once(BASEPATH . "includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();
$converter = new Encryption;

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

//isAdmin();
//$menu_permission = explode('||', $_SESSION["menu_permission"]);

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])){
    try{		
    
        $created_by = 1;
        $created_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO lib_Publisher (lib_pub_id,lib_pub_name,lib_pub_add,lib_pub_others, created_by, created_dt) 
              VALUE(:lib_pub_id,:lib_pub_name,:lib_pub_add,:lib_pub_others, :created_by, :created_dt)");
        $data = array(
		    ":lib_pub_id" => trim($_REQUEST["lib_pub_id"]),
            ":lib_pub_name" => trim(strtoupper($_REQUEST["lib_pub_name"])),
			":lib_pub_add" => trim($_REQUEST["lib_pub_add"]),
			":lib_pub_others" => trim($_REQUEST["lib_pub_others"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        $stmt->execute($data);

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: Publisher.php");
    die();
}
//---------------------------------save/submit----------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) 
{
    try
	{
        //echo "Update"; die();
       $updated_by = $_SESSION["user_id"]; 0;
        $updated_dt = date('Y-m-d H:i:s');

        $stmt = null;
        $stmt = $con->prepare("UPDATE lib_publisher SET 
						lib_pub_id=:lib_pub_id, 
                        lib_pub_name=:lib_pub_name,
                        lib_pub_add=:lib_pub_add, 						
                        lib_pub_others=:lib_pub_others,
                        updated_by=:updated_by, 
                        updated_dt=:updated_dt
                        WHERE id=:id");

        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
			":lib_pub_id" => trim($_REQUEST["lib_pub_id"]),
            ":lib_pub_name" => trim(strtoupper($_REQUEST["lib_pub_name"])),
			":lib_pub_add" => trim($_REQUEST["lib_pub_add"]),
			":lib_pub_others" => trim($_REQUEST["lib_pub_others"]),
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
    header("location:Publisher.php");
    //    die();
	}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
   $stmt = null;
    $stmt = $con->query("UPDATE lib_Publisher SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:Publisher.php");
    die();
}
//---------------------------------delete----------------------------------------
//---------------------------------edit----------------------------------------
if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM lib_publisher where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
			 $lib_pub_id = $obj->lib_pub_id;
            $lib_pub_name = $obj->lib_pub_name;
			$lib_pub_add = $obj->lib_pub_add;
            $lib_pub_others = $obj->lib_pub_others;
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
            Publisher
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Publisher</li>
        </ol>
    </section>
    <section class="content">
        <div class="row">
            <?php 
            //if(in_array('createPublisher',$menu_permission)){
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
                    <form id="thisForm" name="thisForm" action="Publisher.php" method="post">
                        <div class="box-body">
                            <div class="form-group">
                                <label class="control-label">Publisher ID <span class="err">*</span></label>
                                <input type="text" class="form-control" value="<?php echo $lib_pub_id; ?>"name="lib_pub_id" id="lib_pub_id" placeholder="Enter The Publisher ID" title="Enter The Publisher ID" autocomplete="off" autofocus="autofocus" required oninvalid="this.setCustomValidity('Please enter the Publisher ID...!')" oninput="this.setCustomValidity('')" />
                            </div>
							<div class="form-group">
                                <label class="control-label">Publisher Name (In CAPS) <span class="err">*</span></label>
                                <input type="text" class="form-control" value="<?php echo $lib_pub_name; ?>"name="lib_pub_name" id="lib_pub_name" placeholder="Enter The Publisher Name" title="Enter The Publisher Name" autocomplete="off" autofocus="autofocus" onKeyPress="return isCapitalWithSpace(event);" required oninvalid="this.setCustomValidity('Please enter the Publisher name...!')" oninput="this.setCustomValidity('')" />
                            </div>
							<div class="form-group">
                                    <div >
										<label class="control-label">Address <span class="err">*</span></label> 
                                            <textarea class="form-control" name="lib_pub_add" id="lib_pub_add" rows="3" required oninvalid="this.setCustomValidity('Please enter the address...!')" oninput="this.setCustomValidity('')"><?php echo $lib_pub_add; ?></textarea>
                                    </div>
                             </div>
							 <div class="form-group">
                                    <div >
										<label class="control-label">Others <span class="err">*</span></label> 
                                            <textarea class="form-control" name="lib_pub_others" id="lib_pub_others" rows="3" required oninvalid="this.setCustomValidity('Please enter the Others...!')" oninput="this.setCustomValidity('')"><?php echo $lib_pub_others; ?></textarea>
                                    </div>
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
            //if(in_array('viewPublisher',$menu_permission)){
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
										  <th width="60" class="text-center">Publisher ID</th>
                                          <th>Publisher Name</th>	
                                          <th>Address</th>
                                          <th width="60" class="text-center">Others</th>										
                                          <th width="60" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $rs = $con->query("SELECT * FROM lib_publisher where del_status=0 order by lib_pub_id");
                                    if ($rs->rowCount()) {
                                        $sno=1;
                                        while ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $sno; ?></td>
										<td><?php echo $obj->lib_pub_id; ?></td>
                                        <td><?php echo $obj->lib_pub_name; ?></td>										
                                        <td><?php echo $obj->lib_pub_add; ?></td>										
                                        <td><?php echo $obj->lib_pub_others; ?></td>										
                                        <td class="text-center">
                                            <?php //if(in_array('updatePublisher',$menu_permission))
											//{ ?>
                                            <a href="Publisher.php?id=<?php echo $converter->encode($obj->id); ?>" title="Edit"><i class="fa fa-pencil" aria-hidden="true"></i></a>&nbsp;&nbsp;
                                            <?php //}
                                            //if(in_array('deletePublisher',$menu_permission)){
                                            ?>
                                            <a href="Publisher.php?did=<?php echo $converter->encode($obj->id); ?>" title="Delete" onclick="return confirm('Are You Sure Want To Delete?');"><i class="fa fa-trash-o" aria-hidden="true"></i>
                                            </a>
                                            <?php //} ?>
                                        </td>
                                    </tr>
                                    <?php
                                            $sno++;
                                        }
                                    } 
									else
									{
                                    ?>
                                    <tr>
                                        <td colspan="5" align="center">--No Records Found--</td>
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
    $('#masterPublisherSubNav').addClass('active');
});
</script>
