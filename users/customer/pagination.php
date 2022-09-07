
<?php
require "customer_auth.php";
require "../../config_mysql.php";
require "../../config_mongodb.php";

$total_pages = (int)$pdo->query("SELECT COUNT(*) FROM product;")->fetch(PDO::FETCH_ASSOC)["COUNT(*)"];

$num_results_on_page = 7;
$page = isset($_GET['page']) && is_numeric($_GET['page']) ? $_GET['page'] : 1;

$calc_page = ($page - 1) * $num_results_on_page;
$query = 'SELECT * FROM product ORDER BY added_date desc LIMIT ?,?';

$where_conditions = [];
$pname = '';
$sprice = 0;
$eprice = (float)$pdo->query("SELECT MAX(Price) FROM product;")->fetch(PDO::FETCH_ASSOC)["MAX(Price)"];
$vendor_id = 0;
$where_condition_count  = 0;
$field = '';
$field_value = '';
$elements = ['pname', 'sprice', 'eprice', 'vendor_id', 'field', 'field_value'];
if (isset($_GET["pname"])){
	for ($i = 0; $i <count($elements); $i++) {
		if(!isset($_SESSION[$elements[$i]]) && !empty($_GET[$elements[$i]])){
			$_SESSION[$elements[$i]] = $_GET[$elements[$i]];
			if($elements[$i] == 'pname'){
					$where_conditions[$where_condition_count] = "ProductName LIKE '" . $_GET[$elements[$i]] . "%'";
			}else if(($elements[$i] == 'sprice') && is_numeric($_GET[$elements[$i]])){
				$where_conditions[$where_condition_count] = "Price >" . $_GET[$elements[$i]];
			}else if(($elements[$i] == 'eprice') && is_numeric($_GET[$elements[$i]])){
				$where_conditions[$where_condition_count] = "Price <" . $_GET[$elements[$i]];
			}else if(($elements[$i] == 'vendor_id') && is_numeric($_GET[$elements[$i]])){
				$where_conditions[$where_condition_count] = "VendorID =" . $_GET[$elements[$i]];
			}else if(($elements[$i] == 'field')){
				if(!empty($_GET[$elements[$i+1]])){ // check if value is not null
					// take product _ id with suitable field and value
					$field = $_GET['field'];
					$field_value = $_GET['field_value'];
					$data = $product_extras->find([$field => $field_value]);
					$list_id = "ProductID IN (";
					$count_id = 0;
					foreach($data as $key => $item){
						$list_id = $list_id. $item["_id"] . ",";
						$count_id ++;
    				}
					if($count_id > 0){
						$list_id =  substr_replace($list_id ,"",-1) . ")";
						$where_conditions[$where_condition_count] = $list_id;
					}	
				}
			}
			$where_condition_count ++;
		}
	  }
}
$where_script = '';
if(count($where_conditions) > 0){
	$where_script .= 'WHERE ';
	for ($i = 0; $i <count($where_conditions) -1; $i++) {
		$where_script .= $where_conditions[$i] ." AND ";
	}
	$where_script .= $where_conditions[count($where_conditions)-1];
	$_SESSION['where_conditions'] = $where_script;
}
if (isset($_POST["appetizer_button"])){
	for ($i = 0; $i <count($elements); $i++) {
		unset($_SESSION[$elements[$i]]);
		unset($_SESSION['where_conditions']);
		header("location:http://localhost:8000/users/customer/pagination.php");
	  }
}


if(isset($_SESSION['where_conditions'])){
	$query = 'SELECT * FROM product '. $_SESSION['where_conditions'] . ' ORDER BY added_date desc LIMIT ?,?';
	echo $query;
}
// query from database
if ($stmt = $pdo->prepare($query)) {
	// Calculate the page to get the results we need from our table.
	$calc_page = ($page - 1) * $num_results_on_page;
	$stmt->bindParam(1, $calc_page, PDO::PARAM_INT);
	$stmt->bindParam(2, $num_results_on_page, PDO::PARAM_INT);
	$stmt->execute(); 
}

