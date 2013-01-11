<body>
<div id="wrapper" class="container">
	<form action="example.php" method="post">
    	<fieldset>
    		<legend>Fill out the form to test out the validation</legend>
    		<div class="col">
	    		<label for="firstname">First name: <span>*</span></label>
	    		<input placeholder="John" type="text" id="firstname" name="firstname" value="<?php if(!empty($_POST["firstname"])) echo $_POST["firstname"] ?>">

	    		<label for="lastname">Last name: <span>*</span></label>
	    		<input placeholder="Doe" type="text" id="lastname" name="lastname" value="<?php if(!empty($_POST["lastname"])) echo $_POST["lastname"] ?>">
    		</div>
    		<div class="col">
	    		<label for="email">Email: <span>*</span></label>
	    		<input placeholder="example@me.com" type="text" id="email" name="email" value="<?php if(!empty($_POST["email"])) echo $_POST["email"] ?>">

	    		<label for="url">Website:</label>
	    		<input placeholder="http://www.example.com/" type="text" id="url" name="url" value="<?php if(!empty($_POST["url"])) echo $_POST["url"] ?>">
    		</div>
    		<div class="col">
	    		<label for="pattern">2 digits followed by 3 letters: <span>*</span></label>
	    		<input placeholder="12abc" type="text" id="pattern" name="pattern" value="<?php if(!empty($_POST["pattern"])) echo $_POST["pattern"] ?>">

	    		<label for="minmax">Min. 3 characters, max. 10:</label>
	    		<input placeholder="someValue" type="text" id="minmax" name="minmax" value="<?php if(!empty($_POST["minmax"])) echo $_POST["minmax"] ?>">
    		</div>
    		<div class="clear">&nbsp;</div>
    	</fieldset>
		<input type="submit" name="btnSubmit">
    </form>
    <div id="push">&nbsp;</div>
</div>
<div id="footer">
  <div class="container">
    <p class="muted credit">PHP Form Validator by <a href="http://martinbean.co.uk">Sabatino Masala</a></p>
  </div>
</div>
<script src="http://code.jquery.com/jquery-latest.js"></script>
<script src="js/bootstrap.min.js"></script>
</body>