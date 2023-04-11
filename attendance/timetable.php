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

// ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

isAdmin();

?>

<?php include("includes/header.php"); ?>
<?php include("includes/aside.php"); ?>
<div class="content-wrapper">
    <section class="content-header">
        <h1>
            Timetable
        </h1>
        <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-edit"></i> Attendance</a></li>
            <li class="active"> Timetable</li>
        </ol>
    </section>
    <section class="content">
        <div class="box box-primary">
            <div class="box-header with-border">
                <h3 class="box-title">Add</h3>
                <div class="box-tools pull-right">
                    <a href="timetable_lst.php" class="btn btn-block btn-primary"><i class="fa fa-bars" aria-hidden="true"></i></a>
                </div>
            </div>
            <div class="box-body">
                <form id="thisForm" name="thisForm" action="timetable.php" method="post">
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
                                <select class="form-control select2" name="tt_year" id="tt_year" title="Select the Year">
                                    <option value=""></option>
                                    <option value="1">1</option>
                                    <option value="2">2</option>
                                    <option value="3">3</option>
                                </select>
                                <script>
                                    document.thisForm.tt_year.value = "<?php echo $tt_year; ?>"
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
                            <div class="col-md-3">
                                <label class="col-form-label">Staff Name <span class="err">*</span></label>
                                <select class="form-control select2" name="staff_id" id="staff_id" title="Select the Staff">
                                    <option value=""></option>
                                    <option value="All">All Staffs</option>
                                    <?php
                                    echo $dbcon->fnFillComboFromTable_Where("id", "staff_name", "tbl_staffs", "staff_name", " WHERE del_status = 0");
                                    ?>
                                </select>
                                <script>
                                    document.thisForm.staff_id.value = "<?php echo $staff_id; ?>"
                                </script>
                             </div>
                             <div class="col-lg-1" style="padding-top: 24px;">
                                <button class="btn btn-icon btn-success btn_add" type="button" name="btn_add" id="btn_add">Show</button>
                            </div>
                        </div>
                    </div>
                </form>
                <div class="show_tt" id="show_tt">
                    
                </div>
            </div>
        </div>
    </section>
</div>
<?php include("includes/footer.php"); ?>

<!-- modal -->
<div class="modal fade" id="modal_add_tt" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- modal-dialog -->
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <!-- modal-content -->
        <div class="modal-content">
            <form id="thisFrm" name="thisFrm" action="" method="post" onsubmit="return fnValid();">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModal_fs_Head"><b>Default Modal</b></h4>
                </div>
                <div class="modal-body" id="m_fs_details">
                    <div class="text-center">
                        <span class="spinner-border spinner-border-sm text-danger"></span> Loading
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="submit" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Submit</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<!-- modal -->
<div class="modal fade" id="modal_edit_tt" tabindex="-1" role="dialog" aria-hidden="true">
    <!-- modal-dialog -->
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <!-- modal-content -->
        <div class="modal-content">
            <form id="thisFr" name="thisFr" action="" method="post" onsubmit="return fnValid1();">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    <h4 class="modal-title" id="myModal_edit_Head"><b>Default Modal</b></h4>
                </div>
                <div class="modal-body" id="m_edit_details">
                    <div class="text-center">
                        <span class="spinner-border spinner-border-sm text-danger"></span> Loading
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" name="update" class="btn btn-primary"><i class="fa fa-check" aria-hidden="true"></i> Update</button>
                </div>
            </form>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script type="text/javascript">

$(document).on("click", "button.btn_print", function(){
    //alert("Hello Print");
    var degree_id = $('#degree_id').val();
    var tt_year = $("#tt_year").val();
    var semester = $("#semester").val();
    var staff_id = $("#staff_id").val();

    window.open("print_pdf.php?d="+ degree_id +"&y="+ tt_year +"&s="+ semester +"&st="+staff_id, "_blank");

    //var divToPrint=document.getElementById("time_table");
    //newWin= window.open("");
    //newWin.document.write(divToPrint.outerHTML);
    //newWin.print();
    //newWin.close();
});

