{* Smarty *}

<div class="page-header">
  <h1>{if $Beacon->id}##HEADING_EditBeacon##{else}##HEADING_AddBeacon##{/if}</h1>
</div>

<div class="panel panel-default panel-shadow">
  <div class="panel-body">
    <form method="post" class="standardValidation">
      <div class="form-group">
        <label class="required" for="name">##LABEL_Kennung##:</label>
        <input type="text" name="Beacon[kennung]" value="{$Beacon->kennung}" class="required form-control"/>
      </div>
      <div class="form-group">
        <label class="required" for="number">##LABEL_Bezeichnung##:</label>
        <input type="text" name="Beacon[name]" value="{$Beacon->name}" class="required form-control"/>
      </div>
      <button type="submit" class="btn btn-primary bold">{if $Beacon->id}##BUTTON_Submit##{else}##BUTTON_AddBeacon##{/if}</button>
    </form>
  </div>
</div>

