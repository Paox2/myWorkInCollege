<!-- Deal with the order over the quota and deleted by reps, also, add in quota -->
<?php
        include("connect.php");

        $orderID = $_COOKIE["orderID"];
        
        $sql = "SELECT N95, N95m, sm, repsName FROM ordering WHERE orderID='$orderID'";
        $resultQuota = $conn->query($sql);
        $rows = $resultQuota->fetch_assoc();
        $N95 = $rows['N95']; 
        $N95m = $rows['N95m'];
        $Sm = $rows['sm'];
        $reps = $rows['repsName'];
        
		setcookie("orderID","",time() - 100,'/');
		if($conn->connect_error)
		{
			die("Connection failed: " . $conn->connect_error);
		}
        $sql = "SELECT quotaN95, quotaSm, quotaN95m FROM reps WHERE username = '$reps'";
        $resultQuota = $conn->query($sql);
        $rows = $resultQuota->fetch_assoc();
		$quotaN95 = $rows['quotaN95'];
        $quotaSm = $rows['quotaSm'];
        $quotaN95m = $rows['quotaN95m'];

        $aN95 = $quotaN95 + $N95;
        $aN95m = $quotaN95m + $N95m;
        $aSm = $quotaSm + $Sm;

        $sql = "UPDATE reps SET quotaN95 = '$aN95', quotaSm = '$aSm', quotaN95m = '$aN95m' WHERE username = '$reps'";
        $conn->query($sql);
    
		$sql = "UPDATE ordering SET status = 2 WHERE ordering.orderID = $orderID";
		if($conn->query($sql) === true)
		{
			echo "<script>alert('delete successful');</script>";
			$conn->close();
			header("location:../reps-index.php");
		}
		else
		{
			echo "Error: " . $sql . "<br>" . $conn->error;
		}
		$conn->close();
?>