<?php include("includes/connection.php");
session_start();
include("functions.php");
$id = $_GET['delete'];
$pic = $_GET['pic'];
$user_id = $_SESSION['USER_ID'];
    $delete ="DELETE FROM cart WHERE art_id = '$id' AND user_id='$user_id' ";
if (mysqli_query($conn, $delete)) {
    echo "Record updated successfully";
    unlink('pictures/arts/'.$pic.'');
} else {
    echo "Error updating record: " . mysqli_error($conn);
}


redirect_to("cart1.php");
?>