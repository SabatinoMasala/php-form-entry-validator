<?php

	function trace($msg, $debug = false){
		echo "<pre>";
		if (!$debug) print_r($msg);
		else var_dump($msg);
		echo "</pre>";
	}

	require 'Validator.php';

	$_POST["name"] = "f";
	$_POST["url"] = "dsdf";

	$validator = new Validator();

	$arrErrors = $validator->validate(array(
		"name" => array(
			"name" => "Name field",
			"rules" => array("required", "minlength:10"),
			"unset" => true,
			"messages" => array(
				"required" => "This field cannot stay empty",
				"minlength" => "Please enter 10 or more characters"
			)
		),
		"url" => array(
			"name" => "URL",
			"rules" => "regex:/[0-9]+/"
		)
	), $_POST);

	trace($arrErrors);
	

?>