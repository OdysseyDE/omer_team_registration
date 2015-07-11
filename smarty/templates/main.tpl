{* Smarty *}

<!doctype html>
<html lang="de">
  <head>{include file="Include/head.tpl"}</head>

  <body {if $LoggedIn}$class="sidebar-push"{/if}>
    {if $LoggedIn}{include file="Include/nav.tpl"}{/if}
    <div class="container">
      <div id="main">
        {include file="Include/message.tpl"}
        {include file="$page/$action.tpl"}
        {include file="Include/footer.tpl"}
      </div>
    </div>
    <div class="overlay-disabled"></div>

    {include file="Include/js.tpl"}
  </body>
</html>

