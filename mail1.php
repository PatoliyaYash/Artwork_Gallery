<?php session_start();
include("includes/connection.php");
include("functions.php");


 $art_id = $_POST['art_id'];
 $user_id = $_POST['user_id'];
$name =$_POST['name'];
$province =$_POST['province'];
$municipal =$_POST['municipal'];
$brgy =$_POST['brgy'];
$street =$_POST['street'];
$zipcode =$_POST['zipcode'];
$contact = $_POST['contact'];
$house_num = $_POST['house_num'];
$area = $_POST['area'];
$brgy = $_POST['brgy'];
$shipping_date = $_POST['shipping_date'];
$art_stock = $_POST['art_stock'];
$ordered_date = "2022-03-03";
$total_price = $_POST['price'];
$payment_status="Paid";

if($_SESSION['cat'] == 'Sculpture'){
    $minus = $_SESSION['items'];
$art_stock = $art_stock - $minus;
}
else{
    $minus = 1;
    $art_stock = $art_stock - $minus;
}

if($art_stock == 0){
    $art_status = 'SOLD';
}
else{
    $art_status = 'AVAILABLE';
}


        $sql="INSERT INTO buy_transaction (art_id,user_id,courier_name,courier_contact,shipping_area,shipping_municipal,shipping_province,shipping_zipcode,shipping_brgy,shipping_street,shipping_house_num,delivery_date,ordered_no,ordered_date,total_price,shipping_status,payment_status) VALUES('$art_id','$user_id','$name','$contact','$area','$municipal','$province','$zipcode','$brgy','$street','$house_num','$shipping_date','$minus','$ordered_date','$total_price','Processing','$payment_status')";

        $sql1 ="UPDATE art_work SET art_status = '$art_status', art_stock = '$art_stock' WHERE art_id = $art_id";

        if (mysqli_query($conn, $sql)) {
} else {
    echo "Error updating record: " . mysqli_error($conn);
}


if (mysqli_query($conn, $sql1)) {
$email=$_POST['email'];
$query1="select * from buy_transaction where TRANSACTION_ID='$transaction_id'";
$result1=mysqli_query($conn,$query1);
$row1=mysqli_fetch_assoc($result1);
//$user_id=$row1['USER_ID'];
$housenum="63";
$street="bhavna";
$area="karelibaug";
$city="Vadodara";
$state="Gujarat";
$zipcode="190022";
$name="Yash";
$query = "
		UPDATE buy_transaction
		SET payment_status = 'Paid'
		WHERE ART_ID = '$art_id'
	";
mysqli_query($conn,$query);
if(!empty($email)){
	$html="Dear, $name thank you for shopping with us. Your order details are mentioned below. Please provide a review at our portal once the order is received.<br><br>Your payment for the amount &#8377;<strong>$total_price</strong> has been done successfully and your order will be arriving soon.<br><br>Your order will be delivered to the following address within 7 bussiness days.<br>$housenum,$street<br>$area,<br>$city, $zipcode<br>$state<br><br>Art Price: $total_price<br><br>Thank you!";
	include('smtp/PHPMailerAutoload.php');
	$mail=new PHPMailer(true);
	$mail->isSMTP();
	$mail->Host="smtp.gmail.com";
	$mail->Port=587;
	$mail->SMTPSecure="tls";
	$mail->SMTPAuth=true;
	$mail->Username="edgepcsystem@gmail.com";
	$mail->Password="edgepc123";
	$mail->SetFrom("edgepcsystem@gmail.com");
	$mail->addAddress($email);
	$mail->IsHTML(true);
	$mail->Subject="Your Order";
	$mail->Body=$html;
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->send()){
		$delete ="DELETE FROM cart WHERE user_id = '$user_id' ";
		mysqli_query($conn, $delete);
		header("Location:orders(planb).php?error= Payment done successfully please check your email!");
	exit();
	}
	else{
		header("Location:orders(planb).php?error1= Error sending email !");
		exit();
	}
}
else{
	header("Location:orders(planb).php?error1= Please check your email id !");
	die();
}
}
?>