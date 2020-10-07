<!-- update the table of statistics of region when manager click select bar to choose different region
    this file will work -->
<?php
include("connect.php");

$region = $_GET["region"];

$sql = "SELECT region, SUM(N95) as sumN95, SUM(sm) as sumSM, SUM(N95m) as sumN95M, (SUM(N95) + SUM(Sm) + SUM(N95m)) as totalNum, SUM(sumprice) as totalRevenues FROM ordering WHERE (region = '$region' and status = 0)";
$result = $conn->query($sql);
$row = $result->fetch_assoc();

$sql = "SELECT COUNT(username) as customerNum FROM customer WHERE region='$region'";
$result7 = $conn->query($sql);
$rows = $result7->fetch_assoc();
$customerNum = $rows['customerNum'];


echo "<table class=\"manager-quota2\" frame=hsides rules=rows cellspacing=10>";
echo "<caption class=\"statistics-total-title\" id=\"quota-caption\">Region statistics</caption>";
echo "<tr class=\"quota-table even\">";
echo "<th>Total N95</th>";
echo "<th>Total Sm</th>";
echo "<th>Total N95m</th>";
echo "<th>Total Number</th>";
echo "<th>Total Revenues</th>";
echo "<th>customer number</th>";
echo "</tr>";
echo "<tr class=\"quota-table odd\">";
echo "<th>".$row['sumN95']."</th>";
echo "<th>".$row['sumSM']."</th>";
echo "<th>".$row['sumN95M']."</th>";
echo "<th>".$row['totalNum']."</th>";
echo "<th>".$row['totalRevenues']."</th>";
echo "<th>".$customerNum."</th>";
echo "</tr>";
echo "</table>";
?>