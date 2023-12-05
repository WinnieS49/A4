<!DOCTYPE html>
<html>
<head>
<style>
table {
  width: 100%;
  border-collapse: collapse;
}

table, td, th {
  border: 1px solid black;
  padding: 5px;
}

th {text-align: left;}
</style>
</head>
<body>

<?php
$q = intval($_GET['q']);

$servername = "localhost";
$username = "root"; //login with root
$password = "";
$dbname = "gamearchive"; //classicmodels.sql

//create connection
$conn = new mysqli($servername, $username, $password, $dbname);

//check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

mysqli_select_db($con,"gamearchive");
$sql="SELECT Title  FROM video_games_2022 WHERE Genre = '".$q."'";
$result = mysqli_query($con,$sql);

echo "<table>
<tr>
<th>Game title</th>

</tr>";
while($row = mysqli_fetch_array($result)) {
  echo "<tr>";
  echo "<td>" . $row['Title'] . "</td>";
  //echo "<td>" . $row['Genre'] . "</td>";
  echo "</tr>";
}
echo "</table>";
mysqli_close($con);
?>
</body>
</html>