<!DOCTYPE html>
<html>
<head>

	<title>Leaderboard</title>
	<link rel="stylesheet" href="../View/Styles/leaderboard.css">

</head>
<body >
<div class="container">
	<h1 align = "center">Leaderboard</h1>
	<table>
		<thead>
			<tr>
				<th>Player</th>
				<th>High Score</th>
			</tr>
		</thead>
		<tbody>
		<?php

session_start();
// start database connection
$conn = new mysqli("localhost","root","","questtato");

// check the connection
if ($conn->connect_error) {
die("Connection failed: " . $conn->connect_error);
}


// get the score and username from database to order the player using decending order.
$sql = "SELECT username, score FROM players ORDER BY score DESC";
$result = mysqli_query($conn, $sql);

// Check if any rows were returned
if (mysqli_num_rows($result) > 0) {
	// Loop through the rows and display them in the table
	while ($row = mysqli_fetch_assoc($result)) {
		echo "<tr>";
		echo "<td>" . $row["username"] . "</td>";
		echo "<td>" . $row["score"] . "</td>";
		echo "</tr>";
	}
} else {
	echo "<tr><td colspan='2'>No results found.</td></tr>";
}
?>			
		</tbody>
	</table>
			</div>
			</br></br>
			<div class="button"  onclick="window.location.href='welcome.php'">
        		<a href="#">BACK</a>
      		</div>
</body>
</html>
