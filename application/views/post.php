<html>
	<head>
		<title>Post by <?php echo $user['name']; ?></title>

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
		<h2><?php echo $user['name']; ?> posted:</h2>
		<h3 style="margin-bottom: 100px;"><?php echo $post['text']; ?></h3>

		<br />

		<h4>Comments</h4>
		<?php
		//	echo "<pre>";
		//var_dump($comments);
		//die();
		foreach($comments as $comment){ ?>
			<p><?php echo "<i>".$comment['user_detail'][0]['name']." said: </i>".$comment['text']; ?></p>
			<br />
		<?php } ?>

		<br /><br />

		<?php
		if($this->session->user_id){
			echo form_open("user/add_comment"); ?>
			<input type="text" autocomplete="off" placeholder="Post comment" name="comment_text" />
			<input type="hidden" name="pid" value="<?php echo (string)$post["_id"]; ?>" />
			<br /><br />

			<input type="submit" name="login" id="login" />
		<?php
			echo form_close();
		}
		?>
	</body>
</html>