<?php
	require_once("session.php");
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Scheduler Home");
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}


	//****************  Add Query
	//Select from movie and genre tables - you need all the movie attributes and only the genre type of the highest ranking genre (i.e., rank is 1)
$query = "SELECT StudentID, CONCAT_WS(', ',LName, FName) AS Name, Email, Year FROM Student ORDER BY LName ASC";

	//  Prepare and execute query
$stmt = $mysqli -> prepare($query);
$stmt -> execute();



	if ($stmt) {
		echo "<div class='row'>";
		echo "<center>";
		echo "<h2>Students</h2>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th></th><th>Name</th><th>Email</th><th>Year</th><th></th></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//////////// ADD CODE HERE
			// Retrieve information from query results

			echo "<tr>";

			//////////////// ADD CODE HERE
			//Output a red X for the first column, creating a Delete link.  Use URL.php for the href
			echo "<td><a style='color:red' href='deleteStudent.php?id=".urlencode($row['StudentID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>";
						//Output Title, Genre, Release Date, and Total Gross
			echo "<td><a style='text-align:center' href='readStudents.php?id=".urlencode($row['StudentID'])."'>".$row["Name"]."</td>";
			echo "<td style='text-align:center'>".$row["Email"]."</td>";
			echo "<td style='text-align:center'>".$row["Year"]."</td>";

			//Output "Edit" (without the quotes), for the last column, creating an Edit link. Use URL.php for the href
			echo "<td><a style='text-align:center' href='updateStudents.php?id=".urlencode($row['StudentID'])."'>Edit</a></td>";
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
    echo "<a href='createStudent.php'>Add a Student</a>";
/////////////////////////////////////////////////////////////////////////////////////////////
$query = "SELECT ProfessorID, CONCAT_WS(', ',LName, FName) AS Name, Email FROM Professor ORDER BY LName ASC";

  //  Prepare and execute query
$stmt = $mysqli -> prepare($query);
$stmt -> execute();
    echo "<h2>Professors</h2>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th></th><th>Last Name</th><th>Email</th><th></th></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//////////// ADD CODE HERE
			// Retrieve information from query results

			echo "<tr>";

			//////////////// ADD CODE HERE
			//Output a red X for the first column, creating a Delete link.  Use URL.php for the href
			echo "<td><a style='color:red' href='deleteProfessor.php?id=".urlencode($row['ProfessorID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>";
						//Output Title, Genre, Release Date, and Total Gross
			echo "<td><a style='text-align:center' href='readProfessors.php?id=".urlencode($row['ProfessorID'])."'>".$row["Name"]."</td>";
			echo "<td style='text-align:center'>".$row["Email"]."</td>";

			//Output "Edit" (without the quotes), for the last column, creating an Edit link. Use URL.php for the href
			echo "<td><a style='text-align:center' href='updateProfessor.php?id=".urlencode($row['ProfessorID'])."'>Edit</a></td>";
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
    echo "<a href='createProfessor.php'>Add a Professor</a>";

    /////////////////////////////////////////////////////////////////////////////////////////////
    $query = "SELECT CourseID, CourseName, CONCAT_WS(', ',LName, FName) AS Name, ProfessorID, Building, RoomNum, ZoomLink FROM Courses NATURAL JOIN Professor ORDER BY CourseName ASC";

      //  Prepare and execute query
    $stmt = $mysqli -> prepare($query);
    $stmt -> execute();
        echo "<h2>Courses</h2>";
    		echo "<table>";
    		echo "  <thead>";
    		echo "    <tr><th></th><th>Course Name</th><th>Professor</th><th>Building</th><th>Room Num</th><th>Zoom</th><th></th></tr>";
    		echo "  </thead>";
    		echo "  <tbody>";
    		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    			//////////// ADD CODE HERE
    			// Retrieve information from query results

    			echo "<tr>";

    			//////////////// ADD CODE HERE
    			//Output a red X for the first column, creating a Delete link.  Use URL.php for the href
    			echo "<td><a style='color:red' href='deleteCourse.php?id=".urlencode($row['CourseID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>";
    						//Output Title, Genre, Release Date, and Total Gross
    			echo "<td><a style='text-align:center' href='readCourses.php?id=".urlencode($row['CourseID'])."'>".$row["CourseName"]."</td>";
    			echo "<td><a style='text-align:center' href='readProfessors.php?id=".urlencode($row['ProfessorID'])."'>".$row["Name"]."</td>";
    			echo "<td style='text-align:center'>".$row["Building"]."</td>";
          echo "<td style='text-align:center'>".$row["RoomNum"]."</td>";
          echo "<td style='text-align:center'>".$row["ZoomLink"]."</td>";
    			//Output "Edit" (without the quotes), for the last column, creating an Edit link. Use URL.php for the href
    			echo "<td><a style='text-align:center' href='updateCourse.php?id=".urlencode($row['CourseID'])."'>Edit</a></td>";
    			echo "</tr>";
    		}
    		echo "  </tbody>";
    		echo "</table>";
        echo "<a href='createCourse.php'>Add a Course</a>";
		/////////////////  ADD CODE HERE
		// Create a link to create.php and call the link "Add a movie"(without the quotes)
		//echo "<a href='createS21.php'>Add a record</a>";
		//echo " | ";
		//echo "<a href='addLogin.php'>Add an admin</a>";
		//echo " | ";
		//echo "<a href='logout.php'>Logout</a>";
		echo "</center>";
		echo "</div>";
	}

/************       Uncomment Once Code Completed For This Section  ********************/
	new_footer("Scheduler");
	Database::dbDisconnect($mysqli);
 ?>
