<?php
if(!mysql_connect("mysql8.000webhost.com","a5371847_admin","mysql123"))
{
     die('Connection problem: '.mysql_error());
}
if(!mysql_select_db("a5371847_obits"))
{
     die('Database selection problem: '.mysql_error());
}
?>