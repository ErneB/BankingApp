<?php ?>
<!DOCTYPE html>
<html>
<head>
    <title>ABC Company Form</title>
<script src="get_suppliers.js"></script>
<script src="validator.js"></script>
<style type="text/css">
#JS { display:none; }
</style>
<script>
function checkJS() {
document.getElementById('JS').style.display = "inline";
}
</script>
</head>
<body onload="checkJS();">
<div id="JS">
<form id="cf" method='post' action='item_interface.php' onSubmit="return validate_input(this)">


<p>UPC: <input type='text' name='upc' id='upc' required/></p>
<p>Quantity: <input type='text' name='quantity' id='quantity' required/></p>
<p>Price: <input type='text' name='price' id='price' required/></p>
<p>Rating: <input type='text' name='rating' id='rating'/></p>
<p>Warranty: Yes<input type='radio' name='warranty' id="warranty" value='true'required checked/>
 No<input type='radio' name='warranty' id="warranty" value='false'/></p>
<p>Aisle: <input type='text' name='aisle' id="aisle"/></p>
<p>Bay: <input type='text' name='bay' id="bay" /></p>
<script>
AjaxRequest("item_interface.php");
</script>
<div id="AjaxResponse"></div>
<input type="hidden" name="item_app" id="item_app" value="item" />
<p>Category: <input type='text' name='category' id="category" /></p>
<p>Condition: <input type='text' name='condition' id="condition" /></p>
 <p><input type='submit' /></p>
</form>
</div>
</body>