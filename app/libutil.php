<?php
function message($body) {
echo <<<EOF
	<html>
	<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	</head>
	<body>
	$body
	</body>
	</html>
EOF;
	exit();
}
?>