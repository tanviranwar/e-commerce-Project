<?php include 'inc/header.php'; ?>
<?php
$login = Session::get("cmrlogin");
if ($login == false) {
	header("Location:login.php");
}
?>
<style>
	.payment{width: 500px;min-height: 200px;text-align: center;border: 1px solid #ddd;margin: 0 auto;padding: 50px;}
	.payment h2{border-bottom: 1px solid #ddd;margin-bottom: 40px;padding-bottom: 10px;}
	.payment a{background: #ff0000 none repeat scroll 0 0;border-radius: 3px;color: #fff;font-size: 25px;padding: 5px 30px;}
	.back a{width: 160px;margin: 5px auto 0;padding: 7px 0;text-align: center;display: block;background: #555;border:1px solid #333;color: #fff;border-radius: 3px;font-size: 25px;}
</style>
<div class="main">
<div class="content">
<div class="section group">
<div class="payment">
<h2>Order Success !</h2>
<?php
$cmrId = Session::get("cmrId");
$amount = $ct->payableAmount($cmrId);
if ($amount) {
	$sum = 0;
	while ($result = $amount->fetch_assoc()) {
		$price = $result['price'];
		$sum = $sum + $price;
	}
}
?>
<p style="color: blue;">Total Payable Amount(Including Vat) : $
<?php
$vat = $sum * 0.15;
$total = $sum + $vat;
echo $total;
?>
 </p>
<p>Congratulation! Payment Order Successfully Done.
<br/>Thank You For Your Shopping.
<br/> Please keep in touch! To see your order details please go <a href="orderdetails.php">here...</a> </p>
</div>
<div class="back">
<a href="index.php">Home</a>
</div>
</div>
</div>
</div>
<?php include 'inc/footer.php'; ?>