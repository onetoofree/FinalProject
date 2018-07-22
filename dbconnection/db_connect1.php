<?php

//phpinfo();
//exit;

$dbhost = 'mysql:host=127.0.0.1; dbname=ExperimentalDB';
$dbuser = 'root';
$dbpass = '1234';

$db = new PDO($dbhost, $dbuser, $dbpass);

$db->query("insert into project.user values (3, 'qazzz', 'qazzz@zaq.com', 'qazzz')");

//$result = $db->query("select count(*) from ExperimentalDB.buys");
$result = $db->query("select count(*) from project.user");

$count = $result->fetchColumn(0);

print ("There are $count rows in user.");

$db->query("delete from project.user where userid = 3");



$db = NULL;

?>