?>
<!DOCTYPE html>
<html>
	<head>
		<title>PHP & MySQL Pagination by CodeShack</title>
		<meta charset="utf-8">
		<style>
		html {
			font-family: Tahoma, Geneva, sans-serif;
			padding: 20px;
			background-color: #F8F9F9;
		}
		table {
			border-collapse: collapse;
			width: 500px;
		}
		td, th {
			padding: 10px;
		}
		th {
			background-color: #54585d;
			color: #ffffff;
			font-weight: bold;
			font-size: 13px;
			border: 1px solid #54585d;
		}
		td {
			color: #636363;
			border: 1px solid #dddfe1;
		}
		tr {
			background-color: #f9fafb;
		}
		tr:nth-child(odd) {
			background-color: #ffffff;
		}
		.pagination {
			list-style-type: none;
			padding: 10px 0;
			display: inline-flex;
			justify-content: space-between;
			box-sizing: border-box;
		}
		.pagination li {
			box-sizing: border-box;
			padding-right: 10px;
		}
		.pagination li a {
			box-sizing: border-box;
			background-color: #e2e6e6;
			padding: 8px;
			text-decoration: none;
			font-size: 12px;
			font-weight: bold;
			color: #616872;
			border-radius: 4px;
		}
		.pagination li a:hover {
			background-color: #d4dada;
		}
		.pagination .next a, .pagination .prev a {
			text-transform: uppercase;
			font-size: 12px;
		}
		.pagination .currentpage a {
			background-color: #518acb;
			color: #fff;
		}
		.pagination .currentpage a:hover {
			background-color: #518acb;
		}
		</style>
	</head>
	<body>
	<form method="get" action="<?php echo $_SERVER["PHP_SELF"];?>">
    <label for="inputName">Enter product name:</label>
    <input type="text" name="pname" id="inputName">
	<label for="inputName">Enter start price:</label>
    <input type="text" name="sprice" id="inputName">
	<label for="inputName">Enter end price:</label>
    <input type="text" name="eprice" id="inputName">
	<label for="inputName">Enter vendor_id:</label>
    <input type="text" name="vendor_id" id="inputName">
	<label for="inputName">Enter field:</label>
    <input type="text" name="field" id="inputName">
	<label for="inputName">Enter value:</label>
    <input type="text" name="field_value" id="inputName">
    <input type="submit" value="Search">
</form>
        <!-- End form -->
		<table>
			<tr>
				<th>ID</th>
				<th>Name</th>
				<th>Price</th>
				<th>Description</th>
				<th>Vendor id</th>
				<th>ADD Date</th>
			</tr>
				<?php while ($row = $stmt->fetch(PDO::FETCH_ASSOC)): ?>	
					<tr>
						<td><?php echo $row['ProductID']; ?></td>
						<td><?php echo $row['ProductName']; ?></td>
						<td><?php echo $row['Price']; ?></td>
						<td><?php echo $row['ProductDescription']; ?></td>
						<td><?php echo $row['VendorID']; ?></td>
						<td><?php echo $row['added_date']; ?></td>
						<?php if ($row['haveExtraField'] == '1'): ?>
						<td><a href="product_details.php?productID=<?php echo $row['ProductID']?>">More</td>
						<?php endif; ?>
						<td><a href="buy_product.php?productID=<?php echo $row['ProductID']?>&vendorID=<?php echo $row['VendorID']?>">Buy</td>
					</tr>
				<?php endwhile; ?>
		</table>
	 		<?php if (ceil($total_pages / $num_results_on_page) > 0): ?>
		<ul class="pagination">
			<?php if ($page > 1):?>
			<li class="prev"><a href="pagination.php?page=<?php echo $page-1 ?>">Prev</a></li>
			<?php endif; ?>
			<?php if ($page < ceil($total_pages / $num_results_on_page)): ?>
			<li class="next"><a href="pagination.php?page=<?php echo $page+1 ?>">Next</a></li>
			<?php endif; ?>
		</ul>
		<?php endif; ?>
		<form  method="post">
		<input type="submit" name="appetizer_button" value="ResetView" onclick="window.location='http://google.com'">
		</form>
	</body>
</html>
<?php
?>
