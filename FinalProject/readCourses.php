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

    if (isset($_GET["id"]) && $_GET["id"] !== "") {
        //Prepare and execute a query to SELECT * using GET id in criterion - WHERE MID = ?
            $ID = $_GET["id"];
            $query = "SELECT StudentID, CONCAT_WS(', ',LName, FName) AS Name, Email, Year FROM Student NATURAL JOIN Enrollment NATURAL JOIN Courses WHERE CourseID = ? ORDER BY LName ASC";
            $stmt = $mysqli -> prepare($query);
            $stmt -> execute([$ID]);
    }
	//****************  Add Query
	//Select from movie and genre tables - you need all the movie attributes and only the genre type of the highest ranking genre (i.e., rank is 1)




	if ($stmt) {
		echo "<div class='row'>";
		echo "<center>";
		echo "<h2>Students Enrolled</h2>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th></th><th>Name</th><th>Email</th><th>Year</th></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//////////// ADD CODE HERE
			// Retrieve information from query results

			echo "<tr>";

			//////////////// ADD CODE HERE
			//Output a red X for the first column, creating a Delete link.  Use URL.php for the href
			echo "<td><a style='color:red' href='deleteEnrollment.php?sid=".urlencode($row['StudentID'])."&cid=".$ID."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>";
						//Output Title, Genre, Release Date, and Total Gross
			echo "<td><a style='text-align:center' href='readStudents.php?id=".urlencode($row['StudentID'])."'>".$row["Name"]."</td>";
			echo "<td style='text-align:center'>".$row["Email"]."</td>";
			echo "<td style='text-align:center'>".$row["Year"]."</td>";

			//Output "Edit" (without the quotes), for the last column, creating an Edit link. Use URL.php for the href
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
    echo "<a href='createEnrollment.php'>Add a Student</a>";
/////////////////////////////////////////////////////////////////////////////////////////////
$query = "SELECT DueDate, AssignmentTitle, CourseName, MediaTitle FROM Assignment NATURAL JOIN Courses LEFT JOIN Media ON Assignment.MediaID = Media.MediaID WHERE CourseID = ?";

			//  Prepare and execute query
		$stmt = $mysqli -> prepare($query);
		$stmt -> execute([$ID]);
		echo "<h2>Current Assignments</h2>";
		echo "<table>";
		echo "  <thead>";
		echo "    <tr><th></th><th>Due Date</th><th>Assignment</th><th>Course</th><th>Attachments</th><th></th></tr>";
		echo "  </thead>";
		echo "  <tbody>";
		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
			//////////// ADD CODE HERE
			// Retrieve information from query results

			echo "<tr>";

			//////////////// ADD CODE HERE
			//Output a red X for the first column, creating a Delete link.  Use URL.php for the href
			echo "<td><a style='color:red' href='deleteAssignment.php?id=".urlencode($row['AssignmentID'])."' onclick='return confirm(\"Are you sure you want to delete?\");'>X</a></td>";
						//Output Title, Genre, Release Date, and Total Gross
			echo "<td style='text-align:center'>".$row["DueDate"]."</td>";
			echo "<td style='text-align:center'>".$row["AssignmentTitle"]."</td>";
			echo "<td style='text-align:center'>".$row["CourseName"]."</td>";
			echo "<td style='text-align:center'>".$row["MediaTitle"]."</td>";

			//Output "Edit" (without the quotes), for the last column, creating an Edit link. Use URL.php for the href
			echo "<td><a style='text-align:center' href='updateAssignment.php?id=".urlencode($row['AssignmentID'])."'>Edit</a></td>";
			echo "</tr>";
		}
		echo "  </tbody>";
		echo "</table>";
		/////////////////  ADD CODE HERE
		// Create a link to create.php and call the link "Add a movie"(without the quotes)
		echo "<a href='createAssignment.php?id=".$ID."'>Add a record</a>";
    /////////////////////////////////////////////////////////////////////////////////////////////
    $query = "SELECT MaterialName, Link, Store, Cost FROM Materials NATURAL JOIN RequiredMaterials Natural join Courses ORDER BY MaterialName ASC";

      //  Prepare and execute query
    $stmt = $mysqli -> prepare($query);
    $stmt -> execute();
        echo "<h2>Required Materials</h2>";
    		echo "<table>";
    		echo "  <thead>";
    		echo "    <tr><th>Material Name</th><th>Link</th><th>Store</th><th>Cost</th></tr>";
    		echo "  </thead>";
    		echo "  <tbody>";
    		while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    			//////////// ADD CODE HERE
    			// Retrieve information from query results

    			echo "<tr>";

    			//////////////// ADD CODE HERE
    			//Output a red X for the first column, creating a Delete link.  Use URL.php for the href
    			
    						//Output Title, Genre, Release Date, and Total Gross
    			echo "<td style='text-align:center'>".$row["MaterialName"]."</td>";
                echo "<td style='text-align:center'>".$row["Link"]."</td>";
                echo "<td style='text-align:center'>".$row["Store"]."</td>";
                echo "<td style='text-align:center'>".$row["Cost"]."</td>";
    			//Output "Edit" (without the quotes), for the last column, creating an Edit link. Use URL.php for the href
    			
    			echo "</tr>";
    		}
    		echo "  </tbody>";
    		echo "</table>";
        
		/////////////////  ADD CODE HERE
		// Create a link to create.php and call the link "Add a movie"(without the quotes)
		//echo "<a href='createS21.php'>Add a record</a>";
		//echo " | ";
		//echo "<a href='addLogin.php'>Add an admin</a>";
		//echo " | ";
		//echo "<a href='logout.php'>Logout</a>";
        
		echo "</center>";
        echo "<br /><p>&laquo:<a href='home.php'>Back to Main Page</a>";
		echo "</div>";
	}

/************       Uncomment Once Code Completed For This Section  ********************/
	new_footer("Scheduler");
	Database::dbDisconnect($mysqli);
 ?>
