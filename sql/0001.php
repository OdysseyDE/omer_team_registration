<?php

$db->query('ALTER TABLE users ADD COLUMN role ENUM("admin","user") NOT NULL DEFAULT "user"');

?>
