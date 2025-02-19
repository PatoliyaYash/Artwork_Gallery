<?php
include("includes/connection.php");
$transaction_id=$_POST['transaction_id'];
$price=$_POST['price'];
$delivery_date=$_POST['delivery_date'];
$art_title=$_POST['art_title'];
$email=$_POST['email'];
$query1="select * from buy_transaction where TRANSACTION_ID='$transaction_id'";
$result1=mysqli_query($conn,$query1);
$row1=mysqli_fetch_assoc($result1);
$user_id=$row1['USER_ID'];
$housenum=$row1['shipping_house_num'];
$street=$row1['shipping_street'];
$area=$row1['shipping_brgy'];
$city=$row1['shipping_municipal'];
$state=$row1['shipping_province'];
$zipcode=$row1['shipping_zipcode'];
$name=$row1['Courier_Name'];
$query = "
		UPDATE buy_transaction
		SET payment_status = 'Paid'
		WHERE TRANSACTION_ID = '$transaction_id'
	";
mysqli_query($conn,$query);
if(!empty($email)){
	$html="Dear, $name thank you for shopping with us. Your order details are mentioned below. Please provide a review at our portal once the order is received.<br><br>Your payment for the amount &#8377;<strong>$price</strong> has been done successfully and your order will be arriving soon.<br><br>Your order will be delivered to the following address within 7 bussiness days.<br>$housenum,$street<br>$area,<br>$city, $zipcode<br>$state<br><br>Order Id: $transaction_id<br>Title: $art_title<br>Art Price: $price<br>Expected Delivery Date: $delivery_date<br><br>Thank you!";
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
?>