$('#btn_add').click(function(){
    if(document.thisForm.degree_id.value == ""){ 
        swal({
            title: "Please select the degree..!",
            //text: "Please select the degree..!",
            closeModal: false,
        },
        function(){
            $('#degree_id').select2('open');
        });
        return false; 
    }

	if(document.thisForm.tt_year.value == ""){
        swal({
            title: "Please select the year..!",
            //text: "Please select the degree..!",
            closeModal: false,
        },
        function(){
            $('#tt_year').select2('open');
        });        
        return false; 
    }

    if(document.thisForm.semester.value == ""){ 
        swal({
            title: "Please select the semester..!",
            //text: "Please select the degree..!",
            closeModal: false,
        },
        function(){
            $('#semester').select2('open');
        });
        return false; 
    }

    if(document.thisForm.staff_id.value == ""){ 
        swal({
            title: "Please select the staff name..!",
            //text: "Please select the degree..!",
            closeModal: false,
        },
        function(){
            $('#staff_id').select2('open');
        });
        return false; 
    }
    
    var degree_id = $("#degree_id").val();
    var tt_year = $("#tt_year").val();
    var semester = $("#semester").val();
    var staff_id = $("#staff_id").val();
    
    $.ajax({
        type: "POST",
        url: "ajax/get_timetable.php",
        data: {
            mode: 'get_tt',
            degree_id: degree_id,
            tt_year: tt_year,
            semester: semester,
            staff_id: staff_id,
        }
    }).done(function(msg) {
        //alert(msg);
        $('#show_tt').html('');
        $('#show_tt').append(msg);

        if(staff_id == "All") $('.tt').hide();
    });
});

$('#modal_add_tt').on('show.bs.modal', function (e){
    var id = $(e.relatedTarget).data('id');
    //alert(id);
    if(id !='')
    {
        $.ajax({
            type : 'post',
            url : 'ajax/get_list.php',
            data: {
                mode: 'modal_add_tt',
                id: id,
            },
            success : function(data){				
                //Show fetched data from database
                data_arr = data.split("~");
                //alert(data);
                $('#m_fs_details').html(data_arr[0]);
                $('#myModal_fs_Head').html(data_arr[1]);
            }
        });
    }
});

$('#modal_edit_tt').on('show.bs.modal', function (e){
    var id = $(e.relatedTarget).data('id');
    //alert(id);
    if(id !='')
    {
        $.ajax({
            type : 'post',
            url : 'ajax/get_list.php',
            data: {
                mode: 'modal_edit_tt',
                id: id,
            },
            success : function(data){				
                //Show fetched data from database
                data_arr = data.split("~");
                //alert(data);
                $('#m_edit_details').html(data_arr[0]);
                $('#myModal_edit_Head').html(data_arr[1]);
            }
        });
    }
});

