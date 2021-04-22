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
	echo "<h3>Add an Assignment</h3>";
	echo "<label for='left-label' class='left inline'>";

	if (isset($_POST["submit"])) {
		if( (isset($_POST["CourseID"]) && $_POST["CourseID"] !== "")
		&&(isset($_POST["LetterGrade"]) && $_POST["LetterGrade"] !== "")
		&&(isset($_POST["NumberGrade"]) && $_POST["NumberGrade"] !== "")){
				 $NUMBERGRADE = $_POST["NumberGrade"];
				 $LETTERGRADE = $_POST["LetterGrade"];
				 $STUDENTID =$_GET["id"];
                 //$_SESSION["message"] = $COURSEID." was added!";
                 $COURSEID = $_POST["CourseID"];
				//console.log("test");
//////////////////////////////////////////////////////////////////////////////////////////////////
					//STEP 3.
					//Create, prepare and execute query to insert movie information that was posted to the form.  Use $stmt3
					$query1 = "INSERT INTO Grades (CourseID,StudentID,LetterGrade,NumberGrade) VALUES(?,?,?,?)";
					//$query1 = "INSERT INTO movies (Title) VALUES(?)";
						//  Prepare and execute query
					$stmt3 = $mysqli -> prepare($query1);
					$stmt3 -> execute([$COURSEID,$STUDENTID,$LETTERGRADE,$NUMBERGRADE]);
					if($stmt3){
						$_SESSION["message"] = "New Grade was added!";
						redirect("readStudents.php?id=".$STUDENTID);
					} else {
						$_SESSION["message"] = "Error! grade could not be added";
						redirect("readStudents.php?id=".$STUDENTID);
					}
					//$stmt3 -> execute([$TITLE]);
					//Verify $stmt3 executed
					//If so, create another query to select from movies to get MID for the title you just inserted.
					//Use $stmt4 to prepare and execute your query
					

					//Redirect back to readS21.php

//////////////////////////////////////////////////////////////////////////////////////////////////


		}
		else {
				$_SESSION["message"] = "Unable to add movie. Fill in all information!";
				redirect("home.php");
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
					<h2> Enter Grade </h2>
                    <p>Course: </p><select name="CourseID">
						<?php
						$stmt1 = $mysqli ->prepare("SELECT CourseName, CourseID FROM Courses ORDER BY CourseName ASC");
						$stmt1->execute();
						while ($row = $stmt1->fetch(PDO::FETCH_ASSOC)){
							echo "<option value = '".$row['CourseID']."'>".$row['CourseName']."</option>";
						}
						?>
				  </select>
				  <p>Letter Grade: </p><input type=text name="LetterGrade">
				  <p>Number Grade: </p><input type=text name="NumberGrade">
				  
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
