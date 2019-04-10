function allalphabetic(the_string) {
  var letters = /^[a-zA-Z ]+$/;
  if (the_string.match(letters)) {
    return true;
  } else {
    return false;
  }
}
function allnumeral(the_string) {
  var numbers = /^[0-9 ]+$/;
  if (the_string.match(numbers)) {
    return true;
  } else {
    return false;
  }
}
// ----------------------------------------------------------------------------------------------------------------------------------
function validate_UPC(the_string) {
  if (
    (the_string.length == 6 || the_string.length == 12) &&
    allnumeral(the_string)
  ) {
    return true;
  } else {
    return false;
  }
}

function validate_Quantity(the_string) {
  if (the_string.length > 0 && allnumeral(the_string)) {
    return true;
  } else {
    return false;
  }
}
function validate_Price(the_string) {
  if (the_string > 0 && allnumeral(the_string)) {
    return true;
  } else {
    return false;
  }
}
function validate_Rating(the_string) {
  if (the_string > 0 && the_string < 6 && allnumeral(the_string)) {
    return true;
  } else {
    return false;
  }
}
function validate_Warranty(the_string) {
  if (the_string == "true") {
    return true;
  } else {
    return false;
  }
}
function validate_Aisle(the_string) {
  if (the_string.length < 3 && the_string <= 30 && allnumeral(the_string)) {
    return true;
  } else {
    return false;
  }
}
function validate_Bay(the_string) {
  if (the_string.length < 3 && allnumeral(the_string)) {
    return true;
  } else {
    return false;
  }
}
function validate_Supplier(the_string) {
  if (allalphabetic(the_string)) {
    return true;
  } else {
    return false;
  }
}
function validate_Category(the_string) {
  if (allalphabetic(the_string)) {
    return true;
  } else {
    return false;
  }
}
function validate_Condition(the_string) {
  if (allalphabetic(the_string)) {
    return true;
  } else {
    return false;
  }
}
// ----------------------------------------------------------------------------------------------------------------------------------
function validate_input(form) {
  var error_message = "";
  if (!validate_UPC(form.upc.value)) {
    error_message += "Invalid UPC. ";
  }
  if (!validate_Quantity(form.quantity.value)) {
    error_message += "Invalid Quantity. ";
  }
  if (!validate_Price(form.price.value)) {
    error_message += "Invalid price. ";
  }
  if (!validate_Rating(form.rating.value)) {
    error_message += "Invalid rating. ";
  }
  if (!validate_Warranty(form.warranty.value)) {
    error_message += "Invalid warranty. ";
  }
  if (!validate_Aisle(form.aisle.value)) {
    error_message += "Invalid aisle. ";
  }
  if (!validate_Bay(form.bay.value)) {
    error_message += "Invalid bay. ";
  }
  if (!validate_Supplier(form.supplier.value)) {
    error_message += "Invalid supplier. ";
  }
  if (!validate_Category(form.category.value)) {
    error_message += "Invalid category. ";
  }
  if (!validate_Condition(form.condition.value)) {
    error_message += "Invalid condition. ";
  }
  if (error_message.length >= 1) {
    alert(error_message);
    return false;
  } else {
    return true;
  }
}
