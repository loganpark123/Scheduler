<?php
class Database {
  public function __construct() {
    die('Init function error');
  }

  public static function dbConnect() {
	$mysqli = null;
	//try connecting to your database
	try {
    require_once("/home/lsparker/DBparker.php");
    $mysqli = new PDO('mysql:host='.DBHOST.';dbname='.USERNAME, USERNAME, PASSWORD);
    echo "Successful Connection";
  }

	//catch a potential error, if unable to connect
  catch (PDOExeption $e){
    echo "Error!: ". $e->getMessage()."<br />";
	   die ("Could not connect to server ".USERNAME."<br />");


  }

    return $mysqli;
  }

  public static function dbDisconnect() {
    $mysqli = null;
  }
}
?>
