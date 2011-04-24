<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html style="margin: 0;padding: 0;">
	<head>
		
	</head>
	<body style="margin: 0;padding: 0;">
		<div id="background" style="background-image: url(http://localhost/themes/bar/images/background.jpg);background-color: #eee;margin: 0;padding: 10px;">
			<div id="container" style="margin: 40px;padding: 10px 20px;background: #fff;">
				<img id="logo" src="http://localhost/themes/bar/images/logo.png" alt="Logo" style="float: left;padding: 10px;">
				<div id="body" style="float: left;padding-left: 20px;">
					<h1 style="font-size: 2.5em;color: #f7d400;margin: 0 0 10px 0;">Bar Newsletter</h1>
					<p style="font-size: 1em;color: #333;">Dear $Member.FirstName,</p>
					$Body
				</div>
				<div id="foot" style="clear: both;text-align: center;margin: 0 auto;padding-top: 30px;">
					<p style="font-size: 1em;color: #333;"><a href="$UnsubscribeLink" style="color: #333;font-weight: bold;">Unsubscribe</a></p>
				</div>
			</div>
		</div>
	</body>
</html>


<!-- Original Code, inlinned with http://www.mailchimp.com/labs/inlinecss.php
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html>
	<head>
		<style>
			html,
			body {
				margin: 0;
				padding: 0;
			}
			#background {
				background-image: url('http://localhost/themes/bar/images/background.jpg');
				background-color: #eee;
				margin: 0;
				padding: 10px;
			}
			#container {
				margin: 40px;
				padding: 10px 20px;
				background: #fff;
			}
			#logo{
				float: left;
				padding: 10px;
			}
			#body {
				float: left;
				padding-left: 20px;
			}
			#foot {
				clear: both;
				text-align: center;
				margin: 0 auto;
				padding-top: 30px;
			}
			h1 {
				font-size: 2.5em;
				color: #f7d400;
				margin: 0 0 10px 0;
			}
			p {
				font-size: 1em;
				color: #333;
			}
			a {
				color: #333;
				font-weight: bold;
			}
		</style>
	</head>
	<body>
		<div id="background">
			<div id="container">
				<img id="logo" src="http://localhost/themes/bar/images/logo.png" alt="Logo"/>
				<div id="body">
					<h1>Bar Newsletter</h1>
					<p>Dear $Member.FirstName,</p>
					$Body
				</div>
				<div id="foot">
					<p><a href="$UnsubscribeLink">Unsubscribe</a></p>
				</div>
			</div>
		</div>
	</body>
</html>
-->