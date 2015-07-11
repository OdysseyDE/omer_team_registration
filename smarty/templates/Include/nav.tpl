{* Smarty *}

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle visible-xs collapsed pull-left"  data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <i class="md md-menu"></i>
      </button>
      <a class="navbar-brand" href="index.php">Mannschaftsanmeldung</a>
      <button type="button" class="navbar-toggle pull-right" id="showRightPush">
        <i class="md md-more-vert"></i>
      </button>
    </div>

    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right hidden-xs">
        <li>
          <div class="navbar-btn">
            <a href="index.php?action=Logout" class="btn btn-orange ">##BUTTON_Logout##</a>
          </div>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="sidebar right-side" id="sidebar-right">
  <!-- Wrapper Reqired by Nicescroll -->
  <div class="nicescroll">
    <div class="wrapper">
      <ul class="nav nav-sidebar" id="sidebar-menu">
        <li><a href="index.php?action=Logout"><i class="md md-exit-to-app"></i>##BUTTON_Logout##</a></li>
      </ul>
    </div>
  </div>
</div>
