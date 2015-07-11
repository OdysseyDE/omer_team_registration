{* Smarty *}

{if $message || $errormessage}
  <div class="panel-body">
    {if $message}
      <div class="alert alert-success">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        {$message}
      </div>
    {elseif $errormessage}
      <div class="alert alert-danger">
        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
        <ul>
          {foreach $errormessage as $error}
            <li>{$error}</li>
          {/foreach}
        </ul>
      </div>
    {/if}
  </div>
{/if}
