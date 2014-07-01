<div id="top">
  <!-- .navbar -->
  <nav class="navbar navbar-inverse navbar-static-top">

    <!-- Brand and toggle get grouped for better mobile display -->
    <header class="navbar-header">
      <!-- <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-ex1-collapse">
        <span class="sr-only">Toggle navigation</span> 
        <span class="icon-bar"></span> 
        <span class="icon-bar"></span> 
        <span class="icon-bar"></span> 
      </button> -->
      <a href="index.html" class="navbar-brand"></a> 
        <a class="logo-header" href="index.html"> Greeking-Solutions </a>
      
    </header>

    <div class="topnav">
      <div class="btn-toolbar">
        <div class="btn-group">
          <a data-placement="bottom" data-original-title="Fullscreen" data-toggle="tooltip" class="btn btn-default btn-sm" id="toggleFullScreen">
            <i class="glyphicon glyphicon-fullscreen"></i>
          </a> 
        </div>
        <div class="btn-group">
          <a data-placement="bottom" data-original-title="Show / Hide Sidebar" data-toggle="tooltip" class="btn btn-success btn-sm" id="changeSidebarPos">
            <i class="fa fa-expand"></i>
          </a> 
        </div>
        <div class="btn-group">
          <a data-toggle="modal" data-original-title="Help" data-placement="bottom" class="btn btn-default btn-sm" href="#helpModal">
            <i class="fa fa-question"></i>
          </a> 
        </div>
        <div class="btn-group">
          <a href="<?php echo base_url('auth/destroy');?>" data-toggle="tooltip" data-original-title="Logout" data-placement="bottom" class="btn btn-metis-1 btn-sm">
            <i class="fa fa-power-off"></i>
          </a> 
        </div>

        <div class="btn-group">
          <a data-original-title="Show/Hide Menu" data-placement="bottom" data-tooltip="tooltip" class="accordion-toggle btn btn-primary btn-sm visible-xs visible-sm" id="menu-toggle">
        <i class="fa fa-bars"></i>
      </a> 
        </div>
      </div>
    </div>
    <!-- /.topnav -->
  </nav>
  <!-- /.navbar -->
</div>
<!-- /#top -->


<div id="left">
  <!-- User box information -->
  <div class="media user-media">
    <div class="user-media-toggleHover">
      <span class="fa fa-user"></span> 
    </div>
    <div class="user-wrapper">
      <a class="user-link" href="">
        <img class="media-object img-thumbnail user-img" alt="User Picture" width="75px" height="75px" src="<?php echo base_url() ?>assets/img/<?php echo $useravatar ?>">
      </a> 
      <div class="media-body">
        <h5 class="media-heading"><?php echo $username ?></h5>
        <ul class="list-unstyled user-info">
          <li> <a href=""><?php echo ucfirst($usergroup) ?></a>  </li>
          <li>Last Login :
            <br>
            <small>
              <i class="fa fa-calendar"></i>&nbsp;<?php echo $userlastlogin ?></small> 
          </li>
        </ul>
      </div>
    </div>
  </div>
  <!-- /#User box information -->

  <!-- #menu -->
  <ul id="menu" class="">
    <li class="nav-divider"></li>
    <li class="nav-header">Menu</li>
    <?php echo $nav ?>
  </ul>
  <!-- /#menu -->
</div>
<!-- /#left -->