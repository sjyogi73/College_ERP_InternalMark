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
$menu_permission1 = explode('||', $_SESSION["menu_permission"]);

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
    try{
        $created_by = $_SESSION["user_id"];
        $created_dt = date('Y-m-d H:i:s');

        if ($_REQUEST['permissions']) {
            $permissions = implode('||', $_REQUEST['permissions']);
        }
        else
        {
            $permissions = "";
        }

        $stmt = null;
        $stmt = $con->prepare("INSERT INTO tbl_roles (role_name, menu_permission, status, created_by, created_dt) 
                        VALUES (:role_name, :menu_permission, :status, :created_by, :created_dt)");
        $data = array(
            ":role_name" => trim(ucwords($_REQUEST["role_name"])),
            ":menu_permission" => $permissions,
            ":status" => trim($_REQUEST["status"]),
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        //print_r($data); die();
        $stmt->execute($data);

        $_SESSION["msg"] = "Saved Successfully";
    } catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: roles_lst.php");
    die();
}
//---------------------------------save/submit----------------------------------
//---------------------------------update--------------------------------------
if (isset($_REQUEST["update"])) {
    try{
       $updated_by = $_SESSION["user_id"]; 0;
        $updated_dt = date('Y-m-d H:i:s');

        if ($_REQUEST['permissions']) {
            $permissions = implode('||', $_REQUEST['permissions']);
        }
        else
        {
            $permissions = "";
        }

        $stmt = null;
        $stmt = $con->prepare("UPDATE tbl_roles SET role_name=:role_name, menu_permission=:menu_permission, status=:status, updated_by=:updated_by, updated_dt=:updated_dt where id=:id");
        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
            ":role_name" => trim(ucwords($_REQUEST["role_name"])),
            ":menu_permission" => $permissions,
            ":status" => trim($_REQUEST["status"]),
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

    header("location:roles_lst.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE tbl_roles SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]));

    $_SESSION["msg"] = "Deleted Successfully";

    header("location:roles_lst.php");
    die();
}
//---------------------------------delete----------------------------------------

if (isset($_REQUEST["id"])) {
    $rs = $con->query("SELECT * FROM tbl_roles where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;
            $role_name = $obj->role_name;
            $menu_permissions = $obj->menu_permission;
            $status = $obj->status;
        }
    }
}
?>

<style type="text/css">
  .menu-head {
    background-color: #3c8dbc;
    color: #ffffff;
    padding: 10px 3px 3px 10px;
    font-size: 15px;
  }

  #menu_perimission_div{
    /*height: 540px;
    overflow-y: auto;*/
    max-height: 531px;
    margin-bottom: 10px;
    overflow: scroll;
    overflow-x: hidden;
    -webkit-overflow-scrolling: touch;
  }
  #menu_perimission_div::-webkit-scrollbar {
    width: 4px;
  }
  #menu_perimission_div::-webkit-scrollbar-track {
    background: #f1f1f1; 
  }
  /* Handle */
  #menu_perimission_div::-webkit-scrollbar-thumb {
    background: #888; 
  }
  /* Handle on hover */
  #menu_perimission_div::-webkit-scrollbar-thumb:hover {
    background: #555; 
  }
</style>

<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>

