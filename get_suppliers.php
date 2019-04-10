<?php

class GetItems {

function __construct($properties_array)
{
    
if (!(method_exists('item_container', 'create_object')))
{
exit;
}
}

private $result = "??";

public function get_select($item_app)
{
     
	 
	 if (($item_app != FALSE) && ( file_exists($item_app)))
	 {
     $vendor_file = simplexml_load_file($item_app);

     $xmlText = $vendor_file->asXML();
	
     $this->result = "<select name='supplier' id='supplier'>";
	 
     $this->result = $this->result . "<option value='-1' selected>Select a vendor</option>";
     
    foreach ($vendor_file->children() as $name => $value)
    {
      $this->result = $this->result . "<option value='$value'>$value</option>";
    }
      $this->result = $this->result . "</select>";
	  
	  return $this->result;
    }
	else
	{
	  throw new Exception("Breed xml file missing or corrupt");
    }
  

}
}
?>
