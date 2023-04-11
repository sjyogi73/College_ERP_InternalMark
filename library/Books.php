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

//isAdmin();
//$menu_permission = explode('||', $_SESSION["menu_permission"]);

//---------------------------------save/submit----------------------------------
if (isset($_REQUEST["submit"])) {
    try{
        $is_exist = $dbcon->GetOneRecord("lib_books", "bk_acc_no", " bk_acc_no = '". $_REQUEST["bk_acc_no"] ."' AND del_status", 0);
		if ($is_exist != "") {
			$_SESSION['msg_err'] = "Book already exist..!";
			header("location:Books_lst.php");
			die();
		}
        
        $created_by = 1;
        $created_dt = date('Y-m-d H:i:s');
       
        $stmt = null;
        $stmt = $con->prepare("INSERT INTO lib_books (bk_vendor, bk_pur_no, bk_pur_date, bk_language, bk_acc_no, bk_class_no, bk_title, bk_sub_title, bk_author1, bk_author2, bk_author3,bk_yrpub,bk_edition,bk_price,bk_isbn,bk_pages,bk_publication,bk_department,bk_subject,bk_keyword,bk_location,bk_status,bk_notes,created_by,created_dt) 
        VALUE(:bk_vendor,:bk_pur_no,:bk_pur_date,:bk_language,:bk_acc_no,:bk_class_no,:bk_title,:bk_sub_title,:bk_author1,:bk_author2,:bk_author3,:bk_yrpub,:bk_edition,:bk_price,:bk_isbn,:bk_pages,:bk_publication,:bk_department,:bk_subject,:bk_keyword,:bk_location,:bk_status,:bk_notes,:created_by,:created_dt)");
        $data = array(
		":bk_vendor" => trim($_REQUEST["bk_vendor"]),
            ":bk_pur_no" => trim(($_REQUEST["bk_pur_no"])),
            ":bk_pur_date" => trim($_REQUEST["bk_pur_date"]),
            ":bk_language" => trim($_REQUEST["bk_language"]),
            ":bk_acc_no" => trim($_REQUEST["bk_acc_no"]),
            ":bk_class_no" => trim($_REQUEST["bk_class_no"]),
            ":bk_title" => trim($_REQUEST["bk_title"]),
            ":bk_sub_title" => trim($_REQUEST["bk_sub_title"]), 
            ":bk_author1" => trim($_REQUEST["bk_author1"]), 
            ":bk_author2" => trim($_REQUEST["bk_author2"]), 
            ":bk_author3" => trim($_REQUEST["bk_author3"]), 
            ":bk_yrpub" => trim($_REQUEST["bk_yrpub"]), 
            ":bk_edition" => trim($_REQUEST["bk_edition"]),
			 ":bk_price" => trim($_REQUEST["bk_price"]),
            ":bk_isbn" => trim(($_REQUEST["bk_isbn"])),
            ":bk_pages" => trim($_REQUEST["bk_pages"]),
            ":bk_publication" => trim($_REQUEST["bk_publication"]),
            ":bk_department" => trim($_REQUEST["bk_department"]),
            ":bk_subject" => trim($_REQUEST["bk_subject"]),
            ":bk_keyword" => trim($_REQUEST["bk_keyword"]),
            ":bk_location" => trim($_REQUEST["bk_location"]), 
            ":bk_status" => trim($_REQUEST["bk_status"]), 
            ":bk_notes" => trim($_REQUEST["bk_notes"]), 
            ":created_by" => $created_by,
            ":created_dt" => $created_dt,
        );
        $stmt->execute($data);       
        
        $_SESSION["msg"] = "Saved Successfully";
    } 
	catch (Exception $e) {
        $str = filter_var($e->getMessage(), FILTER_SANITIZE_STRING);
        echo $_SESSION['msg_err'] = $str;  
    }
    
    header("location: Books_lst.php");
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
         $stmt = $con->prepare("UPDATE lib_books SET bk_vendor =:bk_vendor, bk_pur_no=:bk_pur_no, bk_pur_date=:bk_pur_date, bk_language=:bk_language, bk_acc_no=:bk_acc_no, bk_class_no=:bk_class_no, bk_title=:bk_title, bk_sub_title=:bk_sub_title, bk_author1=:bk_author1, bk_author2=:bk_author2, bk_author3=:bk_author3,bk_yrpub=:bk_yrpub,bk_edition =:bk_edition,bk_price =:bk_price,bk_isbn =:bk_isbn,bk_pages =:bk_pages, bk_publication =:bk_publication,bk_department =:bk_department,bk_subject =:bk_subject,bk_keyword =:bk_keyword, bk_location =:bk_location,bk_status =:bk_status,bk_notes =:bk_notes,updated_by=:updated_by, updated_dt=:updated_dt where id=:id");
        $data = array(
            ":id" => trim($_REQUEST["hid_id"]),
             ":bk_vendor" => trim($_REQUEST["bk_vendor"]),
            ":bk_pur_no" => trim(($_REQUEST["bk_pur_no"])),
            ":bk_pur_date" => trim($_REQUEST["bk_pur_date"]),
            ":bk_language" => trim($_REQUEST["bk_language"]),
            ":bk_acc_no" => trim($_REQUEST["bk_acc_no"]),
            ":bk_class_no" => trim($_REQUEST["bk_class_no"]),
            ":bk_title" => trim($_REQUEST["bk_title"]),
            ":bk_sub_title" => trim($_REQUEST["bk_sub_title"]), 
            ":bk_author1" => trim($_REQUEST["bk_author1"]), 
            ":bk_author2" => trim($_REQUEST["bk_author2"]), 
            ":bk_author3" => trim($_REQUEST["bk_author3"]), 
            ":bk_yrpub" => trim($_REQUEST["bk_yrpub"]), 
            ":bk_edition" => trim($_REQUEST["bk_edition"]),
			 ":bk_price" => trim($_REQUEST["bk_price"]),
            ":bk_isbn" => trim(($_REQUEST["bk_isbn"])),
            ":bk_pages" => trim($_REQUEST["bk_pages"]),
            ":bk_publication" => trim($_REQUEST["bk_publication"]),
            ":bk_department" => trim($_REQUEST["bk_department"]),
            ":bk_subject" => trim($_REQUEST["bk_subject"]),
            ":bk_keyword" => trim($_REQUEST["bk_keyword"]),
            ":bk_location" => trim($_REQUEST["bk_location"]), 
            ":bk_status" => trim($_REQUEST["bk_status"]), 
            ":bk_notes" => trim($_REQUEST["bk_notes"]),
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
    header("location:Books_lst.php");
    die();
}
//---------------------------------update----------------------------------------
//---------------------------------delete----------------------------------------
if (isset($_REQUEST["did"])) {
    $stmt = null;
    $stmt = $con->query("UPDATE lib_books SET del_status=1 WHERE id=" . $converter->decode($_REQUEST["did"]));
    $_SESSION["msg"] = "Deleted Successfully";
    header("location:Books_lst.php");
    die();
}
//---------------------------------delete----------------------------------------

//---------------------------------edit----------------------------------------
if (isset($_REQUEST["id"])) {
  $rs = $con->query("SELECT * FROM lib_books where id=" . $converter->decode($_REQUEST["id"]));
    if ($rs->rowCount()) {
        if ($obj = $rs->fetch(PDO::FETCH_OBJ)) {
            $id = $obj->id;$bk_vendor = $obj->bk_vendor;
            $bk_pur_no = $obj->bk_pur_no;
			$bk_pur_date = $obj->bk_pur_date;
			$bk_language = $obj->bk_language;
			$bk_acc_no = $obj->bk_acc_no;
			$bk_class_no = $obj->bk_class_no;
			$bk_title = $obj->bk_title;
			$bk_sub_title = $obj->bk_sub_title;
			$bk_author1 = $obj->bk_author1;
			$bk_author2 = $obj->bk_author2;
			$bk_author3 = $obj->bk_author3;
			$bk_yrpub = $obj->bk_yrpub;
			$bk_edition = $obj->bk_edition;
			$bk_price = $obj->bk_price;
			$bk_isbn = $obj->bk_isbn;
			$bk_pages = $obj->bk_pages;
			$bk_publication = $obj->bk_publication;
			$bk_department = $obj->bk_department;
			$bk_subject = $obj->bk_subject;
			$bk_keyword = $obj->bk_keyword;
			$bk_location = $obj->bk_location;
			$bk_status = $obj->bk_status;
			$bk_notes = $obj->bk_notes;         
        }
    }	
}
?>

<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Books
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Masters</a></li>
            <li class="active">Books</li>
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
                //if(in_array('viewBooks',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="Books_lst.php" class="btn btn-block btn-primary"><i class="fa fa-bars" aria-hidden="true"></i></a>
                </div>
                <?php
                //}
                ?>
            </div>        
			<form id="thisForm" name="thisForm" class="form-horizontal" action="Books_lst.php" method="post">
                <div class="box-body">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-md-6">
							    <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Vendor Name</label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bk_vendor" id="bk_vendor" title="Select the Vendor Name" onchange="this.setCustomValidity('')">
                                       
                                        <?php
                                            echo $dbcon->fnFillComboFromTable_Where("id","vendor_id ","lib_vendor", "vendor_id", " WHERE del_status = 0");  
	                                        ?>
                                        </select>
                                        <script>document.thisForm.bk_location.value = "<?php echo $bk_vendor; ?>"</script>
                                    </div>
								</div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Bill Number</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_pur_no" id="bk_pur_no" placeholder="Enter the Bill No" title="Enter The Bill No" autocomplete="off" onKeyPress="return isCapitalNumericNoSpace(event);" oninput="this.setCustomValidity('')" maxlength="50" value="<?php echo $bk_pur_no ; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Bill Date </label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control" name="bk_pur_date" id="bk_pur_date" title="Select The Bill Date" autocomplete="off" oninput="this.setCustomValidity('')" value="<?php echo $bk_pur_date; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Language <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bk_language" id="bk_language" title="Select the Language" required oninvalid="this.setCustomValidity('Please select the Language...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <option value="1">Tamil</option>
                                            <option value="2">English</option>
											<option value="3">Others</option>
                                        </select>
                                        <script>document.thisForm.bk_language.value = "<?php echo $bk_language; ?>"</script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Accession Number <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_acc_no" id="bk_acc_no" placeholder="Enter the Accession Number." title="Enter The Accession Number." autocomplete="off" autofocus="autofocus" onKeyPress="return isCapitalNumericNoSpace(event);" required oninvalid="this.setCustomValidity('Please enter the staff id....!')" oninput="this.setCustomValidity('')" maxlength="8" value="<?php echo $bk_acc_no; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Class / Book Number<span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_class_no" id="bk_class_no" placeholder="Enter the Book Name." title="Enter The Book Name" autocomplete="off" autofocus="autofocus" required oninvalid="this.setCustomValidity('Please enter the book name....!')" oninput="this.setCustomValidity('')" maxlength="8" value="<?php echo $bk_class_no; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Book Title <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_title" id="bk_title" placeholder="Enter the Book Title" title="Enter The Book Title" autocomplete="off" required oninvalid="this.setCustomValidity('Please enter the book title...!')" oninput="this.setCustomValidity('')" maxlength="200" value="<?php echo $bk_title; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Book Sub Title</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_sub_title" id="bk_sub_title" placeholder="Enter the Sub Title." title="Enter The Sub Title." autocomplete="off" autofocus="autofocus" oninput="this.setCustomValidity('')" maxlength="50" value="<?php echo $bk_sub_title; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Book Author 1 <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_author1" id="bk_author1" placeholder="Enter the Book Author 1" title="Enter The Book Author 1" autocomplete="off" oninput="this.setCustomValidity('')" value="<?php echo $bk_author1; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Book Author 2</label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_author2" id="bk_author2" placeholder="Enter the Book Author 2." title="Enter The Book Author 2" autocomplete="off" autofocus="autofocus" onKeyPress="return isCapitalNumericNoSpace(event);" oninput="this.setCustomValidity('')" value="<?php echo $bk_author2; ?>">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Book Author 3 </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_author3" id="bk_author3" placeholder="Enter the Book Title" title="Enter The Book Author 3" autocomplete="off" oninput="this.setCustomValidity('')" value="<?php echo $bk_author3; ?>">
                                    </div>
                                </div>   
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">ISBN<span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_isbn" id="bk_isbn" placeholder="Enter the Book ISBN" title="Enter The Book ISBN" autocomplete="off" onKeyPress="return isCapitalNumericNoSpace(event);"  oninput="this.setCustomValidity('')" value="<?php echo $bk_isbn; ?>">
                                    </div>
                                </div>  								
                            </div>
                            <div class="col-md-6">
								<div class="form-group">
                                 <label class="col-sm-4 col-form-label">Publication Year <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bk_yrpub" id="bk_yrpub" title="Select the Publication Year" required oninvalid="this.setCustomValidity('Please select the Publication Year...!')" onchange="this.setCustomValidity('')">
                                         <option value="">Select Year</option>
                                          <?php for($i=1950; $i<=2050; $i++) { ?>
                                              <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                          <?php } ?>
                                        </select>
                                        <script>document.thisForm.bk_yrpub.value = "<?php echo $bk_yrpub ; ?>"</script>
                                    </div>
								</div>
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Edition<span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_edition" id="bk_edition" placeholder="Enter the Book Edition" title="Enter The Book Edition" autocomplete="off" oninput="this.setCustomValidity('')" value="<?php echo $bk_edition; ?>">
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Price<span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_price" id="bk_price" placeholder="Enter the Book Price" title="Enter The Book Price" autocomplete="off" autofocus="autofocus" onKeyPress="return isCapitalNumericNoSpace(event);" oninput="this.setCustomValidity('')" value="<?php echo $bk_edition; ?>">
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Book Pages<span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control" name="bk_pages" id="bk_pages" placeholder="Enter the Book Pages" title="Enter The Book Pages" autocomplete="off" oninput="this.setCustomValidity('')" value="<?php echo $bk_pages; ?>">
                                    </div>
                                </div>     								
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Publication <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bk_publication" id="bk_publication" title="Select the Location" required oninvalid="this.setCustomValidity('Please select the Location...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <?php
                                                echo $dbcon->fnFillComboFromTable_Where("id", "lib_pub_name", "lib_publisher", "lib_pub_name", " WHERE del_status = 0");
                                            ?>
                                        </select>
                                        <script>document.thisForm.bk_publication.value = "<?php echo $bk_publication; ?>"</script>
                                    </div>
                                </div> 
                                <div class="form-group">
                                <label class="col-sm-4 col-form-label">Department <span class="err">*</span></label>
								 <div class="col-sm-8">
                                <select class="form-control select2" name="bk_department" id="bk_department" title="Select the Department" required oninvalid="this.setCustomValidity('Please select the department...!')" onchange="this.setCustomValidity('')">
                                    <option value=""></option>
                                    <?php
                                        echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_department", "dname", " WHERE del_status = 0");
                                    ?>
                                </select>
                                <script>document.thisForm.bk_department.value = "<?php echo $bk_department; ?>"</script>
                            </div>
							</div>
                            <div class="form-group">
                                <label class="col-sm-4 col-form-label">Subject <span class="err">*</span></label>
								<div class="col-sm-8">
                                <select class="form-control select2" name="bk_subject" id="bk_subject" title="Select the Subject" required oninvalid="this.setCustomValidity('Please select the ...!')" onchange="this.setCustomValidity('')">
                                    <option value=""></option>Subject
                                    <?php
                                        echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_department", "dname", " WHERE del_status = 0");
                                    ?>
                                </select>
                                <script>document.thisForm.bk_subject.value = "<?php echo $bk_subject; ?>"</script>
                            </div>
                             </div>	
                             <div class="form-group">
                                    <label class="col-sm-4 col-form-label">KeyWord <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bk_keyword" id="bk_keyword" title="Select the KeyWord" required oninvalid="this.setCustomValidity('Please select the KeyWord...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <option value="1">Text Book</option>
                                            <option value="2">Naval</option>
											<option value="3">Story</option>
											<option value="4">Devotional</option>
											<option value="4">Motivational</option>
                                        </select>
                                        <script>document.thisForm.bk_keyword.value = "<?php echo $bk_keyword; ?>"</script>
                                    </div>
                                </div>							 
                                <div class="form-group">
                                    <label class="col-sm-4 col-form-label">Location <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bk_location" id="bk_location" title="Select the Location" required oninvalid="this.setCustomValidity('Please select the Location...!')" onchange="this.setCustomValidity('')">
                                            
                                            <?php
                                                echo $dbcon->fnFillComboFromTable_Where("id", "lib_location_name", "lib_location", "lib_location_name", " WHERE del_status = 0");
                                            ?>
                                        </select>
                                        <script>document.thisForm.bk_location.value = "<?php echo $bk_location; ?>"</script>
                                    </div>
                                </div>
								<div class="form-group">
                                    <label class="col-sm-4 col-form-label">Status <span class="err">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control select2" name="bk_status" id="bk_status" title="Select the Language" required oninvalid="this.setCustomValidity('Please select the Language...!')" onchange="this.setCustomValidity('')">
                                            <option value=""></option>
                                            <option value="1">Available</option>
                                            <option value="2">Issued</option>
											<option value="3">Not Available</option>
                                        </select>
                                        <script>document.thisForm.bk_status.value = "<?php echo $bk_status; ?>"</script>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div >
										<label class="col-sm-4 col-form-label">Notes </label> 
										<div class="col-sm-8">									
                                            <textarea class="form-control" name="bk_notes" id="bk_notes" rows="3" oninput="this.setCustomValidity('')"><?php echo $staff_address; ?></textarea>
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