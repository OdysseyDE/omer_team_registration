{* Smarty *}

<div class="page-header">
  <h1>{if $Client->id}##HEADING_EditClient##{else}##HEADING_AddClient##{/if}</h1>
</div>

<div class="panel panel-default panel-shadow">
  <div class="panel-body">
    <form method="post" class="standardValidation">
      <div class="form-group">
        <label class="required" for="name">##LABEL_ClientID##:</label>
        <input type="text" name="Client[clientId]" value="{$Client->clientId}" class="required form-control"/>
      </div>
      <div class="form-group">
        <label class="required" for="number">##LABEL_Bezeichnung##:</label>
        <input type="text" name="Client[name]" value="{$Client->name}" class="required form-control"/>
      </div>
      <button type="submit" class="btn btn-primary bold">{if $Client->id}##BUTTON_Submit##{else}##BUTTON_AddClient##{/if}</button>
    </form>
  </div>
</div>

