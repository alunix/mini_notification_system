<html>
	<head>
		<title>Signup</title>

		<style type="text/css">
			* {
				padding: 0;
				margin: 0;
			}

			body{
				width: 80%;
				height:90%;
				padding-top: 100px;

				text-align: center;
			}

		</style>
	</head>

	<body>
		<h2 style="margin-bottom: 100px;">Signup</h2>

		<?php echo form_open(); ?>
			<input type="text" name="name" id="name" placeholder="Name?" />
			<br />
			<input type="text" name="email" id="email" placeholder="Email?" />
			<br />
			<input type="password" name="password" id="password" placeholder="Password?" />
			<br />

			<input type="submit" name="signup" id="signup" value="Sign Up" />
		<?php echo form_close(); ?>
	</body>
</html>