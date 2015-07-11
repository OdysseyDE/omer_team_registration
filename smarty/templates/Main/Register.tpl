{* Smarty *}

<nav class="navbar navbar-default navbar-fixed-top">
  <div class="container">
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav navbar-right hidden-xs">
        <li>
          <div class="navbar-btn">
            <a href="index.php?action=Index" class="btn btn-orange ">##BUTTON_Login##</a>
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
        <li><a href="index.php?action=Index"><i class="md md-exit-to-app"></i>##BUTTON_Login##</a></li>
      </ul>
    </div>
  </div>
</div>

<div class="col-md-4 col-md-offset-4">
  <div class="signup">
    <div class="logo"><i class="md md-lg md-person-add"></i>&nbsp;##LABEL_Register##</div>
    <div class="panel panel-default panel-shadow">
      <div class="avatar">
        <img src="images/guy.jpg" alt="guy" class="img-circle img-responsive"/>
      </div>
      <form method="post" class="standardValidation">
        <div class="panel-body">
          <input type="text" id="emailRepeat" name="Auth[emailRepeat]" value="{$repeat}" />
          <div class="form-group">
            <label for="email" class="required" >##LABEL_EmailAdresse##</label>
            <input type="email" name="Auth[email]" class="required form-control" id="email" placeholder="##LABEL_EmailAdresse##">
          </div>
          <div class="form-group margin-none">
            <label for="passwort" class="required">##LABEL_Passwort##</label>
            <input type="password" name="Auth[passwort]" class="required form-control" id="passwort" placeholder="##LABEL_Passwort##">
          </div>
        </div>
        <div class="form-group text-center">
          <button type="submit" class="btn btn-success bold">##BUTTON_NutzerAnlegen##</button>
        </div>
      </form>
    </div>
  </div>
</div>
