<?php

require_once('../php/include/init.php');

$controller = new ApplicationController(isset($_REQUEST['page']) ? $_REQUEST['page'] : null,
                                        isset($_REQUEST['action']) ? $_REQUEST['action'] : null);
$controller->Run();

?>
