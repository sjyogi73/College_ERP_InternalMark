<aside class="main-sidebar">
  <section class="sidebar">
    <ul class="sidebar-menu" data-widget="tree">

      <?php //$menu_permission = explode('||', $_SESSION["menu_permission"]); ?>
      <li class="header">MAIN NAVIGATION</li>

      <li><a href="../dashboard.php"><i class="fa fa-dashboard"></i> <span>Dashboard - Main</span></a></li>

      <li id="dashboardMainNav">
        <a href="dashboard.php"><i class="fa fa-book"></i> <span>Dashboard - Library</span></a>
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
         
          <li id="masterBookSubNav"><a href="Books_lst.php">Books</a></li>
         
          <li id="masterLocationSubNav"><a href="Location.php">Location</a></li>
         
          <li id="masterVendorsubNav"><a href="vendors_lst.php">Vendors</a></li>
         
		      <li id="masterPublisherSubNav"><a href="Publisher.php">Publisher</a></li>
        </ul>
      </li>
    </ul>
  </section>
</aside>