{* Smarty *}

<div class="page-header">
  <h1>##MENU_Clients## <a href="index.php?page=Clients&amp;action=Edit" class="btn btn-primary">##BUTTON_Add## <i class="fa fa-plus"></i></a></h1>
</div>

<div class="panel panel-default panel-shadow">
  <div class="panel-body">
    <table id="clients" class="table table-striped table-hover dt-responsive clickable" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>##LABEL_ClientID##</th>
          <th>##LABEL_Bezeichnung##</th>
        </tr>
      </thead>

      <tbody>
        {foreach $Clients as $Client}
          <tr id="{$Client->id}">
            <td>{$Client->clientId}</td>
            <td>{$Client->name}</td>
          </tr>
        {/foreach}
      </tbody>
    </table>
  </div>
</div>
