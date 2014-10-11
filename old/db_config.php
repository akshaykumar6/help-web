<?php
 
/*
 * All database connection variables
 */
 
define('DB_USER', "root"); // db user
define('DB_PASSWORD', ""); // db password (mention your db password here)
define('DB_DATABASE', "help_app"); // database name
define('DB_SERVER', "localhost"); // db server
echo "in db file";
mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
mysql_select_db(DB_DATABASE);
?>