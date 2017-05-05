<?php
	require_once 'bin/PHPCaller.php';
?>
<!DOCTYPE html>
<html>
<head>
	<title>PHPCaller</title>
	<style type="text/css">
		h1{
			text-align: center;
		}
		.form{
			text-align: center;
		}
		.form fieldset{
			display: inline-block;
			padding: 20px;
		}
		.form-element{
			border-bottom: 1px solid silver;
			margin-bottom: 5px;
			padding-bottom: 5px;
		}
		.response-area{
			margin: 20px;
			border: 1px solid silver;
			padding: 10px;
		}
		.response h3{
			text-align: center;
		}
	</style>
</head>
<body>
	<h1>PHPCALLER - A PHP wrapper for the Truecaller API</h1><hr />
	<div class="form">
		<fieldset>
			<legend>Make TrueCaller API Call</legend>
			<form method="POST">
				<div class="form-element">
					<label>Request Type</label>
					<select name="front">
						<option>Please select type of request</option>
						<option value="search">Query a number</option>
						<option value="list">List all commands</option>
						<option value="help">Show help page</option>
					</select>
				</div>
				<div class="form-element">
					<label>Request Value</label>
					<input type="text" name="option" placeholder="Enter value" />
				</div>
				<input type="submit" value="Send Request">
			</form>
		</fieldset>
	</div>
	<hr />
	<div class="response">
		<h3>API Response</h3>
		<div class="response-area">
			<?php
				if(count($_POST) > 0){
					$argv = array(basename(__FILE__, '.php'));
					if(isset($_POST['front'])){
						$argv[] = $_POST['front'];
					}
					if(isset($_POST['option'])){
						$argv[] = $_POST['option'];
					}
					$phpCaller = new PHPCaller('apache2handler', $argv);
					$phpCaller->newLineCharacter = "\n";
					$phpCaller->tabCharacter = "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
					ob_start();
					$phpCaller->run(false);
					$response = ob_get_clean();
					echo str_replace("\n", "<br />", htmlspecialchars($response));
				}
			?>
		</div>
	</div>
</body>
</html>