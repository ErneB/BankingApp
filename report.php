<?php
require_once('item.php');
$array = array($_POST["upc"], $_POST["quantity"], $_POST["price"], $_POST["rating"], $_POST["warranty"],$_POST["aisle"],$_POST["bay"],$_POST["supplier"],$_POST["category"],$_POST["condition"]);
$item = new Item($array);
list($upc_error, $price_error, $quantity_error, $rating_error, $warranty_error, $aisle_error, $bay_error, $supplier_error, $category_error, $condition_error) = explode(',', $item);
//Report
print "<br />";
print "Report: <br/>";
print "<br />";
print $upc_error == 'TRUE' ? 'UPC update successful<br/>' : 'UPC update not successful<br/>';
print $quantity_error == 'TRUE' ? 'Quantity update successful<br/>' : 'Quantity update not successful<br/>';
print $price_error == 'TRUE' ? 'Price update successful<br/>' : 'Price update not successful<br/>';
print $rating_error == 'TRUE' ? 'Rating update successful<br/>' : 'Rating update not successful<br/>';
print $warranty_error == 'TRUE' ? 'Warranty update successful<br/>' : 'Warranty update not successful<br/>';
print $aisle_error == 'TRUE' ? 'Aisle update successful<br/>' : 'Aisle update not successful<br/>';
print $bay_error == 'TRUE' ? 'Bay update successful<br/>' : 'Bay update not successful<br/>';
print $supplier_error == 'TRUE' ? 'Supplier update successful<br/>' : 'Supplier update not successful<br/>';
print $category_error == 'TRUE' ? 'Category update successful<br/>' : 'Category update not successful<br/>';
print $condition_error == 'TRUE' ? 'Condition update successful<br/>' : 'Condition update not successful<br/>';
//Return Item Value
print "<br />";
print "Item Values: <br />";

print "<br />";
print "UPC is ". $item->get_UPC() . '<br/>';
print "Quantity is " .$item->get_Quantity() . '<br/>';
print "Warranty is " . ($item->get_Warranty() == 'true' ? 'true' : 'false') . '<br/>';
print "Aisle is " . $item->get_Aisle() . '<br/>';
print "Bay is " . $item->get_Bay() . '<br/>';
print "Supplier is " . $item->get_Supplier() . '<br/>';
print "Category is " . $item->get_Category() . '<br/>';
print "Condition is " . $item->get_Condition() . '<br/>';
?>