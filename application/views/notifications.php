<html>
	<head>
		<title>Your Notifications</title>

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
		<h1 style="margin-bottom: 100px;">Unread Notifications</h1>

		<div id="notification_details">
			<?php
			foreach($notifications as $notification){
				?>
				<p><a href="posts/<?php echo (string)$notification['post_id']; ?>"><?php echo $notification['user_detail'][0]['name']." commented on a post</a>"; ?></p>
				<?php
			}
			?>
		</div>

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js" type="text/javascript"></script>

		<script type="text/javascript">
			$(document).ready(function() {
				var errorSleepTime = 2000;

				function long_polling() {
				    $.ajax({
				    	url: "http://139.59.38.45:8080/mini_notif_server",
				    	data: {key: "<?php echo $this->session->current_key; ?>"},
				    	dataType: "json",
				    	type: "GET",
				        success: function(response) {
				        	console.log(response);
				        	console.log(response.notification);

				        	$("#notification_details").append(response.notification);
				        	long_polling();
				        	// resets the value in case things get normal after a brief issue
				        	errorSleepTime = 2000;
				    	}, error: function(response) {
				    		errorSleepTime *= 2;
				    		console.log("errorSleepTime is: "+errorSleepTime);

				    		setTimeout(function() {
					        	long_polling();
					        }, errorSleepTime);
				        }
				    });
				};
				long_polling();
			});
		</script>

	</body>
</html>