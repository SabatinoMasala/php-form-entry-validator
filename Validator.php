<?php

	class Validator{

		private $arrGlobal = array();
		private $arrErrors = array();
		private $arrToValidate = array();
		private $unsetArray = array();

		public function __construct(){
			
		}

		/**
		 * Global function to validate multiple values in an array
		 * TODO: extra info schrijven hierzo
		 */

		public function validate($arrToValidate, $arrGlobal)
		{
			$this->arrGlobal = $arrGlobal;
			$this->arrToValidate = $arrToValidate;

			foreach($arrToValidate as $key=>$val){
				$this->validateElement($key,$val);
			}

			foreach($this->unsetArray as $val){
				unset($this->arrGlobal[$val]);
			}

			return $this->arrErrors;
		}

		/**
		 * This function will accept an array with the key and rules for that key
		 */

		private function validateElement($key, $element){
			$rules = $element["rules"];
			$isFilled = !empty($this->arrGlobal[$key]);
			$canBeOptional = !$this->isRequired($rules);

			if(!$isFilled && !$canBeOptional){
				$this->setError("required", $key);
				return false;
			}
			elseif(!$isFilled && $canBeOptional){
				return true;
			}

			// Can also be 1 single rule, not wrapped in an array
			if(!is_array($rules)){
				return $this->validateRule($this->arrGlobal[$key], $rules, $key);
			}
			else{
				foreach($rules as $val){
					$this->validateRule($this->arrGlobal[$key], $val, $key);
				}
			}

			return true;
		}

		/**
		 * Check if the field has the "required" rule
		 */

		private function isRequired($rules){
			if(!is_array($rules)){
				$filtered = $this->filter($rules);
				$rule = $filtered[0];
				if($rule == "required") return true;
			}
			else{
				foreach ($rules as $key=>$val) {
					$filtered = $this->filter($val);
					$rule = $filtered[0];
					if($rule == "required") return true;
				}
			}
			return false;
		}

		/**
		 * Function to filter out the (optional) parameter
		 */

		private function filter($rule){
			$regex = "/([^: ]+)/";
			preg_match_all($regex, $rule, $matches);
			$matches = $matches[0];
			$rule = $matches[0];
			$parameter = !empty($matches[1]) ? $matches[1] : false;

			return array($rule, $parameter);
		}

		/**
		 * Function to set the global error array and (if property unset is true) the unsetting array
		 */

		private function setError($rule, $key){
			$name = !empty($this->arrToValidate[$key]["name"]) ? $this->arrToValidate[$key]["name"] : $key;
			$message = "Message not defined";
			if(!empty($this->arrToValidate[$key]["messages"][$rule])){
				$message = $this->arrToValidate[$key]["messages"][$rule];
			}
			else{
				switch ($rule) {
					case 'required':
						$message = $name." is required";
						break;

					case "email":
						$message = $name." is not a valid email address";
					break;

					case "url":
						$message = $name." is not a valid URL";
					break;

					case "minlength":
						$message = $name." must have at least x characters";
					break;

					case "maxlength":
						$message = $name." must have maximum x characters";
					break;

					case "regex":
						$message = $name." doesn't match the requested pattern";
					break;
				}
			}

			$this->arrErrors[] = $message;
			$unset = !empty($this->arrToValidate[$key]["unset"]);
			if($unset) $this->unsetArray[] = $key;
		}

		/**
		 * Will accept a rule with and a value to check the rule against.
		 * Some rules accept an extra argument, you can define this argument like so:
		 * 		$rule = "minlength: 3"
		 */

		public function validateRule($value, $rule, $key=false){

			$filtered = $this->filter($rule);
			$rule = $filtered[0];
			$parameter = $filtered[1];

			switch($rule){

				case "required":
					return $this->checkNotEmpty($value, $key);
				break;

				case "minlength":
					return $this->checkMinlength($value, $parameter, $key);
				break;

				case "maxlength":
					return $this->checkMaxLength($value, $parameter, $key);
				break;

				case "email":
					return $this->checkEmail($value, $key);
				break;

				case "url":
					return $this->checkURL($value, $key);
				break;

				case "regex":
					return $this->checkRegex($value, $parameter, $key);
				break;

				default:

					throw new Exception("Rule not found", 1);
				
				break;

			}

		}

		/**
		 * Function to check if the value is a valud url
		 */

		private function checkURL($value, $key){
			$regex = "/((\w+:\/\/)?[-a-zA-Z0-9:@;?&=\/%\+\.\*!'\(\),\$_\{\}\^~\[\]`#|]+)/";
			$passed = preg_match($regex, $value);
			if(!$passed){
				$this->setError("url", $key);
			}
			return $passed;
		}

		/**
		 * Function to check if the value is an email
		 */

		private function checkEmail($value, $key){
			$regex = "/^([0-9a-zA-Z].*?@([0-9a-zA-Z].*\.\w{2,4}))$/m";
			$passed = preg_match($regex, $value);
			if(!$passed && $key){
				$this->setError("email", $key);
			}
			return $passed;
		}

		private function checkRegex($value, $regex, $key){
			$passed = preg_match($regex, $value);
			if(!$passed && $key){
				$this->setError("regex", $key);
			}
			return $passed;
		}

		/**
		 * Function to check if the value is not empty
		 */

		private function checkNotEmpty($value, $key){
			$passed = strlen($value) >= 1;
			if(!$passed && $key){
				$this->setError("required", $key);
			}
			return $passed;
		}

		/**
		 * Function to check minimum length of given value
		 * If $length is undefined, it will fall back to the default value
		 */

		private function checkMinlength($val, $length, $key){
			if(!$length) $length = 3;
			$passed = (strlen($val) >= $length);
			if(!$passed && $key){
				$this->setError("minlength", $key);
			}
			return $passed;
		}

		/**
		 * Function to check maximum length of given value
		 * If $length is undefined, it will fall back to the default value
		 */

		private function checkMaxLength($val, $length, $key){
			if(!$length) $length = 3;
			$passed = (strlen($val) <= $length);
			if(!$passed){
				$this->arrErrors[] = "maxlengtherror";
			}
			return $passed;
		}

	}

?>