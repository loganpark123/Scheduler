<?php

//Add beginning code to
//1. Require the needed 3 files
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");
//2. Connect to your database
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//3. Output a message, if there is one
if (($output = message()) !== null) {
	echo $output;
}

  	if (isset($_GET["id"]) && $_GET["id"] !== "") {
//////////////////////////////////////////////////////////////////////////////////////
	  //Prepare and execute a query to DELETE FROM using GET id in criterion - WHERE MID = ?
		$ID=$_GET["id"];
	  $query="DELETE FROM Assignment WHERE AssignmentID = ?";
	  $stmt = $mysqli->prepare($query);
	  $stmt->execute([$ID]);



		if ($stmt) {
			//Create SESSION message that Person successfully deleted
			$_SESSION["message"]="Assignment successfully deleted!";


		}
		else {
			//Create SESSION message that Person could not be deleted
			$_SESSION["message"]="Assignment could not be deleted :(";

		}

		//************** Redirect to readS21.php
		redirect("home.php");

//////////////////////////////////////////////////////////////////////////////////////
	}
	else {
		$_SESSION["message"] = "Assignment could not be found!";
		redirect("home.php");
	}



//Define footer with the phrase "February 2020 Movies"
//Close database
new_footer("Scheduler");
Database::dbDisconnect($mysqli);
?>
