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

  	if (isset($_GET["sid"]) && $_GET["sid"] !== "" && isset($_GET["cid"]) && $_GET["cid"] !== "") {
//////////////////////////////////////////////////////////////////////////////////////
	  //Prepare and execute a query to DELETE FROM using GET id in criterion - WHERE MID = ?
		$SID=$_GET["sid"];
        $CID=$_GET["cid"];
	  $query="DELETE FROM Enrollment WHERE StudentID = ? AND CourseID = ?";
	  $stmt = $mysqli->prepare($query);
	  $stmt->execute([$SID, $CID]);



		if ($stmt) {
			//Create SESSION message that Person successfully deleted
			$_SESSION["message"]="Student successfully deleted!";


		}
		else {
			//Create SESSION message that Person could not be deleted
			$_SESSION["message"]="Student could not be deleted :(";

		}

		//************** Redirect to readS21.php
		redirect("readCourses.php?id=".$CID);

//////////////////////////////////////////////////////////////////////////////////////
	}
	else {
		$_SESSION["message"] = "Student could not be found!";
		redirect("readCourses.php?id=".$CID);
	}



//Define footer with the phrase "February 2020 Movies"
//Close database
new_footer("Scheduler");
Database::dbDisconnect($mysqli);
?>