<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Roles and Permissions
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-cog"></i> Settings</a></li>
            <li class="active">Roles and Permissions</li>
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
                if(in_array('viewRoles',$menu_permission1)){
                ?>
                <div class="box-tools pull-right">
                    <a href="roles_lst.php" class="btn btn-block btn-primary"><i class="fa fa-bars" aria-hidden="true"></i></a>
                </div>
                <?php
                }
                ?>
            </div>
            <br />
            <form id="thisForm" name="thisForm" action="roles.php" method="post">
                <div class="box-body">
                    <div class="col-md-12">
                        
                        <div class="row">
                            <div class="form-group col-md-9">
                              <label>Role Name</label><span class="err">*</span>
                              <input type="text" class="form-control" name="role_name" id="role_name" placeholder="Enter the Role Name" value="<?php if(!empty($role_name)){ echo $role_name;} ?>" autofocus autocomplete="off" title="Enter the Role Name" onKeyPress="return isNameKey(event);" required oninvalid="this.setCustomValidity('Please enter the role name...!')" oninput="this.setCustomValidity('')">
                            </div>

                            <div class="form-group col-md-3">
                              <label>Status</label>
                              <select class="form-control select2" name="status" id="status" >
                                <?php 
                                if(!empty($status)){
                                  if($status==1){
                                    echo "<option value='1' selected>Active</option>";
                                    echo "<option value='0'>IN Active</option>";
                                  }
                                  else{
                                    echo "<option value='1'>Active</option>";
                                    echo "<option value='0' selected>IN Active</option>";
                                  }
                                }
                                else{ 
                                ?>
                                <option value="1">Active</option>
                                <option value="0">IN Active</option>
                              <?php } ?>
                              </select>
                            </div>
                        </div>

                        <div class="row" id="menu_perimission_div">
                            <div class="form-group col-sm-12" style="padding-right: 10px;">
                              <div class="menu-head">
                                <label>Menu Permission</label>
                              </div>
                              
                              <?php 
                              if(!empty($menu_permissions)){
                              $serialize_permission = explode('||', $menu_permissions);
                              }
                              ?>

                              <table class="table table-responsive">
                                <thead>
                                  <tr>
                                    <th></th>
                                    <th>Create</th>
                                    <th>Update</th>
                                    <th>View</th>
                                    <th>Delete</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr>
                                    <td><b>Masters - Department</b></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="createDepartment" <?php if(!empty($serialize_permission)){
                                      if(in_array('createDepartment', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="updateDepartment" <?php if(!empty($serialize_permission)){
                                      if(in_array('updateDepartment', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="viewDepartment" <?php if(!empty($serialize_permission)){
                                      if(in_array('viewDepartment', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="deleteDepartment" <?php if(!empty($serialize_permission)){
                                      if(in_array('deleteDepartment', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                  </tr>
                                  <tr>
                                    <td><b>Masters - Degree</b></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="createDegree" <?php if(!empty($serialize_permission)){
                                      if(in_array('createDegree', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="updateDegree" <?php if(!empty($serialize_permission)){
                                      if(in_array('updateDegree', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="viewDegree" <?php if(!empty($serialize_permission)){
                                      if(in_array('viewDegree', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="deleteDegree" <?php if(!empty($serialize_permission)){
                                      if(in_array('deleteDegree', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                  </tr>
                                  <tr>
                                    <td><b>Masters - Designation</b></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="createDesignation" <?php if(!empty($serialize_permission)){
                                      if(in_array('createDesignation', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="updateDesignation" <?php if(!empty($serialize_permission)){
                                      if(in_array('updateDesignation', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="viewDesignation" <?php if(!empty($serialize_permission)){
                                      if(in_array('viewDesignation', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="deleteDesignation" <?php if(!empty($serialize_permission)){
                                      if(in_array('deleteDesignation', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                  </tr>
                                  <tr>
                                    <td><b>Masters - Students</b></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="createStudents" <?php if(!empty($serialize_permission)){
                                      if(in_array('createStudents', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="updateStudents" <?php if(!empty($serialize_permission)){
                                      if(in_array('updateStudents', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="viewStudents" <?php if(!empty($serialize_permission)){
                                      if(in_array('viewStudents', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="deleteStudents" <?php if(!empty($serialize_permission)){
                                      if(in_array('deleteStudents', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                  </tr>
                                  <tr>
                                    <td><b>Masters - Staffs</b></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="createStaffs" <?php if(!empty($serialize_permission)){
                                      if(in_array('createStaffs', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="updateStaffs" <?php if(!empty($serialize_permission)){
                                      if(in_array('updateStaffs', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="viewStaffs" <?php if(!empty($serialize_permission)){
                                      if(in_array('viewStaffs', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="deleteStaffs" <?php if(!empty($serialize_permission)){
                                      if(in_array('deleteStaffs', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                  </tr>
                                  <!-- <tr>
                                    <td><b>Reports->Stock</b></td>
                                    <td colspan="4"><input type="checkbox" name="permissions[]" id="permission" value="StockReport" <?php //if(!empty($serialize_permission)){
                                      //if(in_array('StockReport', $serialize_permission)) { echo "checked"; } 
                                    //} ?>>&nbsp;<b>Access Permission</b></td>
                                  </tr>
                                  <tr>
                                    <td><b>Reports->Product</b></td>
                                    <td colspan="4"><input type="checkbox" name="permissions[]" id="permission" value="ProductReport" <?php //if(!empty($serialize_permission)){
                                      //if(in_array('ProductReport', $serialize_permission)) { echo "checked"; } 
                                    //} ?>>&nbsp;<b>Access Permission</b></td>
                                  </tr> -->
                                  <tr>
                                    <td><b>Settings - Roles and Permissions</b></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="createRoles" <?php if(!empty($serialize_permission)){
                                      if(in_array('createRoles', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="updateRoles" <?php if(!empty($serialize_permission)){
                                      if(in_array('updateRoles', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="viewRoles" <?php if(!empty($serialize_permission)){
                                      if(in_array('viewRoles', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="deleteRoles" <?php if(!empty($serialize_permission)){
                                      if(in_array('deleteRoles', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                  </tr>
                                  <tr>
                                    <td><b>Settings - Users</b></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="createUsers" <?php if(!empty($serialize_permission)){
                                      if(in_array('createUsers', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="updateUsers" <?php if(!empty($serialize_permission)){
                                      if(in_array('updateUsers', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="viewUsers" <?php if(!empty($serialize_permission)){
                                      if(in_array('viewUsers', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                    <td><input type="checkbox" name="permissions[]" id="permission" value="deleteUsers" <?php if(!empty($serialize_permission)){
                                      if(in_array('deleteUsers', $serialize_permission)) { echo "checked"; } 
                                    } ?>></td>
                                  </tr>
                                </tbody>
                              </table>

                              <div class="menu-head">
                                <label><input type="checkbox" id="select_all">
                                &nbsp;&nbsp;&nbsp;Select All</label>
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
$("#select_all").click(function(){
  if($("#select_all").prop('checked') == true){
    $(':checkbox').each(function() {
      this.checked = true;                        
    });
  }
  else
  {
    $(':checkbox').each(function() {
      this.checked = false;                        
    });
  }
});

$(document).ready(function() {
    $('#settingsMainNav').addClass('active');
    $('#settingsRolesSubNav').addClass('active');
});
</script>