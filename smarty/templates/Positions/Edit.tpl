{* Smarty *}

<div class="page-header">
  <h1>##MENU_AddPosition##</h1>
</div>

<div class="panel panel-default panel-shadow">
  <div class="panel-body">
    <form method="post" class="standardValidation">
      <div class="form-group">
        <label class="required" for="beacon">##LABEL_Beacon##:</label>
        <select id="beacon" name="Position[beacon]" class="selectpicker show-tick form-control" data-live-search="true">
          <option value="0">##TXT_ChooseOne##</option>
          {foreach $Beacons as $Beacon}
            <option value="{$Beacon->id}">{$Beacon->__toString()}</option>
          {/foreach}
        </select>
      </div>
      
      <div class="form-group">
        <label class="required" for="client">##LABEL_Client##:</label>
        <select id="client" name="Position[client]" class="selectpicker show-tick form-control" data-live-search="true">
          <option value="0">##TXT_ChooseOne##</option>
          {foreach $Clients as $Client}
            <option value="{$Client->id}">{$Client->__toString()}</option>
          {/foreach}
        </select>
      </div>

      <div class="form-group">
        <label class="required" for="distance">##LABEL_Distance##:</label>
        <select id="distance" name="Position[distance]" class="selectpicker show-tick form-control" data-live-search="true">
          <option value="far">##OPTION_Far##</option>
          <option value="intermediate">##OPTION_Intermediate##</option>
          <option value="near">##OPTION_Near##</option>
        </select>
      </div>

      <div class="form-group">
        <label class="required" for="battery">##LABEL_BatteryInProzent##:</label>
        <input type="text" name="Position[battery]" value="100,00" class="required form-control"/>
      </div>

      <button type="submit" class="btn btn-primary bold">##BUTTON_AddPosition##</button>
    </form>
  </div>
</div>
