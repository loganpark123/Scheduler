<?php
//Add beginning code to
//1. Require the needed 3 files
//2. Connect to your database
//3. Output a message, if there is one
require_once("session.php");
require_once("included_functions.php");
require_once("database.php");

new_header("Scheduler");
$mysqli = Database::dbConnect();
$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if (($output = message()) !== null) {
	echo $output;
}

	echo "<div class='row'>";
	echo "<center>";
	echo "<h3>Add a Course</h3>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
		if( (isset($_POST["CourseName"]) && $_POST["CourseName"] !== "")
		&&(isset($_POST["ProfessorID"]) && $_POST["ProfessorID"] !== "")
		// &&(isset($_POST["Building"]))
        // &&(isset($_POST["RoomNum"]))
        // &&(isset($_POST["ZoomLink"]))
        ){
				 $COURSENAME = $_POST["CourseName"];
				 $PROFESSORID = $_POST["ProfessorID"];
				 $BUILDING = $_POST["Building"];
                 $ROOMNUM = $_POST["RoomNum"];
                 $ZOOMLINK = $_POST["ZoomLink"];
				//console.log("test");
//////////////////////////////////////////////////////////////////////////////////////////////////
					//STEP 3.
					//Create, prepare and execute query to insert movie information that was posted to the form.  Use $stmt3
					$query1 = "INSERT INTO Courses (CourseName,ProfessorID,Building,RoomNum,ZoomLink) VALUES(?,?,?,?,?)";
					//$query1 = "INSERT INTO movies (Title) VALUES(?)";
						//  Prepare and execute query
					$stmt3 = $mysqli -> prepare($query1);
					$stmt3 -> execute([$COURSENAME,$PROFESSORID,$BUILDING,$ROOMNUM,$ZOOMLINK]);
					if($stmt3){
						$_SESSION["message"] = $COURSENAME." was added!";
						redirect("home.php");
					} else {
						$_SESSION["message"] = "Error! ".$COURSENAME." could not be added";
						redirect("home.php");
					}
					//$stmt3 -> execute([$TITLE]);
					//Verify $stmt3 executed
					//If so, create another query to select from movies to get MID for the title you just inserted.
					//Use $stmt4 to prepare and execute your query
					

					//Redirect back to readS21.php

//////////////////////////////////////////////////////////////////////////////////////////////////


		}
		else {
				$_SESSION["message"] = "Unable to add Course. Fill in all information!";
				redirect("createCourse.php");
		}
	}
	else {
//////////////////////////////////////////////////////////////////////////////////////////////////
					// STEP 1.  Create a form that will post to this page: createS21.php
					//
					//          Include <input> tags for each of the attributes in movie:
					//                  Title, Weekend Gross, Weekend Date, Total Gross, Release Date
					//
					//			Include drop down lists (i.e., <select> tags) for distinct genre types and distinct genre ranks
					//			You MUST query your database. DO NOT Hard code types and ranks
					//
					//			Finally, add a submit button - include the class 'tiny round button'
	?>
					<form method="POST">
					<h2> Enter Course Information </h2>
				  <p>Course Name: </p><input type=text name="CourseName">
				  <p>Professor: </p><select name="ProfessorID">
						<?php
						$stmt1 = $mysqli ->prepare("SELECT CONCAT_WS(', ',LName, FName) AS Name, ProfessorID FROM Professor ORDER BY Name ASC");
						$stmt1->execute();
						while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
							echo "<option value = '".$row['ProfessorID']."'>".$row['Name']."</option>";
						}
						?>
				  </select>
				  <p>Building:</p><input type=text name="Building">
                  <p>Room Number:</p><input type=text name="RoomNum" value=-1>
                  <p>Zoom:</p><input type=text name="ZoomLink" value='N/A'>
				  <p><input type="submit" name="submit" class="button tiny round"/></p>
	    </form>


<?php
//////////////////////////////////////////////////////////////////////////////////////////////////

	}
	echo "</label>";
	echo "</center>";
	echo "</div>";
	echo "<br /><p>&laquo:<a href='home.php'>Back to Main Page</a>";

///////////////////////////////////////////////////////////////////
// STEP 2.
// Define footer with the phrase "February 2020 Movies"
// Disconnect from database
new_footer("Scheduler");
Database::dbDisconnect($mysqli);
 ?>
