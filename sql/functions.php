<?php

$db = new Gateway_Base;

function createTriggers ( $table )
{
  global $db;

  $db->query("ALTER TABLE `$table` ADD CONSTRAINT `".strToLower($table)."_id` FOREIGN KEY(id) REFERENCES ids (id) ON UPDATE CASCADE ON DELETE CASCADE");
  $db->query('CREATE TRIGGER `'.$table.'Insert` BEFORE INSERT ON `'.$table.'`
              FOR EACH ROW BEGIN 
                SET NEW.id = InsertID();
              END');
  $db->query('CREATE TRIGGER `'.$table.'Update` BEFORE UPDATE ON `'.$table.'`
              FOR EACH ROW BEGIN 
                CALL UpdateID(NEW.id);
              END');
}

?>
