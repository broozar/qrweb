<?php

function checkCaptcha($url = "https://captcheck.netsyms.com/api.php")
{
	if (empty($_POST['captcheck_session_code']))
		return "";

	$data = [
		'session_id' => $_POST['captcheck_session_code'],
		'answer_id' => $_POST['captcheck_selected_answer'],
		'action' => "verify"
	];
	$options = [
		'http' => [
			'header' => "Content-type: application/x-www-form-urlencoded\r\n",
			'method' => 'POST',
			'content' => http_build_query($data)
		]
	];
	$context = stream_context_create($options);
	$result = file_get_contents($url, false, $context);
	$resp = json_decode($result, TRUE);
	if (!$resp['result']) {
		return "<div class='error'>CAPTCHA did not verify: " . $resp['msg'] . "</div>";
	} else {
		return "verified";
	}
}
