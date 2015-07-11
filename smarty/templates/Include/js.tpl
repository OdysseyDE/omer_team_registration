{* Smarty *}

{if $mode == "dev"}
  <script type="text/javascript" src="/js/jquery-2.1.3.js"></script>
  <script type="text/javascript" src="/js/plugins.js"></script>
  <script type="text/javascript" src="/js/jquery-ui.js"></script>
  <script type="text/javascript" src="/js/scripts.js"></script>
  <script type="text/javascript" src="/js/jquery.validate.js"></script>
  <script type="text/javascript" src="/js/language_support/jquery.ui.datepicker-de.js"></script>
  <script type="text/javascript" src="/js/omer_team_registration.js"></script>
{else}
  <script type="text/javascript" src="/dist/omer_team_registration.{$Settings.Version}.js"></script>
{/if}
