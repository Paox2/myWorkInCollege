<!-- when manager choose a range of time to check the statistic, this file will work to update the table -->
<?php
    include("connect.php");

    $start = $_GET["start"];
    $end = $_GET["end"];

    $sql = "SELECT SUM(sumprice) as sumprice, SUM(N95) as N95, SUM(sm) as Sm, SUM(N95m) as N95m, (SUM(N95) + SUM(sm) + SUM(N95m)) as sumNum FROM ordering WHERE ((ordering.time BETWEEN '$start' AND '$end')  and status = 0)";

    $result = $conn->query($sql);
    $row = $result -> num_rows;
    if ($row > 0) {
        $row = $result->fetch_assoc();
        echo "<table class=\"manager-quota\" frame=hsides rules=rows cellspacing=10>";
        echo "<tr class=\"even\">";
        echo "<th>Total N95</th>";
        echo "<th>Total Sm</th>";
        echo "<th>Total N95m</th>";
        echo "<th>Total Number</th>";
        echo "<th>Total Revenues</th>";
        echo "</tr>";
        echo "<tr class=\"odd\">";
        echo "<th>".$row['N95']."</th>";
        echo "<th>".$row['Sm']."</th>";
        echo "<th>".$row['N95m']."</th>";
        echo "<th>".$row['sumNum']."</th>";
        echo "<th>".$row['sumprice']."</th>";
        echo "</tr>";
        echo "</table>";
        echo "<br/><br/><br/>";
    } else {
        echo "<table class=\"manager-quota\" frame=hsides rules=rows cellspacing=10>";
        echo "<tr class=\"even\">";
        echo "<th>Total N95</th>";
        echo "<th>Total Sm</th>";
        echo "<th>Total N95m</th>";
        echo "<th>Total Number</th>";
        echo "<th>Total Revenues</th>";
        echo "</tr>";
        echo "<tr class=\"odd\">";
        echo "<th>0</th>";
        echo "<th>0</th>";
        echo "<th>0</th>";
        echo "<th>0</th>";
        echo "<th>0</th>";
        echo "</tr>";
        echo "</table>";
        echo "<br/><br/><br/>";
    }
?>