<?php

	require 'template/head.html';

	function trace($msg, $debug = false){
		echo "<pre>";
		if (!$debug) print_r($msg);
		else var_dump($msg);
		echo "</pre>";
	}

	require 'validator/Validator.php';

	if(!empty($_POST["btnSubmit"])){
		$errors = $validator->validate(array(
			"firstname" => array(
				"rules" => "required"
			),
			"lastname" => array(
				"rules" => "required"
			),
			"email" => array(
				"rules" => array("required", "email"),
				"unset" => true
			),
			"url" => array(
				"name" => "Website link",
				"rules" => "url",
				"unset" => true
			),
			"pattern" => array(
				"name" => "Special pattern",
				"rules" => array("required","regex:/^[0-9]{2}[a-zA-Z]{3}$/"),
				"messages" => array(
					"regex" => "Please enter 2 digits, followed by 3 letters"
				),
				"unset" => true
			),
			"minmax" => array(
				"name" => "Minmax field",
				"rules" => array("minlength:3", "maxlength:10"),
				"unset" => true
			)
		), $_POST);

		$_POST = $validator->arrGlobal;

		if(count($errors) == 0){
			unset($_POST);
			echo "<p style='display:block;text-align:center;background-color: #5bd877; padding: 10px 0; color: #333;'>Form submission was successfull</p>";
		}
		else{
			echo "<p style='display:block;text-align:center;background-color: #d8676a; padding: 10px 0; color: #333;'>Please fix the following errors:</p>";
			trace($errors);
		}

	}

	require 'template/body.php';

	require 'template/foot.html';

?>