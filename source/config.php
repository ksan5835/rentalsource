<?php 

define('DB_NAME', 'crs_rental_new');
define('DB_USER', 'root');
define('DB_PASSWORD', '');
define('DB_HOST', 'localhost');
define('BASE_PATH','http://localhost/rentalcrs/');
define('PAGINATE_LIMIT', '5');
define('SERVER_ROOT' , 'E:/rentsource/rentalsource/source');
define('SITE_ROOT' , 'http://localhost/rentalcrs');
define('SITE_NAME' , 'chennairentalsystem.com');
define('TBL_PREFIX' , 'crs_');
define('INVOICE_CURRENCY' , 'Rs. ');


require_once('lib/db-conn.php');
//require_once("lib/dmlib.php");
db_conn(DB_USER,DB_PASSWORD,DB_NAME,DB_HOST);
@session_start();

?>