#!/usr/bin/php
<?php

require_once('../php/include/init.php');
require_once('functions.php');

$db->query("ALTER DATABASE `".$db->databaseName()."` DEFAULT CHARACTER SET utf8 COLLATE utf8_general_ci");

$db->query("CREATE TABLE IF NOT EXISTS ids (
  id INT(11) AUTO_INCREMENT,
  insertTime DATETIME NOT NULL DEFAULT 0,
  modifyTime DATETIME NULL DEFAULT NULL,
  PRIMARY KEY (id)
) ENGINE=InnoDB");

$db->query("CREATE FUNCTION InsertID ( ) 
RETURNS INT(11)
BEGIN
  DECLARE newID INT(11);
  INSERT INTO ids SET insertTime = 0;
  SELECT LAST_INSERT_ID() INTO newID;
  RETURN newID;
END");

$db->query("CREATE PROCEDURE UpdateID ( IN whichID INT ) 
BEGIN
  UPDATE ids SET insertTime = 0 WHERE id = whichID;
END");

$db->query("CREATE TRIGGER `idsInsert` BEFORE INSERT ON `ids`
FOR EACH ROW BEGIN 
  SET NEW.insertTime = now();
  SET NEW.modifyTime = NULL;
END");

$db->query("CREATE TRIGGER `idsUpdate` BEFORE UPDATE ON `ids`
FOR EACH ROW BEGIN 
  SET NEW.modifyTime = now();
  SET NEW.insertTime = OLD.insertTime;
END");

$db->query("CREATE TABLE IF NOT EXISTS _updates (
  id INT(11) NOT NULL,
  filename VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY(id)
) ENGINE = InnoDB");
createTriggers('_updates');

$db->query("CREATE TABLE IF NOT EXISTS users (
  id INT(11) NOT NULL,
  login VARCHAR(255) NOT NULL DEFAULT '',
  email VARCHAR(255) NOT NULL DEFAULT '',
  passwort VARCHAR(255) NOT NULL DEFAULT '',
  PRIMARY KEY(id)
) ENGINE = InnoDB");
createTriggers('users');

?>
