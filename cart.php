<?php include("includes/connection.php");
session_start();
if(isset($_POST['cart'])){
$user_id = $_SESSION['USER_ID'];
    $art_id = $_SESSION['art_id'];
$query="INSERT INTO cart(`user_id`,`art_id`) VALUES ('$user_id','$art_id') ";
if(mysqli_query($conn,$query)){
	header("Location:cart1.php?error= Data entered successfully !");
	exit();
}
else{
	header("Location:cart1.php?error1= Error entering data !");
	exit();
}
}
?>