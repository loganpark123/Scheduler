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
	if (isset($_GET["id"]) && $_GET["id"] !== "") {
	//Prepare and execute a query to SELECT * using GET id in criterion - WHERE MID = ?
		$ID = $_GET["id"];
		$query = "SELECT CourseID, CourseName FROM Professor NATURAL JOIN Courses WHERE ProfessorID = ? ORDER BY CourseName ASC";

	//  Prepare and execute query
	$stmt = $mysqli -> prepare($query);
	$stmt -> execute([$ID]);
    $query1 = "SELECT CONCAT_WS(', ',LName, FName) AS Name From Professor WHERE ProfessorID = ?";
    $stmt1 = $mysqli -> prepare($query1);
    $stmt1 -> execute([$ID]);
    $row = $stmt1->fetch(PDO::FETCH_ASSOC);
	if ($stmt) {
		echo "<div class='row'>";
		echo "<center>";
		echo "<h2>Courses Taught By ".$row['Name']."</h2>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th>Course Name</th></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//////////// ADD CODE HERE
			// Retrieve information from query results

			echo "<tr>";

			//////////////// ADD CODE HERE
			//Output a red X for the first column, creating a Delete link.  Use URL.php for the href
			
						//Output Title, Genre, Release Date, and Total Gross
			echo "<td style='text-align:center'>".$row["CourseName"]."</td>";
			

			//Output "Edit" (without the quotes), for the last column, creating an Edit link. Use URL.php for the href
			
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
		/////////////////  ADD CODE HERE
		// Create a link to create.php and call the link "Add a movie"(without the quotes)


		echo "<br /><p>&laquo:<a href='home.php'>Back to Main Page</a>";
		echo "</label>";
		//echo " | ";
		//echo "<a href='addLogin.php'>Add an admin</a>";
		//echo " | ";
		//echo "<a href='logout.php'>Logout</a>";
		echo "</center>";
		echo "</div>";
	}
}
/************       Uncomment Once Code Completed For This Section  ********************/
	new_footer("February 2020 Scheduler");
	Database::dbDisconnect($mysqli);
 ?>
