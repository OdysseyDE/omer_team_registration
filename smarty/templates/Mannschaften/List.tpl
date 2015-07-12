{* Smarty *}

<div class="page-header">
  <h1>##HEADING_Mannschaften## <a href="index.php?page=Mannschaften&amp;action=Edit" class="btn btn-primary">##BUTTON_Add## <i class="fa fa-plus"></i></a></h1>
</div>


<div class="panel panel-default panel-shadow">
  <div class="panel-body">
    <table id="mannschaften" class="table table-striped table-hover dt-responsive clickable" cellspacing="0" width="100%">
      <thead>
        <tr>
          <th>##LABEL_Name##</th>
          <th>##LABEL_Schule##</th>
          <th>##LABEL_Problem##</th>
          <th>##LABEL_Altersgruppe##</th>
        </tr>
      </thead>
      <tbody>
        {foreach $Mannschaften as $Mannschaft}
          <tr id="{$Mannschaft->id}">
            <td>{$Mannschaft->name}</td>
            <td>{$Mannschaft->schule}</td>
            <td>{$Mannschaft->problem}</td>
            <td>{$Mannschaft->altersgruppe}</td>
          </tr>
        {/foreach}
      </tbody>
    </table>
  </div>
</div>
