<?php
ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH . "includes/common/connection.php");
require_once(BASEPATH . "includes/common/dbfunctions.php");
require_once(BASEPATH . "includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

// ini_set('display_errors', '1'); ini_set('display_startup_errors', '1'); error_reporting(E_ALL);

isAdmin();
//$menu_permission = explode('||', $_SESSION["menu_permission"]);

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
                <h3 class="box-title">List</h3>
                <?php
                //if(in_array('createStudents',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="fees_structure.php" class="btn btn-block btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </div>
                <?php
                //}
                ?>
            </div>
            <div class="box-body">

                <div class="box box-solid search" style="background-color: #ECF0F5; height: 88px;">
                    <div class="box-body">
                        <div class="row">

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Search For</label>
                                    <input type="text" class="form-control" name="searchByValue" id="searchByValue" autofocus placeholder="Search by Value">
                                </div>
                            </div>

                            <div class="col-md-3">
                                <div class="form-group">
                                    <label>Search Degree</label>
                                    <select class="form-control select2" name="searchByDegree" id="searchByDegree" title="Select the Degree">
                                        <option value=""></option>
                                        <?php
                                        echo $dbcon->fnFillComboFromTable_Where("id", "dname", "tbl_degree", "dname", " WHERE del_status = 0");
                                        ?>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>

                <form id="thisForm" name="thisForm" action="fees_structure.php" method="post">
                    <div class="table-responsive">
                        <div class="dt-responsive table-responsive">
                            <table id="example1" class="table table-bordered table-striped">
                                <thead>
                                    <tr>
                                        <th width="8">#</th>
                                        <th>Degree</th>
                                        <th width="100" class="text-center">Year</th>
                                        <th width="100" class="text-center">Semester</th>
                                        <th width="100" class="text-center">Total</th>
                                        <th width="60" class="text-center">Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </section>
</div>
<?php include("includes/footer.php"); ?>

<!-- modal -->
<div class="modal fade" id="modal_fs_show" tabindex="-1">
    <!-- modal-dialog -->
    <div class="modal-dialog modal-lg modal-dialog-centered modal-dialog-scrollable">
        <!-- modal-content -->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModal_fs_Head"><b>Default Modal</b></h4>
            </div>
            <div class="modal-body" id="m_fs_details">
                <div class="text-center">
					<span class="spinner-border spinner-border-sm text-danger"></span> Loading
				</div>
            </div>
            <!-- <div class="modal-footer">
                <button type="button" class="btn btn-default pull-left" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary">Save changes</button>
            </div> -->
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<!-- /.modal -->

<script>
$(function() {
    var dataTable = $('#example1').DataTable({
        //$('#example1').DataTable({
        'autoWidth': false,
        'responsive': true,
        'processing': true,
        'serverSide': true,
        'pageLength': 12,
        'searching': false,
        //'scrollY'       : '570px',
        //'scrollCollapse': true,
        //'dom'           : 'Bfrtip',
        'dom': "<'row'<'col-sm-12 d-flex col-md-6'lf><'col-sm-12 col-md-6 text-right'B>>" +
            "<'row'<'col-sm-12'tr>>" +
            "<'row m-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",

        'ajax': {
            'url': 'datatable/FeesStructureList.php',
            'type': 'POST',
            'data': function(data) {
                //alert(data);
                var searchByValue = $('#searchByValue').val();
                var searchByDegree = $('#searchByDegree').val();

                data.searchByValue = searchByValue;
                data.searchByDegree = searchByDegree;
            }
        },

        'columns': [{
                data: 'id'
            },
            {
                data: 'degree_id'
            },
            {
                data: 'fees_year'
            },
            {
                data: 'semester'
            },
            {
                data: 'total_amount'
            },
            {
                data: 'action'
            },
        ],

        rowReorder: true,
        columnDefs: [{
                targets: [0, 2, 3, 5],
                className: 'text-center'
            },
            {
                targets: [4],
                className: 'text-right'
            },
            {
                orderable: true,
                className: 'reorder',
                targets: [0, 1, 2, 3, 4]
            },
            {
                orderable: false,
                targets: '_all'
            }
        ],

        buttons: ['copyHtml5', 'excelHtml5', 'csvHtml5', 'pdfHtml5', 'print']
    });

    $('#searchByValue').keyup(function() {
        dataTable.draw();
    });

    $('#searchByDegree').change(function() {
        dataTable.draw();
    });

    $('#modal_fs_show').on('show.bs.modal', function (e) 
	{
		var id = $(e.relatedTarget).data('id');
        //alert(id);
		if(id !='')
		{
			$.ajax({
				type : 'post',
				url : 'ajax/get_list.php',
                data: {
                    mode: 'modal_fs',
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
});
</script>

<script type="text/javascript">
    $(document).ready(function() {
        $('#masterMainNav').addClass('active');
        $('#masterFeesStructureSubNav').addClass('active');
    });
</script>