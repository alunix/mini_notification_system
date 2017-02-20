<html>
	<head>
		<title><?php echo $name; ?>'s profile</title>

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

			.post{
				padding: 1%;
			}

			.post_text{
				font-weight: bold;
				font-size: 21px;
			}

		</style>
	</head>

	<body>
		<h1 style="margin-bottom: 100px;"><?php echo $name; ?>'s profile</h1>
		<p><a href="notifications"><?php echo count($notifications); ?> notifications</a></p>
		<br /><br />
		<?php
		if($self){
		echo form_open("user/create_post");
		?>
			<textarea name="post_text" cols="50" placeholder="Post your status?" rows="5"></textarea> 
			<br />
			<input type="submit" name="Post" value="Post">
		<?php
		echo form_close();
		}
		?>
		<br /><br />
		<?php
		if($posts > 0) {
		?>
		<h1>Activity</h1>
		<br /><br />
			<?php foreach($posts as $post) { ?>
				<div class="post">
					<p class="post_text"><?php echo $post['text']; ?></p>

					<p class="details">Posted on: <?php echo strftime("%d %b, %H:%M %P", $post['created_on']); ?></p>

					<?php
					$link = 'posts/'.(string)$post['_id'];
					?>
					<p><a href="<?php echo $link; ?>">Details</a></p>
				</div>
			<?php
			}
		} else{ ?>
			<p style="">No activity yet!</p>
		<?php
		}
		?>

	</body>
</html>