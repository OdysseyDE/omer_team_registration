{* Smarty *}

<div class="page-header">
  <h1>##MENU_Beacons## <a href="index.php?page=Beacons&amp;action=Edit" class="btn btn-primary">##BUTTON_Add## <i class="fa fa-plus"></i></a></h1>
</div>

<div class="panel panel-default panel-shadow">
  <div class="panel-body">
    <table id="beacons" class="table table-striped table-hover dt-responsive clickable" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>##LABEL_Kennung##</th>
          <th>##LABEL_Bezeichnung##</th>
        </tr>
      </thead>

      <tbody>
        {foreach $Beacons as $Beacon}
          <tr id="{$Beacon->id}">
            <td>{$Beacon->kennung}</td>
            <td>{$Beacon->name}</td>
          </tr>
        {/foreach}
      </tbody>
    </table>
  </div>
</div>
