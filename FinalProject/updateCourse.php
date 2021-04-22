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
		$query = "UPDATE Courses SET CourseName=?,ProfessorID=?,Building=?,RoomNum=?,ZoomLink=? WHERE CourseID=?";
		//Prepare and execute query (use $_POST values from submitted form)
		$stmt = $mysqli->prepare($query);
		$stmt->execute([$_POST["CourseName"], $_POST["ProfessorID"], $_POST["Building"], $_POST["RoomNum"], $_POST["ZoomLink"], $_POST["CourseID"]]);

		//Verify $stmt executed - create a SESSION message using the movie title

///////////////////////////////////////////////////////////////////////////////////////////

		//Output query results and return to readS21.php

		if($stmt) {
			$_SESSION["message"] = $_POST["CourseName"]."'s record has been changed";
		}
		else {
			$_SESSION["message"] = "Error! Could not change ".$_POST["CourseName"];
		}

        redirect("home.php");
	}
	else {
///////////////////////////////////////////////////////////////////////////////////////////
	  //Step 1.
	  if (isset($_GET["id"]) && $_GET["id"] !== "") {
	  //Prepare and execute a query to SELECT * using GET id in criterion - WHERE MID = ?
      $ID = $_GET["id"];
	  $query = "SELECT * FROM Courses WHERE CourseID = ?";
	  $stmt = $mysqli->prepare($query);
	  $stmt->execute([$ID]);



		//Verify statement successfully executed - I assume that results are returned to variable $stmt
		if ($stmt)  {
			//Fetch associative array from executed prepared statement
      		$row = $stmt->fetch(PDO::FETCH_ASSOC);
			//Output the movie we are updating
			//UNCOMMENT ONCE YOU'VE COMPLETED THE FILE
			echo "<h3>".$row["CourseName"]."'s Information</h3>";
      		echo "<form action='updateCourse.php' method='POST'>";
			echo "<p><input type='hidden' name='CourseID' value='{$ID}'> </p>";
			echo "<p>Course Name: <input type='text' name='CourseName' value='{$row["CourseName"]}' </p>";
			echo "<p><p>Professor: </p><select name='ProfessorID'>";
            $stmt1 = $mysqli ->prepare("SELECT CONCAT_WS(', ',LName, FName) AS Name, ProfessorID FROM Professor ORDER BY Name ASC");
						$stmt1->execute();
						while ($row1 = $stmt1->fetch(PDO::FETCH_ASSOC)){
                            if($row1['ProfessorID'] === $row['ProfessorID']){
							echo "<option selected value = '".$row1['ProfessorID']."'>".$row1['Name']."</option>";
                            }else{
                                echo "<option value = '".$row1['ProfessorID']."'>".$row1['Name']."</option>";
                            }
                        }
			
			echo "</select>";
			echo "<p>Building:</p><input type='text' name='Building' value='{$row['Building']}'>";
			echo "<p>Room Number:</p><input type='text' name='RoomNum' value='{$row['RoomNum']}'>";
            if(empty($row['ZoomLink'])){
                $zoom = 'N/A';
            }else{
                $zoom = $row['ZoomLink'];
            }
			echo "<p>Zoom:</p><input type='text' name='ZoomLink' value='$zoom'>";
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
			$_SESSION["message"] = "Course could not be found!";
			redirect("home.php");
		}
	  }
    }
    //$_SESSION["message"] = "This bug is known and under construction. Change professor only";
    echo "</center>";
    echo "</div>";
//Define footer with the phrase "February 2020 Movies"
//Disconnect from database
    new_footer("Scheduler");
	Database::dbDisconnect($mysqli);

?>
