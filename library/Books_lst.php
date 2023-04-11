<?php
ob_start();
session_start();
define('BASEPATH', '../');

require_once(BASEPATH ."includes/common/connection.php");
require_once(BASEPATH ."includes/common/dbfunctions.php");
require_once(BASEPATH ."includes/common/functions.php");

$con = new connection();
$dbcon = new dbfunctions();

// ini_set('display_errors', '1');
// ini_set('display_startup_errors', '1');
// error_reporting(E_ALL);

isAdmin();
$menu_permission = explode('||', $_SESSION["menu_permission"]);

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
                <h3 class="box-title">List</h3>
                <?php 
                //if(in_array('createStudents',$menu_permission)){
                ?>
                <div class="box-tools pull-right">
                    <a href="Books.php" class="btn btn-block btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i></a>
                </div>
                <?php
                //}
                ?>
        </div>
        <div class="box-body">
                <div class="box box-solid search" style="background-color: #E2F1FF; height: 88px;">
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
                                    <label>Search Book Author</label>
                                    <select class="form-control select2" name="searchByAuthor" id="searchByAuthor" title="Select Book Author">                                       
                                      <option value=""></option>
                                        <?php
                                            echo $dbcon->fnFillComboFromTable_Where("id", "bk_author1", "lib_books", "bk_author1", " WHERE del_status = 0");
                                        ?>
                                    </select>
                                </div>  
                            </div
                        </div>
                    </div>
                </div>
                
                <div class="table-responsive">
                    <div class="dt-responsive table-responsive">
                        <table id="example1" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th width="8">#</th>
                                    <th width="60">Acc No</th>
                                    <th>Title</th>
                                    <th width="200" >Author</th>
                                    <th width="100" >Book No</th>
                                    <th width="100" >Location</th>																		
                                    <th width="70">Status</th>
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
		</div>
		</section>
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
        'dom'           : "<'row'<'col-sm-12 d-flex col-md-6'lf><'col-sm-12 col-md-6 text-right'B>>" +
                            "<'row'<'col-sm-12'tr>>" +
                            "<'row m-2'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
        
        'ajax'          : {
            'url':'datatable/BooksList.php',
            'type':'POST',
            'data': function(data){
                //alert(data);
                var searchByValue = $('#searchByValue').val();
                var searchByAuthor = $('#searchByAuthor').val();
                var searchByBookNo = $('#searchByBookNo').val();

                data.searchByValue = searchByValue;
                data.searchByAuthor = searchByAuthor;
                data.searchByBookNo = searchByBookNo;
            }
        },
        
        'columns'       : [
            { data: 'id' },
            { data: 'bk_acc_no' },
            { data: 'bk_title' },
            { data: 'bk_author1' },
            { data: 'bk_no' },
            { data: 'bk_location' },
            { data: 'action' },
        ],

        rowReorder      : true,
        columnDefs      : [
            {
                targets: [0,1,5,],
                className: 'text-center'
            },

            { 
                orderable: true, 
                className: 'reorder', 
                targets: [0,1,2,3,4,5,6] 
            },
            { 
                orderable: false, 
                targets: '_all' 
            }],

        buttons         : ['copyHtml5','excelHtml5','csvHtml5','pdfHtml5','print']
    });

    $('#searchByValue').keyup(function(){  
        dataTable.draw();
    });

    $('#searchByAuthor').change(function(){  
        dataTable.draw();
    });
    
    $('#searchByBookNo').change(function(){  
        dataTable.draw();
    });
});
</script>

<script type="text/javascript">
$(document).ready(function() {
    $('#masterMainNav').addClass('active');
    $('#masterBooksSubNav').addClass('active');
});
</script>