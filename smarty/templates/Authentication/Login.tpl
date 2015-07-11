{* Smarty *}

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right hidden-xs">
        <li>
          <div class="navbar-btn">
            <a href="index.php?action=Register" class="btn btn-orange ">##BUTTON_Register##</a>
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
        <li><a href="index.php?action=Register"><i class="md md-exit-to-app"></i>##BUTTON_Register##</a></li>
      </ul>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-md-4 col-md-offset-4">
    <div class="login">
      <div class="logo" href="#">Mannschaftsanmeldung</div>
      <div class="panel panel-default panel-shadow">
      <div class="avatar">
        <img src="images/guy.jpg" alt="guy" class="img-circle img-responsive"/>
      </div>
      <form method="post" class="standardValidation">
        <div class="panel-body">
          <div class="form-group">
            <label for="email">##LABEL_EmailAdresse##</label>
            <input type="email" tabindex="1" class="form-control focused" id="email" name="Login[Username]">
          </div>
          <div class="form-group margin-none">
            <div class="media">
              <div class="media-body media-middle">
                <label for="passwort">##LABEL_Passwort##</label>
              </div>
              <div class="media-right media-middle">
                <a href="#" tabindex="4" class="small pull-right">##LABEL_PasswortVergessen##</a>
              </div>
            </div>
            <input type="password" tabindex="2" class="form-control" id="passwort" name="Login[Password]">
          </div>
        </div>
        <div class="form-group text-center">
          <button type="submit" tabindex="3" class="btn btn-primary">##BUTTON_Login## <i class="md md-lock-open"></i></button>
        </div>
      </form>
    </div>
  </div>
</div>
