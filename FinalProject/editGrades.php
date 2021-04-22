<?php

//Add beginning code to
//1. Require the needed 3 files
    require_once("session.php");
	require_once("included_functions.php");
	require_once("database.php");
  new_header("Top Grossing Movies from February 2020");
  echo "<div class='row'>";

//2. Connect to your database
    $mysqli = Database::dbConnect();
    $mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//3. Output a message, if there is one

	if (($output = message()) !== null) {
		echo $output;
	}


  echo "<h3>Update Grades</h3>";
	echo "<label for='left-label' class='left inline'>";
echo "<center>";
	if (isset($_POST["submit"])) {
///////////////////////////////////////////////////////////////////////////////////////////
		//Step 2.
		//Create an UPDATE query using anonymous parameters and the criterion WHERE MID = ?
		$query = "UPDATE Grades SET LetterGrade=?,NumberGrade=? WHERE CourseID=? AND StudentID=?";

		//Prepare and execute query (use $_POST values from submitted form)
		$stmt = $mysqli->prepare($query);
		$stmt->execute([$_POST["LetterGrade"], $_POST["NumberGrade"], $_POST["CourseID"], $_POST["StudentID"]]);

		//Verify $stmt executed - create a SESSION message using the movie title

///////////////////////////////////////////////////////////////////////////////////////////

		//Output query results and return to readS21.php

		if($stmt) {
			$_SESSION["message"] = $_POST["Title"]." has been changed";
		}
		else {
			$_SESSION["message"] = "Error! Could not change ".$_POST["Title"];
		}

        redirect("home.php");
	}
	else {
///////////////////////////////////////////////////////////////////////////////////////////
	  //Step 1.
	  if (isset($_GET["studentid"]) && $_GET["studentid"] !== "" && isset($_GET["courseid"]) && $_GET["courseid"] !== "") {
	  //Prepare and execute a query to SELECT * using GET id in criterion - WHERE MID = ?
      $SID = $_GET["studentid"];
      $CID = $_GET["courseid"];
	  $query = "SELECT CourseName, LetterGrade, NumberGrade FROM Grades NATURAL JOIN Courses WHERE StudentID = ? && CourseID = ?";
	  $stmt = $mysqli->prepare($query);
	  $stmt->execute([$SID,$CID]);



		//Verify statement successfully executed - I assume that results are returned to variable $stmt
		if ($stmt)  {
			//Fetch associative array from executed prepared statement
      $row = $stmt->fetch(PDO::FETCH_ASSOC);
			//Output the movie we are updating
			//UNCOMMENT ONCE YOU'VE COMPLETED THE FILE
			echo "<h3>".$row["Title"]." Information</h3>";
      echo "<form action='editGrades.php' method='POST'>";
			echo "<p><input type='hidden' name='StudentID' value='{$SID}'> </p>";
			echo "<p><input type='hidden' name='CourseID' value='{$CID}'> </p>";
			echo "<p>Course: <input type='text' name='CourseName' value='{$row["CourseName"]}' </p>";
			echo "<p>Letter Grade: <input type='text' name='LetterGrade' value='{$row["LetterGrade"]}'  </p>";
			echo "<p>Grade: <input type='text'name='NumberGrade' value='{$row["NumberGrade"]}' </p>";
			echo "<p><input type='submit' name='submit' value='Update' class='button tiny round' </p>";
			echo "</form>";
			//Create form with inputs for each field in table ONLY, pre-populating the values
			//DON'T FORGET your submit button - use class attribute (i.e., class='button tiny round')






///////////////////////////////////////////////////////////////////////////////////////////

			echo "<br /><p>&laquo:<a href='readS21.php'>Back to Main Page</a>";
			echo "</label>";



		}
		//Query failed. Return to readS21.php and output error
		else {
			$_SESSION["message"] = "Movie could not be found!";
			redirect("readS21.php");
		}
	  }
    }
    echo "</center>";
    echo "</div>";
//Define footer with the phrase "February 2020 Movies"
//Disconnect from database
    new_footer("February 2020 Movies");
	Database::dbDisconnect($mysqli);

?>
