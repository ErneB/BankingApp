<?php
class Item
{
    private $UPC = 000000000000;
    private $Quantity = 0;
    private $Price = 0;
    private $Rating = 0;
    private $Warranty = 'false';
    private $Aisle = "0";
    private $Bay = "0";
    private $Supplier = "Supplier";
    private $Category = "Category";
    private $Condition = "Good";

//Constructor:
    function __construct($properties_array) {
        if (method_exists('item_container', 'create_object')) {
            
        $upc_error = $this->set_UPC($properties_array[0]) == TRUE ? 'TRUE,' : 'FALSE,';
        $quantity_error = $this->set_Quantity($properties_array[1]) == TRUE ? 'TRUE,' : 'FALSE,';
        $price_error = $this->set_Price($properties_array[2]) == TRUE ? 'TRUE,' : 'FALSE,';
        $rating_error = $this->set_Rating($properties_array[3]) == TRUE ? 'TRUE,' : 'FALSE,';
        $warranty_error = $this->set_Warranty($properties_array[4]) == TRUE ? 'TRUE,' : 'FALSE,';
        $aisle_error = $this->set_Aisle($properties_array[5]) == true ? 'TRUE,' : 'FALSE,';
        $bay_error = $this->set_Bay($properties_array[6]) == TRUE ? 'TRUE,' : 'FALSE,';
        $supplier_error = $this->set_Supplier($properties_array[7]) == TRUE ? 'TRUE,' : 'FALSE,';
        $category_error = $this->set_Category($properties_array[8]) == TRUE ? 'TRUE,' : 'FALSE,';
        $condition_error = $this->set_Condition($properties_array[9]) == TRUE ? 'TRUE,' : 'FALSE,';
        $this->supplierxml = $properties_array[10];
        $this->error_message = $upc_error . $quantity_error . $price_error . $rating_error . $warranty_error . $aisle_error . $bay_error . $supplier_error . $category_error . $condition_error;
        $this->save_dog_data();
        if(stristr($this->error_message, 'FALSE'))
            {
            throw new setException($this->error_message);
            
            } }
        else {exit;}

    }

    function clean_input() { }
private function save_dog_data()
{
if ( file_exists("item_container.php")) {
require_once("item_container.php"); // use chapter 5 container w exception handling
} else {
throw new Exception("Item container file missing or corrupt");
}
$container = new item_container("itemdata"); // sets the tag name to look for in XML file
$properties_array = array("itemdata"); // not used but must be passed into create_object
$item_data = $container->create_object($properties_array); // creates item_data_class object
$method_array = get_class_methods($item_data);
$last_position = count($method_array) - 1;
$method_name = $method_array[$last_position];
$record_Array = array(array('upc'=>"$this->UPC", 'quantity'=>"$this->Quantity", 'price'=>"$this->Price", 'rating'=>"$this->Rating", 'warranty'=>"$this->Warranty", 'aisle'=>"$this->Aisle", 'bay'=>"$this->Bay", 'supplier'=>"$this->Supplier", 'category'=>"$this->Category", 'condition'=>"$this->Condition"));
$item_data->$method_name("Insert",$record_Array);
$item_data = NULL;
}
 
//Get Methods:
    function get_UPC() {
        return $this->UPC;
    }
    function get_Quantity() {
        return $this->Quantity;
    }function get_Price() {
        return $this->Price;
    }function get_Rating() {
        return $this->Rating;
    }function get_Warranty() {
        return $this->Warranty;
    }function get_Aisle() {
        return $this->Aisle;
    }function get_Bay() {
        return $this->Bay;
    }function get_Supplier() {
        return $this->Supplier;
    }function get_Category() {
        return $this->Category;
    }function get_Condition() {
        return $this->Condition;
    }
//Set Methods:
    function set_UPC($value){
        $error_message = true;
        (is_numeric($value) && (strlen((string)$value) == 12 || strlen((string)$value) == 6)) ? $this->UPC = $value : $error_message = false;
        return $error_message;
    }
    function set_Quantity($value){
        $error_message = true;
        (is_numeric($value) && $value > 0) ? $this->Quantity = $value : $error_message = false;
        return $error_message;
    }
    function set_Price($value){
        $error_message = true;
        (is_numeric($value) && $value > 0) ? $this->Price = $value : $error_message = false;
        return $error_message;
    }
    function set_Rating($value){
        $error_message = true;
        (is_numeric($value) && $value > 0 && $value < 6) ? $this->Rating = $value : $error_message = false;
        return $error_message;
    }
    function set_Warranty($value){
        $error_message = true;
        ($value === 'false' || $value === 'true') ? $this->Warranty = $value : $error_message = false;
        return $error_message;
    }
    function set_Aisle($value){
        $error_message = true;
        (is_numeric($value) && strlen($value) <= 2 && $value < 30) ? $this->Aisle = $value : $error_message = false;
        return $error_message;
    }
    function set_Bay($value){
        $error_message = true;
        (is_numeric($value) && strlen($value) <= 2) ? $this->Bay = $value : $error_message = false;
        return $error_message;
    }
    function set_Supplier($value){
        $error_message = true;
        ((ctype_alpha($value)) && ($this->validator_supplier($value) === TRUE) && strlen($value) <= 35) ?
        $this->Supplier = $value : $error_message = FALSE;
        return $error_message;
    }
    function set_Category($value){
        $error_message = true;
        (ctype_alpha($value)) ? $this->Category = $value : $error_message = FALSE;
        return $error_message;
    }
    function set_Condition($value){
        $error_message = true;
        (ctype_alpha($value)) ? $this->Condition = $value : $error_message = FALSE;
        return $error_message;
    }
    //General Methods:
    private function validator_supplier($value)
    {
    $supplier_file = simplexml_load_file("suppliers.xml");
    $xmlText = $supplier_file->asXML();
    if(stristr($xmlText, $value) === FALSE)
    {
    return FALSE;
    }
    else
    {
    return TRUE;
    }
    }
}
?>