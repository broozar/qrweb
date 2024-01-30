<?php
require("qrcode.php");
require("captcha.php");
?>

<!DOCTYPE html>
<html lang="en">
<head>
	<title>QR Code Generator</title>
	<meta charset="utf-8">
	<style>
        * {
            font-family: Helvetica, sans-serif;
            box-sizing: border-box;
        }

        html {
            width: 100%;
            min-height: 100vh;
        }

        body {
            padding: 0;
            margin: 0;
            min-height: 100vh;
            display: flex;
        }

        h1 {
            font-size: 2em;
            margin: 0 0 0.5em 0;
            padding: 0;
        }

        #content {
            margin: auto;
            width: 50%;
            min-width: 200px;
            max-width: 600px;
            padding: 1em;
            background-color: #eeeeee;
            border: #dddddd 1px solid;
        }

        .error {
            display: block;
            color: white;
            background-color: #dd0000;
            border: #cc0000 1px solid;
            margin: 1em 0 1em 0;
            padding: 0.5em;
        }

        .qrimage {
            margin: 0 0 1em 0;
        }

        input[type=text] {
            background-color: #fafafa;
            border: 0;
            padding: 10px 15px 10px 15px;
            font-size: 1em;
            width: 100%;
            margin: 0 0 1em 0;
        }

        input[type=text]:hover {
            background-color: white;
            transition: background 0.2s;
        }

        input[type=submit] {
            display: inline-block;

            padding: 10px 15px 10px 15px;

            font-size: 1em;
            text-align: center;

            color: #fff;
            background-color: #646464;
            border: 0;
            margin: 1em 0 0 0;
        }

        input[type=submit]:hover {
            background-color: #8c8c8c;
            transition: background 0.2s;
        }

	</style>
	<script src="https://captcheck.netsyms.com/captcheck.min.js"></script>
</head>
<body>
<div id="content">
	<h1>QR Code Generator</h1>

	<?php
	$captcha = checkCaptcha();
	if (!empty($captcha)) {
		if (strcmp($captcha, "verified") === 0) {
			$generator = new WF_QRCode($_REQUEST['encodeURL'], $_REQUEST);
			ob_start();
			$image = $generator->render_image();
			imagepng($image);
			$png = ob_get_clean();
			imagedestroy($image);
			echo sprintf("<img src='data:image/png;base64,%s' alt='qrcode_image' class='qrimage'>", base64_encode($png));
		} else {
			echo $captcha;
		}
	}
	?>

	<form method="post">
		<input type="text" name="encodeURL" placeholder="Target URL">
		<input type="hidden" name="s" value="qr">
		<div class="captcheck_container"></div>
		<input type="submit">
	</form>

</div>
</body>
</html>