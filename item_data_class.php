<?php
class item_data
{
    private $items_array = array(); 
    private $item_data_xml = "";
    private $change_log_file = "change.log";


function __construct()

{
    libxml_use_internal_errors(true);
$xmlDoc = new DOMDocument();
if ( file_exists("supplier_application.xml") ) {
$xmlDoc->load( 'supplier_application.xml' );
$searchNode = $xmlDoc->getElementsByTagName( "type" );
foreach( $searchNode as $searchNode )
{
$valueID = $searchNode->getAttribute('ID');
if($valueID == "datastorage")
{
$xmlLocation = $searchNode->getElementsByTagName( "location" );
$this->item_data_xml = $xmlLocation->item(0)->nodeValue;

break;
}
} }
else {
    throw new Exception("Item applications xml file missing or corrupt"); }

$xmlfile = file_get_contents($this->item_data_xml);

$xmlstring = simplexml_load_string($xmlfile);
    if($xmlstring === false) {
        $errorString = "Failed loading database XML: ";
        foreach(libxml_get_errors() as $error){
                $errorString .= $error->message . " ";

        }
        throw new Exception($errorString);
    }
$json = json_encode($xmlstring);
$this->items_array = json_decode($json, TRUE);
}


function __destruct()
{
$xmlstring = '<?xml version="1.0" encoding="UTF-8"?>';
 $xmlstring .= "\n<items>\n";
 foreach ($this->items_array as $items=>$items_value) {
foreach ($items_value as $item => $item_value)
{
$xmlstring .="<$items>\n";
foreach ($item_value as $column => $column_value)
{
$xmlstring .= "<$column>" . $item_value[$column] . "</$column>\n";
}
$xmlstring .= "</$items>\n";
}
 }
$xmlstring .= "</items>\n";

$new_valid_data_file = preg_replace('/[0-9]+/', '', $this->item_data_xml);



// remove the previous date and time if it exists
$oldxmldata = date('mdYhis') . $new_valid_data_file;
if (!rename($this->item_data_xml, $oldxmldata))
{
 throw new Exception("Backup file $oldxmldata could not be created.");
}

file_put_contents($this->item_data_xml,$xmlstring);
}

//----------Methods&Functions--------------//


private function deleteRecord($recordNumber) {
    foreach ($this->items_array as $items=>&$items_value) {
    for($J=$recordNumber; $J < count($items_value) -1; $J++)
     {
        foreach ($items_value[$J] as $column => $column_value)
        {
        $items_value[$J][$column] = $items_value[$J + 1][$column];
        }
    }
    unset ($items_value[count($items_value) -1]);
    }
    $change_string = date('mdYhis') . " | Delete | " . $recordNumber . "\n";
    $chge_log_file = date('mdYhis') . $this->change_log_file;
    error_log($change_string,3,$chge_log_file); // might exceed 120 chars
    }
private function readRecords($recordNumber) {
    if($recordNumber === "ALL") {
        return $this->items_array["item"];
        }
    else {
        return $this->items_array["item"][$recordNumber];
        } }
        
private function insertRecords($records_array)
        {
        $items_array_size = count($this->items_array["item"]);
        for($I=0;$I< count($records_array);$I++)
        {
        $this->items_array["item"][$items_array_size + $I] = $records_array[$I];
        }
        $change_string = date('mdYhis') . " | Insert | " . serialize($records_array) . "\n";
        $chge_log_file = date('mdYhis') . $this->change_log_file;
        error_log($change_string,3,$chge_log_file); // might exceed 120 chars
        }
private function updateRecords($records_array)
        {
        foreach ($records_array as $records=>$records_value) {
            foreach ($records_value as $record => $record_value) {
                $this->items_array["item"][$records] = $records_array[$records];
                print_r($this->items_array["item"][$records]);
            }
        }
        $change_string = date('mdYhis') . " | Update | " . serialize($records_array) . "\n";
        $chge_log_file = date('mdYhis') . $this->change_log_file;
        error_log($change_string,3,$chge_log_file); // might exceed 120 chars
    }
    function setChangeLogFile($value)
        { 
        $this->item_data_xml = $value;
        }

        function processRecords($change_Type, $records_array)
        {
            switch($change_Type)
            {
                case "Delete":
                    $this->deleteRecord($records_array);
                    break;
                case "Insert":
                    $this->insertRecords($records_array);
                    break;
                case "Update":
                    $this->updateRecords($records_array);
                    break;
                case "Display":
                    $this->readRecords($records_array);
                    break;
                default:
                    throw new Exception("Invalid XML file change type: $change_Type");
            }
        }

}
?>