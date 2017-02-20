<html>
	<head>
		<title>Login</title>

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
		<h2 style="margin-bottom: 100px;">Login</h2>

		<?php echo form_open(); ?>
			<input type="text" name="email" id="email" />
			<br />
			<input type="password" name="password" id="password" />
			<br />

			<input type="submit" name="login" id="login" />
		<?php echo form_close(); ?>
	</body>
</html>