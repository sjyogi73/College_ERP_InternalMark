<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">

      <?php $menu_permission = explode('||', $_SESSION["menu_permission"]); ?>
      <li class="header">MAIN NAVIGATION</li>

      <li><a href="../dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard - Main</span></a></li>

      <li id="dashboardMainNav">
        <a href="dashboard.php"><i class="fa fa-university"></i> <span>Dashboard - Examination</span></a>
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
          <li id="masterCourseSubNav"><a href="course_lst.php">Course</a></li>
          <li id="masterCourseTypeSubNav"><a href="course_type.php">Course Type</a></li>
        </ul>
      </li>

    </ul>
  </section>
</aside>