//------------------ This is for Select2 in modal popup --------------------
$('body').on('shown.bs.modal', '.modal', function() {
    $(this).find('select').each(function() {
        var dropdownParent = $(document.body);
        if ($(this).parents('.modal.in:first').length !== 0)
            dropdownParent = $(this).parents('.modal.in:first');
        $(this).select2({
            placeholder: 'Select the Options',
            allowClear: true,
            dropdownParent: dropdownParent
        });
    });
});
//------------------ This is for Select2 in modal popup --------------------
//--------------------------------------------------------------------------------------------------- Delete Process -------------
$('#show_tt').on('click', 'a.delete', function(e) {
    e.preventDefault();
    var id = $(this).attr('rel');
    //alert(id);
    if(id !='')
    {
        swal({
            title:"Are you sure? You want delete this..!",
            type: "warning",
            showCancelButton: true,
            confirmButtonClass: 'btn btn-success',
            cancelButtonClass: 'btn btn-danger',
            buttonsStyling: false,
            confirmButtonText: "Delete",
            cancelButtonText: "Cancel",
            closeOnConfirm: false,
            showLoaderOnConfirm: true,
        },function(isConfirm){
            if(isConfirm){
                $.ajax({
                    type: 'post',
                    url: 'ajax/get_list.php',
                    data: {
                        mode: 'modal_del_tt',
                        id: id,
                    },
                    success: function(response){
                        var dataArr = response.split("^");
                        //window.location.href = base_url + resp;
                        //alert(dataArr[2]);
                        if(dataArr[1] == '1-1'){ $("#tt1-1").html("-Nil-"); $("#t1-1").html(dataArr[2]); }
                        if(dataArr[1] == '1-2'){ $("#tt1-2").html("-Nil-"); $("#t1-2").html(dataArr[2]); }
                        if(dataArr[1] == '1-3'){ $("#tt1-3").html("-Nil-"); $("#t1-3").html(dataArr[2]); }
                        if(dataArr[1] == '1-4'){ $("#tt1-4").html("-Nil-"); $("#t1-4").html(dataArr[2]); }
                        if(dataArr[1] == '1-5'){ $("#tt1-5").html("-Nil-"); $("#t1-5").html(dataArr[2]); }
                        if(dataArr[1] == '1-6'){ $("#tt1-6").html("-Nil-"); $("#t1-6").html(dataArr[2]); }
                        if(dataArr[1] == '2-1'){ $("#tt2-1").html("-Nil-"); $("#t2-1").html(dataArr[2]); }
                        if(dataArr[1] == '2-2'){ $("#tt2-2").html("-Nil-"); $("#t2-2").html(dataArr[2]); }
                        if(dataArr[1] == '2-3'){ $("#tt2-3").html("-Nil-"); $("#t2-3").html(dataArr[2]); }
                        if(dataArr[1] == '2-4'){ $("#tt2-4").html("-Nil-"); $("#t2-4").html(dataArr[2]); }
                        if(dataArr[1] == '2-5'){ $("#tt2-5").html("-Nil-"); $("#t2-5").html(dataArr[2]); }
                        if(dataArr[1] == '2-6'){ $("#tt2-6").html("-Nil-"); $("#t2-6").html(dataArr[2]); }
                        if(dataArr[1] == '3-1'){ $("#tt3-1").html("-Nil-"); $("#t3-1").html(dataArr[2]); }
                        if(dataArr[1] == '3-2'){ $("#tt3-2").html("-Nil-"); $("#t3-2").html(dataArr[2]); }
                        if(dataArr[1] == '3-3'){ $("#tt3-3").html("-Nil-"); $("#t3-3").html(dataArr[2]); }
                        if(dataArr[1] == '3-4'){ $("#tt3-4").html("-Nil-"); $("#t3-4").html(dataArr[2]); }
                        if(dataArr[1] == '3-5'){ $("#tt3-5").html("-Nil-"); $("#t3-5").html(dataArr[2]); }
                        if(dataArr[1] == '3-6'){ $("#tt3-6").html("-Nil-"); $("#t3-6").html(dataArr[2]); }
                        if(dataArr[1] == '4-1'){ $("#tt4-1").html("-Nil-"); $("#t4-1").html(dataArr[2]); }
                        if(dataArr[1] == '4-2'){ $("#tt4-2").html("-Nil-"); $("#t4-2").html(dataArr[2]); }
                        if(dataArr[1] == '4-3'){ $("#tt4-3").html("-Nil-"); $("#t4-3").html(dataArr[2]); }
                        if(dataArr[1] == '4-4'){ $("#tt4-4").html("-Nil-"); $("#t4-4").html(dataArr[2]); }
                        if(dataArr[1] == '4-5'){ $("#tt4-5").html("-Nil-"); $("#t4-5").html(dataArr[2]); }
                        if(dataArr[1] == '4-6'){ $("#tt4-6").html("-Nil-"); $("#t4-6").html(dataArr[2]); }
                        if(dataArr[1] == '5-1'){ $("#tt5-1").html("-Nil-"); $("#t5-1").html(dataArr[2]); }
                        if(dataArr[1] == '5-2'){ $("#tt5-2").html("-Nil-"); $("#t5-2").html(dataArr[2]); }
                        if(dataArr[1] == '5-3'){ $("#tt5-3").html("-Nil-"); $("#t5-3").html(dataArr[2]); }
                        if(dataArr[1] == '5-4'){ $("#tt5-4").html("-Nil-"); $("#t5-4").html(dataArr[2]); }
                        if(dataArr[1] == '5-5'){ $("#tt5-5").html("-Nil-"); $("#t5-5").html(dataArr[2]); }
                        if(dataArr[1] == '5-6'){ $("#tt5-6").html("-Nil-"); $("#t5-6").html(dataArr[2]); }
                        if(dataArr[1] == '6-1'){ $("#tt6-1").html("-Nil-"); $("#t6-1").html(dataArr[2]); }
                        if(dataArr[1] == '6-2'){ $("#tt6-2").html("-Nil-"); $("#t6-2").html(dataArr[2]); }
                        if(dataArr[1] == '6-3'){ $("#tt6-3").html("-Nil-"); $("#t6-3").html(dataArr[2]); }
                        if(dataArr[1] == '6-4'){ $("#tt6-4").html("-Nil-"); $("#t6-4").html(dataArr[2]); }
                        if(dataArr[1] == '6-5'){ $("#tt6-5").html("-Nil-"); $("#t6-5").html(dataArr[2]); }
                        if(dataArr[1] == '6-6'){ $("#tt6-6").html("-Nil-"); $("#t6-6").html(dataArr[2]); }

                        swal({
                            title: "Course Deleted Successfully",
                            closeModal: false,
                        });
                    }
                });
            }
        });
    }
});
//--------------------------------------------------------------------------------------------------- Delete Process -------------

