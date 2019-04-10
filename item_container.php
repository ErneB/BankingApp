<?php

class item_container
{

private $app;
private $item_location;

function __construct($value)
{	
if (function_exists('clean_input'))
{
$this->app = $value;
}
else
{
exit;
}
}

public function set_app($value)
{
$this->app = $value;
}

public function get_item_application($search_value)
{
$xmlDoc = new DOMDocument(); 

if ( file_exists('supplier_application.xml') )
{
$xmlDoc->load( 'supplier_application.xml' ); 

$searchNode = $xmlDoc->getElementsByTagName( "type" ); 
foreach( $searchNode as $searchNode ) 
{ 
    $valueID = $searchNode->getAttribute('ID'); 
    if($valueID == $search_value)
    {

    $xmlLocation = $searchNode->getElementsByTagName( "location" ); 
    return $xmlLocation->item(0)->nodeValue;
    break;

    }

}
}
    throw new Exception("Item application file missing or corrupt");
}
function create_object($properties_array)
{
  $item_loc = $this->get_item_application($this->app);
  
  if(($item_loc == FALSE) || (!file_exists($item_loc)))
  {
    throw new Exception("File $item_loc missing or corrupt.");
  }
  else
  {
    
    require_once($item_loc);
    $class_array = get_declared_classes();
    
  $last_position = count($class_array) - 1;
	$class_name = $class_array[$last_position];	
  
  $item_object = new $class_name($properties_array);
	
	return $item_object;
	}

}

}

?>