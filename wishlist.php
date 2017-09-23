<?php include 'inc/header.php'; ?>
<?php
if (isset($_GET['delwlistid'])) {
	$productId = $_GET['delwlistid'];
	$delWlist = $pd->delWlistData($cmrId,$productId);
}
?>
<style>
table.tblone img{height: 90px; width: 100px;}	
</style>
<div class="main">
<div class="content">
<div class="cartoption">		
<div class="cartpage">
<h2>My Wish List</h2>

<table class="tblone">
<tr>

	<th> SL</th>
	<th>Product Name</th>
	<th>Price</th>
	<th>Image</th>
	<th>Action</th>
</tr>
<?php
$cmrId = Session::get("cmrId");
$getPd = $pd->checkWlistData($cmrId);
if ($getPd) {
	$i = 0;

	while ($result = $getPd->fetch_assoc()) {
		$i++;

?>
<tr>
	<td><?php echo $i; ?></td>
	<td><?php echo $result['productName']; ?></td>
	<td>$<?php echo $result['price']; ?></td>
	<td><img src="admin/<?php echo $result['image']; ?>" alt=""/></td>
	</td>
	<td>
	<a href="details.php?proid=<?php echo $result['productId']; ?>">Buy Now</a> ||
	<a href="?delwlistid=<?php echo $result['productId']; ?>">Remove</a>
	</td>
</tr>

<?php } } ?>

</table>

</div>
<div class="shopping">
<div class="shopleft">
<a href="index.php"> <img src="images/shop.png" alt="" /></a>
</div>
<div class="shopright">
<a href="payment.php"> <img src="images/check.png" alt="" /></a>
</div>
</div>
</div>  	
<div class="clear"></div>
</div>
</div>
<?php include 'inc/footer.php'; ?>