$(document).on('change', '#course_id', function() {
    var course_id = $(this).val();

    if (course_id > 0) {
        $.ajax({
            type: "POST",
            url: "ajax/get_list.php",
            data: {
                mode: 'course_id',
                course_id: course_id,
            }
        }).done(function(msg) {
            //alert(msg);
            //data_arr = msg.split("~");
            $('#course_type').val(parseInt(msg)).trigger('change');
        });
    }
});

function fnValid(){
    if(document.thisFrm.course_id.value == ""){ 
        swal({
            title: "Please select the course name..!",
            //text: "Please select the course name..!",
            closeModal: false,
        },
        function(){
            $('#course_id').select2('open');
        });
        return false; 
    }

    if(document.thisFrm.course_type.value == ""){ 
        swal({
            title: "Please select the course type..!",
            //text: "Please select the course name..!",
            closeModal: false,
        },
        function(){
            $('#course_type').select2('open');
        });
        return false; 
    }

    $.ajax({
		type: "POST",
		url: "ajax/get_list.php?mode=save_tt",
		cache: false,
		data: $('form#thisFrm').serialize(),
		success: function(response){
            //alert(response);
            var data = response.split("^");
            if(data[1]==1)
			{
                //alert(data[1]+" Hai");
                //$('form#thisFrm')[0].reset();
                $('#modal_add_tt').modal('hide');

                //alert(data[2]);
                if(data[2] == '1-1'){ $("#tt1-1").html(data[3]); $("#t1-1").html(data[4]); }
                if(data[2] == '1-2'){ $("#tt1-2").html(data[3]); $("#t1-2").html(data[4]); }
                if(data[2] == '1-3'){ $("#tt1-3").html(data[3]); $("#t1-3").html(data[4]); }
                if(data[2] == '1-4'){ $("#tt1-4").html(data[3]); $("#t1-4").html(data[4]); }
                if(data[2] == '1-5'){ $("#tt1-5").html(data[3]); $("#t1-5").html(data[4]); }
                if(data[2] == '1-6'){ $("#tt1-6").html(data[3]); $("#t1-6").html(data[4]); }
                if(data[2] == '2-1'){ $("#tt2-1").html(data[3]); $("#t2-1").html(data[4]); }
                if(data[2] == '2-2'){ $("#tt2-2").html(data[3]); $("#t2-2").html(data[4]); }
                if(data[2] == '2-3'){ $("#tt2-3").html(data[3]); $("#t2-3").html(data[4]); }
                if(data[2] == '2-4'){ $("#tt2-4").html(data[3]); $("#t2-4").html(data[4]); }
                if(data[2] == '2-5'){ $("#tt2-5").html(data[3]); $("#t2-5").html(data[4]); }
                if(data[2] == '2-6'){ $("#tt2-6").html(data[3]); $("#t2-6").html(data[4]); }
                if(data[2] == '3-1'){ $("#tt3-1").html(data[3]); $("#t3-1").html(data[4]); }
                if(data[2] == '3-2'){ $("#tt3-2").html(data[3]); $("#t3-2").html(data[4]); }
                if(data[2] == '3-3'){ $("#tt3-3").html(data[3]); $("#t3-3").html(data[4]); }
                if(data[2] == '3-4'){ $("#tt3-4").html(data[3]); $("#t3-4").html(data[4]); }
                if(data[2] == '3-5'){ $("#tt3-5").html(data[3]); $("#t3-5").html(data[4]); }
                if(data[2] == '3-6'){ $("#tt3-6").html(data[3]); $("#t3-6").html(data[4]); }
                if(data[2] == '4-1'){ $("#tt4-1").html(data[3]); $("#t4-1").html(data[4]); }
                if(data[2] == '4-2'){ $("#tt4-2").html(data[3]); $("#t4-2").html(data[4]); }
                if(data[2] == '4-3'){ $("#tt4-3").html(data[3]); $("#t4-3").html(data[4]); }
                if(data[2] == '4-4'){ $("#tt4-4").html(data[3]); $("#t4-4").html(data[4]); }
                if(data[2] == '4-5'){ $("#tt4-5").html(data[3]); $("#t4-5").html(data[4]); }
                if(data[2] == '4-6'){ $("#tt4-6").html(data[3]); $("#t4-6").html(data[4]); }
                if(data[2] == '5-1'){ $("#tt5-1").html(data[3]); $("#t5-1").html(data[4]); }
                if(data[2] == '5-2'){ $("#tt5-2").html(data[3]); $("#t5-2").html(data[4]); }
                if(data[2] == '5-3'){ $("#tt5-3").html(data[3]); $("#t5-3").html(data[4]); }
                if(data[2] == '5-4'){ $("#tt5-4").html(data[3]); $("#t5-4").html(data[4]); }
                if(data[2] == '5-5'){ $("#tt5-5").html(data[3]); $("#t5-5").html(data[4]); }
                if(data[2] == '5-6'){ $("#tt5-6").html(data[3]); $("#t5-6").html(data[4]); }
                if(data[2] == '6-1'){ $("#tt6-1").html(data[3]); $("#t6-1").html(data[4]); }
                if(data[2] == '6-2'){ $("#tt6-2").html(data[3]); $("#t6-2").html(data[4]); }
                if(data[2] == '6-3'){ $("#tt6-3").html(data[3]); $("#t6-3").html(data[4]); }
                if(data[2] == '6-4'){ $("#tt6-4").html(data[3]); $("#t6-4").html(data[4]); }
                if(data[2] == '6-5'){ $("#tt6-5").html(data[3]); $("#t6-5").html(data[4]); }
                if(data[2] == '6-6'){ $("#tt6-6").html(data[3]); $("#t6-6").html(data[4]); }

                swal({
                    title: "Course Added Successfully",
                    closeModal: false,
                });
            }
            else{
                swal({
                    title: "This is already exists..!",
                    closeModal: false,
                });
            }
		},
		error: function(){
			swal({
                title: "Error",
                closeModal: false,
            });
		}
	});

    return false;
}

