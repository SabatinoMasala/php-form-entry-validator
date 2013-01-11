<?php

	function trace($msg, $debug = false){
		echo "<pre>";
		if (!$debug) print_r($msg);
		else var_dump($msg);
		echo "</pre>";
	}

	require 'Validator.php';

	$_POST["name"] = "blqsdfqsdfsqsdfqa";
	$_POST["url"] = "dsdf";

	$validator = new Validator();

	$arrErrors = $validator->validate(array(
		"name" => array(
			"name" => "Name field",
			"rules" => array("required", "minlength:100"),
			"unset" => true
		),
		"url" => array(
			"name" => "URL",
			"rules" => "url"
		)
	), $_POST);

	trace($arrErrors);
	

?>