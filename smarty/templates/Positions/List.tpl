{* Smarty *}

<div class="page-header">
  <h1>##MENU_Positionen##</h1>
</div>

<div class="panel panel-default panel-shadow">
  <div class="panel-body">
    <table id="positions" class="table table-striped table-hover dt-responsive">
      <thead>
        <tr>
          <th>##LABEL_Beacon##</th>
          <th>##LABEL_Client##</th>
          <th>##LABEL_Distance##</th>
          <th class="text-right">##LABEL_Battery##</th>
          <th class="text-right">##LABEL_Zeitpunkt##</th>
          <th></th>
          <th></th>
        </tr>
      </thead>

      <tbody>
        {foreach $Positions as $Position}
          <tr>
            <td>{$Beacons[$Position->beaconId]->__toString()}</td>
            <td>{$Clients[$Position->clientId]->__toString()}</td>
            <td>{$Position->distance}</td>
            <td class="text-right">{$Position->battery|number_format} %</td>
            <td class="text-right">{$Position->timestamp->format('d.m.Y','H:i:s')}</td>
            <td>{$Position->battery}</td>
            <td>{$Position->timestamp->__toString()}</td>
          </tr>
        {/foreach}
      </tbody>
    </table>
  </div>
</div>