function fnValid1(){
    if(document.thisFr.course_id.value == ""){ 
        swal({
            title: "Please select the course name..!",
            //text: "Please select the course name..!",
            closeModal: false,
        },
        function(){
            $('#course_id').select2('open');
        });
        return false; 
    }

    if(document.thisFr.course_type.value == ""){ 
        swal({
            title: "Please select the course type..!",
            //text: "Please select the course name..!",
            closeModal: false,
        },
        function(){
            $('#course_type').select2('open');
        });
        return false; 
    }

    $.ajax({
		type: "POST",
		url: "ajax/get_list.php?mode=edit_tt",
		cache: false,
		data: $('form#thisFr').serialize(),
		success: function(response){
            //alert(response);
            var data = response.split("^");
            if(data[1]==1)
			{
                //alert(data[1]+" Hai");
                //$('form#thisFrm')[0].reset();
                $('#modal_edit_tt').modal('hide');

                var dataArr = data[2].split('~');
                //alert(dataArr[1]);
                if(dataArr[0] == '1-1') $("#tt1-1").html(dataArr[1]);
                if(dataArr[0] == '1-2') $("#tt1-2").html(dataArr[1]);
                if(dataArr[0] == '1-3') $("#tt1-3").html(dataArr[1]);
                if(dataArr[0] == '1-4') $("#tt1-4").html(dataArr[1]);
                if(dataArr[0] == '1-5') $("#tt1-5").html(dataArr[1]);
                if(dataArr[0] == '1-6') $("#tt1-6").html(dataArr[1]);
                if(dataArr[0] == '2-1') $("#tt2-1").html(dataArr[1]);
                if(dataArr[0] == '2-2') $("#tt2-2").html(dataArr[1]);
                if(dataArr[0] == '2-3') $("#tt2-3").html(dataArr[1]);
                if(dataArr[0] == '2-4') $("#tt2-4").html(dataArr[1]);
                if(dataArr[0] == '2-5') $("#tt2-5").html(dataArr[1]);
                if(dataArr[0] == '2-6') $("#tt2-6").html(dataArr[1]);
                if(dataArr[0] == '3-1') $("#tt3-1").html(dataArr[1]);
                if(dataArr[0] == '3-2') $("#tt3-2").html(dataArr[1]);
                if(dataArr[0] == '3-3') $("#tt3-3").html(dataArr[1]);
                if(dataArr[0] == '3-4') $("#tt3-4").html(dataArr[1]);
                if(dataArr[0] == '3-5') $("#tt3-5").html(dataArr[1]);
                if(dataArr[0] == '3-6') $("#tt3-6").html(dataArr[1]);
                if(dataArr[0] == '4-1') $("#tt4-1").html(dataArr[1]);
                if(dataArr[0] == '4-2') $("#tt4-2").html(dataArr[1]);
                if(dataArr[0] == '4-3') $("#tt4-3").html(dataArr[1]);
                if(dataArr[0] == '4-4') $("#tt4-4").html(dataArr[1]);
                if(dataArr[0] == '4-5') $("#tt4-5").html(dataArr[1]);
                if(dataArr[0] == '4-6') $("#tt4-6").html(dataArr[1]);
                if(dataArr[0] == '5-1') $("#tt5-1").html(dataArr[1]);
                if(dataArr[0] == '5-2') $("#tt5-2").html(dataArr[1]);
                if(dataArr[0] == '5-3') $("#tt5-3").html(dataArr[1]);
                if(dataArr[0] == '5-4') $("#tt5-4").html(dataArr[1]);
                if(dataArr[0] == '5-5') $("#tt5-5").html(dataArr[1]);
                if(dataArr[0] == '5-6') $("#tt5-6").html(dataArr[1]);
                if(dataArr[0] == '6-1') $("#tt6-1").html(dataArr[1]);
                if(dataArr[0] == '6-2') $("#tt6-2").html(dataArr[1]);
                if(dataArr[0] == '6-3') $("#tt6-3").html(dataArr[1]);
                if(dataArr[0] == '6-4') $("#tt6-4").html(dataArr[1]);
                if(dataArr[0] == '6-5') $("#tt6-5").html(dataArr[1]);
                if(dataArr[0] == '6-6') $("#tt6-6").html(dataArr[1]);

                swal({
                    title: "Course Updated Successfully",
                    closeModal: false,
                });
            }
            else{
                swal({
                    title: "This is already exists..!",
                    closeModal: false,
                });
            }
		},
		error: function(){
			swal({
                title: "Error",
                closeModal: false,
            });
		}
	});

    return false;
}
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterTimetableSubNav').addClass('active');
});
</script>