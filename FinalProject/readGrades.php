<?php
	require_once("session.php");
	require_once("included_functions.php");
	require_once("database.php");

	new_header("Scheduler Transcript");
	$mysqli = Database::dbConnect();
	$mysqli -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

	if (($output = message()) !== null) {
		echo $output;
	}


	//****************  Add Query
	//Select from movie and genre tables - you need all the movie attributes and only the genre type of the highest ranking genre (i.e., rank is 1)
$query = "SELECT StudentID, LName, FName, CourseName, LetterGrade FROM Student NATURAL JOIN Grades NATURAL JOIN Courses ORDER BY LName ASC";

	//  Prepare and execute query
$stmt = $mysqli -> prepare($query);
$stmt -> execute();



	if ($stmt) {
		echo "<div class='row'>";
		echo "<center>";
		echo "<h2>Student Grades</h2>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th></th><th>Last Name</th><th>First Name</th><th>Course Name</th><th>Letter Grade</th><th></th></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//////////// ADD CODE HERE
			// Retrieve information from query results

			echo "<tr>";

			//////////////// ADD CODE HERE
			//Output a red X for the first column, creating a Delete link.  Use URL.php for the href
			echo "<td><a style='color:red' href='deleteS21.php?id=".urlencode($row['StudentID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>";
						//Output Title, Genre, Release Date, and Total Gross
			echo "<td style='text-align:center'>".$row["LName"]."</td>";
			echo "<td style='text-align:center'>".$row["FName"]."</td>";
			echo "<td style='text-align:center'>".$row["CourseName"]."</td>";
			echo "<td style='text-align:center'>".$row["LetterGrade"]."</td>";

			//Output "Edit" (without the quotes), for the last column, creating an Edit link. Use URL.php for the href
			echo "<td><a style='text-align:center' href='updateS21.php?id=".urlencode($row['StudentID'])."'>Edit</a></td>";
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
		/////////////////  ADD CODE HERE
		// Create a link to create.php and call the link "Add a movie"(without the quotes)
		echo "<a href='createS21.php'>Add a record</a>";
		//echo " | ";
		//echo "<a href='addLogin.php'>Add an admin</a>";
		//echo " | ";
		//echo "<a href='logout.php'>Logout</a>";
		echo "</center>";
		echo "</div>";
	}

/************       Uncomment Once Code Completed For This Section  ********************/
	new_footer("February 2020 Scheduler");
	Database::dbDisconnect($mysqli);
 ?>
