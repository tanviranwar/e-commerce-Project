<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/formate.php');
/*include_once 'lib/Database.php';
include_once 'helpers/formate.php';*/

?>
<?php
class Product{
	private $db;
	private $fm;
	
	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

	public function productInsert($data, $file){
		$productName = $this->fm->validation($data['productName']);
		$catId = $this->fm->validation($data['catId']);
		$brandId = $this->fm->validation($data['brandId']);
		$body = $this->fm->validation($data['body']);
		$price = $this->fm->validation($data['price']);
		$type = $this->fm->validation($data['type']);

		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$catId = mysqli_real_escape_string($this->db->link, $data['catId']);
		$brandId = mysqli_real_escape_string($this->db->link, $data['brandId']);
		$body = mysqli_real_escape_string($this->db->link, $data['body']);
		$price = mysqli_real_escape_string($this->db->link, $data['price']);
		$type = mysqli_real_escape_string($this->db->link, $data['type']);

   $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $file['image']['name'];
    $file_size = $file['image']['size'];
    $file_temp = $file['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "upload/".$unique_image;

    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "") {
    	$msg = "<span class='error'>Field must NOT be empty !</span>";
		return $msg;
    }else {
    	 move_uploaded_file($file_temp, $uploaded_image);
    	 $query = "INSERT INTO tbl_products(productName, catId, brandId, body, price, image, type) VALUES('$productName', '$catId', '$brandId','$body', '$price', '$uploaded_image', '$type') ";

 $inserted_row = $this->db->insert($query);
	if ($inserted_row) {
		$msg = "<span class='success'>Product inserted successfully !</span>";
		return $msg;
	} else {
$msg = "<span class='error'>Product NOT inserted !</span>";
		return $msg;
	}
    }
	}
public function getAllProduct(){
	$query = "SELECT p.*, c.catName, b.brandName FROM tbl_products as p, tbl_category as c, tbl_brand as b
	WHERE p.catId = c.catId AND p.brandId = b.brandId ORDER BY p.productId DESC";
	/*
	$query = "SELECT tbl_products.*, tbl_category.catName, tbl_brand.brandName FROM tbl_products
INNER JOIN tbl_category 
ON tbl_products.catId = tbl_category.catId
INNER JOIN tbl_brand
ON tbl_products.brandId = tbl_brand.brandId
	  ORDER BY tbl_products.productId DESC";*/
	$result = $this->db->Select($query);
	return $result;
	}
	public function getProById($id){
$query = "SELECT * FROM tbl_products WHERE productId = '$id' ";
  $result = $this->db->select($query);
  return $result;
	}
	public function productUpdate($data, $file, $id){
	$productName = $this->fm->validation($data['productName']);
		$catId = $this->fm->validation($data['catId']);
		$brandId = $this->fm->validation($data['brandId']);
		$body = $this->fm->validation($data['body']);
		$price = $this->fm->validation($data['price']);
		$type = $this->fm->validation($data['type']);

		$productName = mysqli_real_escape_string($this->db->link, $data['productName']);
		$catId = mysqli_real_escape_string($this->db->link, $data['catId']);
		$brandId = mysqli_real_escape_string($this->db->link, $data['brandId']);
		$body = mysqli_real_escape_string($this->db->link, $data['body']);
		$price = mysqli_real_escape_string($this->db->link, $data['price']);
		$type = mysqli_real_escape_string($this->db->link, $data['type']);

   $permited  = array('jpg', 'jpeg', 'png', 'gif');
    $file_name = $file['image']['name'];
    $file_size = $file['image']['size'];
    $file_temp = $file['image']['tmp_name'];

    $div = explode('.', $file_name);
    $file_ext = strtolower(end($div));
    $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
    $uploaded_image = "upload/".$unique_image;

    if ($productName == "" || $catId == "" || $brandId == "" || $body == "" || $price == "" || $type == "") {
    	$msg = "<span class='error'>Field must NOT be empty !</span>";
		return $msg;
    }

    else {
    	 move_uploaded_file($file_temp, $uploaded_image);
    	 
$query = "UPDATE tbl_products SET 
productName = '$productName',
catId       = '$catId',
brandId     = '$brandId',
body        = '$body',
price       = '$price',
image       = '$uploaded_image',
type        = '$type'
WHERE productId = '$id'";

 $updated_row = $this->db->update($query);
	if ($updated_row) {
		$msg = "<span class='success'>Product updated successfully !</span>";
		return $msg;
	} else {
$msg = "<span class='error'>Product NOT updated !</span>";
		return $msg;
	}
    }
}
public function delProById($id){
$query = "SELECT * FROM tbl_products WHERE productId = '$id' ";
$getData = $this->db->select($query);
if ($getData) {
	while ($delImg = $getData->fetch_assoc()) {
		$dellink = $delImg['image'];
		unlink($dellink);
	}
}

	$delquery = "DELETE FROM tbl_products WHERE productId = '$id'";
	$deldata = $this->db->delete($delquery);
	if ($deldata) {
		$msg = "<span class='success'>Product Deleted successfully !</span>";
		return $msg;
	} else{
		$msg = "<span class='error'>Product Not Deleted !</span>";
return $msg;
	}
}
public function getFeaturedProduct(){
	$query = "SELECT * FROM tbl_products WHERE type='0' ORDER BY productId DESC LIMIT 4 ";
  $result = $this->db->select($query);
  return $result;
}
public function getNewProduct(){
	$query = "SELECT * FROM tbl_products ORDER BY productId DESC LIMIT 4 ";
  $result = $this->db->select($query);
  return $result;
}

public function getSingleProduct($id){
$query = "SELECT p.*, c.catName, b.brandName FROM tbl_products as p, tbl_category as c, tbl_brand as b
	WHERE p.catId = c.catId AND p.brandId = b.brandId AND p.productId = '$id'";
	$result = $this->db->Select($query);
	return $result;
}
public function latestFromIphone(){
	$query = "SELECT * FROM  tbl_products WHERE brandId = '3' ORDER BY productId DESC LIMIT 1 ";
  $result = $this->db->select($query);
  return $result;
}
public function latestFromSamsung(){
	$query = "SELECT * FROM  tbl_products WHERE brandId = '2' ORDER BY productId DESC LIMIT 1 ";
  $result = $this->db->select($query);
  return $result;
}
public function latestFromAcer(){
	$query = "SELECT * FROM  tbl_products WHERE brandId = '1' ORDER BY productId DESC LIMIT 1 ";
  $result = $this->db->select($query);
  return $result;
}
public function latestFromCanon(){
	$query = "SELECT * FROM  tbl_products WHERE brandId = '4' ORDER BY productId DESC LIMIT 1 ";
  $result = $this->db->select($query);
  return $result;
}
public function proByCat($id){
$catId = mysqli_real_escape_string($this->db->link, $id);
	$query = "SELECT * FROM  tbl_products WHERE catId = '$id'";
  $result = $this->db->select($query);
  return $result;
}

public function insertCompareData($cmprid, $cmrId){
	$cmrId = mysqli_real_escape_string($this->db->link, $cmrId);
	$productId = mysqli_real_escape_string($this->db->link, $cmprid);

$cquery = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrId' AND productId = '$productId' ";
$check = $this->db->select($cquery);
if ($check) {
	$msg = "<span class='error'>Product already added to compare !</span>";
return $msg;
}

	$query = "SELECT * FROM tbl_products WHERE productId = '$productId'";
	$result = $this->db->select($query)->fetch_assoc();
	if ($result) {
		
			$productId = $result['productId'];
			$productName = $result['productName'];
			$price = $result['price'];
			$image = $result['image'];
	$query = "INSERT INTO  tbl_compare(cmrId, productId, productName, price,  image) VALUES('$cmrId','$productId', '$productName','$price',  '$image') ";

 $inserted_row = $this->db->insert($query);
		}if ($inserted_row) {
		$msg = "<span class='success'>Product added to compare successfully !</span>";
		return $msg;
	} else{
		$msg = "<span class='error'>Product Not added to compare !</span>";
return $msg;
	}
	
}

public function getCompareData($cmrId){
	$query = "SELECT * FROM tbl_compare WHERE cmrId = '$cmrId' ORDER BY id DESC";
$result = $this->db->select($query);
return $result;
}

public function delCompareData($cmrId){
	$query = "DELETE FROM tbl_compare WHERE cmrId = '$cmrId'";
	$deldata = $this->db->delete($query);
	if ($deldata) {
		$msg = "<span class='success'>Product Deleted successfully !</span>";
		return $msg;
	} else{
		$msg = "<span class='error'>Product Not Deleted !</span>";
return $msg;
	}
}

public function saveWishListData($id,$cmrId){
$cquery = "SELECT * FROM tbl_wlist WHERE cmrId = '$cmrId' AND productId = '$id' ";
$check = $this->db->select($cquery);
if ($check) {
	$msg = "<span class='error'>Product already added to Wish List !</span>";
return $msg;
}

	$pquery = "SELECT * FROM tbl_products WHERE productId = '$id'";
	$result = $this->db->select($pquery)->fetch_assoc();
	if ($result) {
			$productId = $result['productId'];
			$productName = $result['productName'];
			$price = $result['price'] ;
			$image = $result['image'];
	$query = "INSERT INTO   tbl_wlist(cmrId, productId, productName, price,  image) VALUES('$cmrId','$productId', '$productName','$price', '$image') ";

 $inserted_row = $this->db->insert($query);
 if ($inserted_row) {
		$msg = "<span class='success'>Product added to wish list successfully !</span>";
		return $msg;
	} else{
		$msg = "<span class='error'>Product Not added to wish list !</span>";
return $msg;
	}
		}
	}
	public function checkWlistData($cmrId){
		$query = "SELECT * FROM tbl_wlist WHERE cmrId = '$cmrId' ORDER BY id DESC";
$result = $this->db->select($query);
return $result;
}

public function delWlistData($cmrId,$productId){
	$query = "DELETE FROM tbl_wlist WHERE cmrId = '$cmrId' AND productId = '$productId' ";
	$deldata = $this->db->delete($query);
}	
}
?>