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

		<?php
		//header('Access-Control-Allow-Origin: *');

		header("Access-Control-Allow-Origin: http://139.59.38.45");
		header('Access-Control-Allow-Methods: GET, POST, PATCH, PUT, DELETE, OPTIONS');
		header('Access-Control-Allow-Headers: Origin, Content-Type, X-Auth-Token');
		?>

	</head>

	<body>
		<h1 style="margin-bottom: 100px;">Notifications</h1>

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
				function poll() {
					// var args = []
					// args.key = <?php echo $this->session->current_key; ?>;
				    // var args = form.formToDict();

				    $.postJSON("http://139.59.38.45:8080/mini_notif_server", function(response) {
				        alert("Got it!");
				        console.log(response);
				    });
				    setTimeout(function() {
			        	poll();
			        }, 10000);
				};

				jQuery.postJSON = function(url, callback) {
				    $.ajax({
				    	url: url,
				    	data: {key: "<?php echo $this->session->current_key; ?>"},
				    	dataType: "json",
				    	type: "GET",
				    	// crossDomain: true,
				        success: function(response) {
				        	// if (callback) callback(eval("(" + response + ")"));
				        	console.log(response);
				        	console.log(response.notification);

				        	$("#notification_details").append(response.notification);
				    	}, error: function(response) {
				        	console.log("ERROR:", response);
				        }
				    });
				};
				poll();
			});
		</script>

	</body>
</html>