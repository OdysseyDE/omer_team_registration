{* Smarty *}

<div class="page-header">
  <h1>{if $Mannschaft->id > 0}##HEADING_EditMannschaft##{else}##HEADING_AddMannschaft##{/if}</h1>
</div>

<div class="panel panel-default panel-shadow">
  <div class="panel-body">
    <form method="post" class="standardValidation">
      <div class="form-group">
        <label class="required" for="name">##LABEL_Name##:</label>
        <input type="text" name="Mannschaft[name]" value="{$Mannschaft->name}" class="required form-control"/>
      </div>
      <div class="form-group">
        <label class="required" for="number">##LABEL_Number##:</label>
        <input type="text" name="Mannschaft[nummer]" value="{$Mannschaft->nummer}" class="required form-control"/>
      </div>
      <div class="form-group">
        <label for="number">##LABEL_Tags##:</label>
        <div class="bootstrap-tagsinput">
          <input type="text" name="Mannschaft[gruppen]" value="{$Mannschaft->gruppen}" data-role="tagsinput tag-default" class="form-control">
        </div>
      </div>
      <button type="submit" class="btn btn-primary bold">##BUTTON_Submit##</button>
    </form>
  </div>
</div>
