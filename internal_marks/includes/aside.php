<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">
      <?php $menu_permission = explode('||', $_SESSION["menu_permission"]); ?>
      <li class="header">MAIN NAVIGATION</li>

      <li><a href="../dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard - Main</span></a></li>

      <li id="dashboardMainNav">
        <a href="dashboard.php"><i class="fa fa-language"></i> <span>Dashboard - Internal Marks</span></a>
      </li>

      <li class="treeview" id="TransactionMainNav">
        <a href="#">
          <i class="fa fa-desktop"></i>
          <span>Transactions</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">         
          <li id="internalMarks"><a href="internal_marks_lst.php">Internal Marks</a></li>       
          <li id="practicalInternalMarks"><a href="internal_marks_lst.php">Practical Internal Marks</a></li>      
        </ul>
      </li>  
      
      <li class="treeview" id="masterMainNav">
        <a href="#">
          <i class="fa fa-edit"></i>
          <span>Masters</span>
          <span class="pull-right-container">
            <i class="fa fa-angle-left pull-right"></i>
          </span>
        </a>
        <ul class="treeview-menu">         
          <li id="masterCourseMapping"><a href="course_mapping_lst.php">Course Mapping</a></li>    
        </ul>
      </li>  

    </ul>
  </section>
</aside>