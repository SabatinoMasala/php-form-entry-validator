php-form-entry-validator
========================

A php form validator

How to use?
========================

Make a new instance of the validator and call the validate method with the following arguments:
  
    Array with keys and rules
    Array to validate (which will be $_POST 99% of the time)

An example:

    $validator = new Validator();
    $validator->validate(array(
      "value" => array(
        "name" => "Name of field",
        "rules" => array("required", "minlength:10", "maxlength:10")
      )
    ), $_POST)

Overview of rules
========================

Small note: when speaking of "value", the value linked to the key of the array to validate is meant.

    required - specify this when the value can't stay empty
    minlength:param - specify a minimum length of the value (param is an int)
    maxlength:param - specify a maximum length of the value (param is an int)
    email - specify this if the value has to be an email
    url - specify this if the value has to be an url
    numeric - specify this if the value can only be a number
    regex:param - specify this if the value has to match a certain regex (param is a regex)
    function:param - specify this to use a custom callback method to validate the value (param is the name of the function)
    equalto:param - specify this to match the value to the other value (param is the key index of the other value)
    minwords:param - specify a number of minimum words required (param is an int)
    maxwords:param - specify a number of maximum words allowed (param is an int)
    filetype:param - specify which filetypes are allowed (param is a string with comma separated file extensions)
