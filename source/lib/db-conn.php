<?php

function db_conn($username,$password,$database,$host)
{
@$conn = mysql_connect($host,$username,$password);
if(!$conn)
die(mysql_error());
$conn_db =mysql_select_db($database,$conn);
if(!$conn_db)
die(mysql_error());
}
?>