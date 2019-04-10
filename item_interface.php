<?php

const USER_ERROR_LOG = 'User_Errors.log';
const ERROR_LOG = 'Errors.log';

function clean_input($value)
{
 $value = htmlentities($value);
		// Removes any html from the string and turns it into &lt; format
		$value = strip_tags($value);
		
 
	if (get_magic_quotes_gpc())
	{
		$value = stripslashes($value);
		
		// Gets rid of unwanted slashes
	}
		$value = htmlentities($value);
		
		// Removes any html from the string and turns it into &lt; format
		
       $bad_chars = array( "{", "}", "(", ")", ";", ":", "<", ">", "/", "$" );
       $value = str_ireplace($bad_chars,"",$value);			
		return $value;
	
}

class setException extends Exception{
public function errorMessage()
{

	$array = array($_POST["upc"], $_POST["quantity"], $_POST["price"], $_POST["rating"], $_POST["warranty"],$_POST["aisle"],$_POST["bay"],$_POST["supplier"],$_POST["category"],$_POST["condition"]);
	$item = new Item($array);
	list($upc_error, $price_error, $quantity_error, $rating_error, $warranty_error, $aisle_error, $bay_error, $supplier_error, $category_error, $condition_error) = explode(',', $this->getMessage());


print "<br />";
print "Report: <br/>";
print "<br />";
print $upc_error == 'TRUE' ? $eMessage ='': $eMessage = 'UPC update not successful<br/>';
print $quantity_error == 'TRUE' ? $eMessage .='': $eMessage .= 'Quantity update not successful<br/>';
print $price_error == 'TRUE' ? $eMessage .='': $eMessage .= 'Price update not successful<br/>';
print $rating_error == 'TRUE' ? $eMessage .='': $eMessage .= 'Rating update not successful<br/>';
print $warranty_error == 'TRUE' ? $eMessage .='': $eMessage .= 'Warranty update not successful<br/>';
print $aisle_error == 'TRUE' ? $eMessage .='': $eMessage .= 'Aisle update not successful<br/>';
print $bay_error == 'TRUE' ? $eMessage .='': $eMessage .= 'Bay update not successful<br/>';
print $supplier_error == 'TRUE' ? $eMessage .='': $eMessage .= 'Supplier update not successful<br/>';
print $category_error == 'TRUE' ? $eMessage .='': $eMessage .= 'Category update not successful<br/>';
print $condition_error == 'TRUE' ? $eMessage .='': $eMessage .= 'Condition update not successful<br/>';
return $eMessage;
}
}

function get_item_app_properties($item)
{

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

}
//----------------Main Section-------------------------------------
try {
if ( file_exists("item_container.php"))
{
	Require_once("item_container.php");
	
 }
 else
 {
	throw new Exception("Dog container file missing or corrupt");;
	exit;
 }

if (isset($_POST['item_app']))

  {
if ((isset($_POST['upc'])) && (isset($_POST['quantity'])) && (isset($_POST['price'])) && (isset($_POST['rating'])) && (isset($_POST['warranty'])) 
			&& (isset($_POST['aisle'])) && (isset($_POST['bay'])) && (isset($_POST['supplier'])) && (isset($_POST['category'])) && (isset($_POST['condition'])))
{

     $container = new item_container(clean_input($_POST['item_app']));
     $upc_error = clean_input($_POST['upc']);
     $quantity_error = clean_input($_POST['quantity']);
     $price_error = clean_input($_POST['price']);
		 $rating_error = clean_input($_POST['rating']);
		 $warranty_error = clean_input($_POST['warranty']);
		 $aisle_error = clean_input($_POST['aisle']);
		 $bay_error = clean_input($_POST['bay']);
		 $supplier_error = clean_input($_POST['supplier']);
		 $category_error = clean_input($_POST['category']);
		 $condition_error = clean_input($_POST['condition']);
     $supplierxml = $container->get_item_application("suppliers");

	 $properties_array = array($upc_error,$quantity_error,$price_error,$rating_error,$warranty_error,$aisle_error,$bay_error,$supplier_error,$category_error,$condition_error,$supplierxml);
	 
	 $lab = $container->create_object($properties_array);
	 print "Updates successful<br />";
		
     get_item_app_properties($lab);
	 
	 
}

else
{

print "<p>Missing or invalid parameters. Please go back to the phpForm.html page to enter valid information.<br />";

print "<a href='phpForm.html'>Item Creation Page</a>";

}
}
 else // select box
  {
     
     $container = new item_container("selectbox");
     
	 $properties_array = array("selectbox");
	 
     $lab = $container->create_object($properties_array);
		 $container->set_app("suppliers");
		 $item_app = $container->get_item_application("suppliers");
		 $result = $lab->get_select($item_app);
		 print $result;
	}
	 
		}//try
		catch(setException $e)
		{
			echo $e->errorMessage(); // displays to the user
			$date = date('m.d.Y h:i:s');
			$errormessage = $e->errorMessage();
			$eMessage = $date . " | User Error | " . $errormessage . "\n";
			error_log($eMessage,3,USER_ERROR_LOG); // writes message to user error log file
			
		}
		catch(Exception $e)
		{
			echo "The system is currently unavailable. Please try again later."; // displays message to the user
			$date = date('m.d.Y h:i:s');
			$eMessage = $date . " | System Error | " . $e->getMessage() . " | " . $e->getFile() . " | ". $e->getLine() . "\n";
			error_log($eMessage,3,ERROR_LOG); // writes message to error log file
		
		}
?>
