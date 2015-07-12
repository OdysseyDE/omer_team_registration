{* Smarty *}

<div class="page-header">
  <h1>{if $Mannschaft->id > 0}##HEADING_EditMannschaft##{else}##HEADING_AddMannschaft##{/if}</h1>
</div>

<div class="panel panel-default panel-shadow">
  <div class="panel-body">
    <form method="post" class="standardValidation">
      <div class="form-group">
        <label class="required" for="name">##LABEL_Name##:</label>
        <input type="text" name="Mannschaft[name]" value="{$Mannschaft->name}" class="required form-control" placeholder="##TXT_NameMannschaft##" />
      </div>
      <div class="form-group">
        <label class="required" for="schule">##LABEL_Schule##:</label>
        <input type="text" name="Mannschaft[schule]" value="{$Mannschaft->schule}" class="required form-control"/>
      </div>
      <button type="submit" class="btn btn-primary bold">{if $Mannschaft->id > 0}##BUTTON_Submit##{else}##BUTTON_MannschaftAnmelden##{/if}</button>
    </form>
  </div>
</div>
