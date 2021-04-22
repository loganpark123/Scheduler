<?php

//Add beginning code to
//1. Require the needed 3 files
    require_once("session.php");
	require_once("included_functions.php");
	require_once("database.php");
  new_header("Scheduler");
  echo "<div class='row'>";

//2. Connect to your database
    $mysqli = Database::dbConnect();
    $mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//3. Output a message, if there is one

	if (($output = message()) !== null) {
		echo $output;
	}


  echo "<h3>Update Students</h3>";
	echo "<label for='left-label' class='left inline'>";
echo "<center>";
	if (isset($_POST["submit"])) {
///////////////////////////////////////////////////////////////////////////////////////////
		//Step 2.
		//Create an UPDATE query using anonymous parameters and the criterion WHERE MID = ?
		$query = "UPDATE Assignment SET AssignmentTitle=?,DueDate=? WHERE AssignmentID=?";

		//Prepare and execute query (use $_POST values from submitted form)
		$stmt = $mysqli->prepare($query);
		$stmt->execute([$_POST["AssignmentTitle"], $_POST["DueDate"],$_POST["AssignmentID"]]);

		//Verify $stmt executed - create a SESSION message using the movie title

///////////////////////////////////////////////////////////////////////////////////////////

		//Output query results and return to readS21.php

		if($stmt) {
			$_SESSION["message"] = $_POST["AssignmentTitle"]."'s record has been changed";
		}
		else {
			$_SESSION["message"] = "Error! Could not change ".$_POST["AssignmentTitle"];
		}

        redirect("home.php");
	}
	else {
///////////////////////////////////////////////////////////////////////////////////////////
	  //Step 1.
	  if (isset($_GET["id"]) && $_GET["id"] !== "") {
	  //Prepare and execute a query to SELECT * using GET id in criterion - WHERE MID = ?
      $ID = $_GET["id"];
	  $query = "SELECT * FROM Assignment WHERE AssignmentID = ?";
	  $stmt = $mysqli->prepare($query);
	  $stmt->execute([$ID]);



		//Verify statement successfully executed - I assume that results are returned to variable $stmt
		if ($stmt)  {
			//Fetch associative array from executed prepared statement
      		$row = $stmt->fetch(PDO::FETCH_ASSOC);
			//Output the movie we are updating
			//UNCOMMENT ONCE YOU'VE COMPLETED THE FILE
			echo "<h3>Assignment's Information</h3>";
      		echo "<form action='updateAssignment.php' method='POST'>";
			echo "<p><input type='hidden' name='AssignmentID' value='{$ID}'> </p>";
			echo "<p>Due Date: <input type='date' name='DueDate' value='{$row["DueDate"]}' </p>";
			echo "<p>Assignment Title: <input type='text' name='AssignmentTitle' value='{$row["AssignmentTitle"]}'  </p>";
			echo "<p><input type='submit' name='submit' value='Update' class='button tiny round' </p>";
			echo "</form>";
			//Create form with inputs for each field in table ONLY, pre-populating the values
			//DON'T FORGET your submit button - use class attribute (i.e., class='button tiny round')






///////////////////////////////////////////////////////////////////////////////////////////

			echo "<br /><p>&laquo:<a href='home.php'>Back to Main Page</a>";
			echo "</label>";



		}
		//Query failed. Return to readS21.php and output error
		else {
			$_SESSION["message"] = "Assignment could not be found!";
			redirect("home.php");
		}
	  }
    }
    echo "</center>";
    echo "</div>";
//Define footer with the phrase "February 2020 Movies"
//Disconnect from database
    new_footer("Scheduler");
	Database::dbDisconnect($mysqli);

?>
