<?php

session_start();

include 'db.php';


if (isset($_POST['makeorder'])) {
	$firstName = $_SESSION['first_name'];
	$lastName = $_SESSION['last_name'];
	$email = $_SESSION['email'];
	$phone = $_SESSION['phone'];
	$address = mysqli_escape_string($db, $_POST['address']);
	$postCode = mysqli_escape_string($db, $_POST['postcode']);
	$county = mysqli_escape_string($db, $_POST['county']);
	$zone = mysqli_escape_string($db, $_POST['town']);
	$orderNotes = mysqli_escape_string($db, $_POST['ordernotes']);

	$totalAmount = $_SESSION['grand-total'];
	$ref_code = ('O'. $firstName[0] . $lastName[0] .  date("YmdHis"));
	echo($ref_code);
	$status = "Pending";
	$date = date("Y/m/d H:i");

	//insert into the admin database

	$insert = "INSERT INTO `orders`( `ref_code`, `first_name`, `last_name`, `email`, `phone`, `county`, `town`, `postcode`, `address`, `date_ordered`, `amount`, `status`) VALUES ('$ref_code','$firstName','$lastName','$email','$phone','$county','$zone','$postCode','$address','$date','$totalAmount','$status')";

	if (mysqli_query($db, $insert) === true) {
		echo("Success");
		unset($_SESSION['cart']);
		header("Location: ../orders.php?success=Your order has been placed successfully");

		//Insert into farmers database
		$ref_code_2 = $ref_code = ('O'. strtoupper($firstName[(strlen($firstName) - 1)]) . strtoupper($lastName[(strlen($lastName) - 1)]) .  date("YmdHis"));
		echo($ref_code_2);
		$customer = strtoupper($firstName) . " " . strtoupper($lastName);
		echo($customer);

		$product = "Cabbages";


	}else{
		echo("Failed Massively Look for the cause");
	}



}

?>