<?php

include('includes/config.php');

?>
<html>
<head>
	<title>NHL - Teams &amp; Players streaks</title>

	<script src="//ajax.googleapis.com/ajax/libs/jquery/2.0.3/jquery.min.js"></script>
	<script src="//ajax.googleapis.com/ajax/libs/jqueryui/1.10.3/jquery-ui.min.js"></script>
	<script src="<?=URI_JS;?>/nhl-streaks.js"></script>

	<link rel="stylesheet" href='<?=URI_CSS;?>/dark-hive/jquery-ui-1.10.3.custom.min.css' type='text/css' media='all' />
	<link rel="stylesheet" href='<?=URI_CSS;?>/nhl-streaks.css' type='text/css' media='all' />

</head>
<style type="text/css">

</style>
<body>
	<a href="https://github.com/emilegirard/nhl-streaks"><img style="position: absolute; top: 0; left: 0; border: 0;" src="https://s3.amazonaws.com/github/ribbons/forkme_left_darkblue_121621.png" alt="Fork me on GitHub"></a>

	<h1>Actions</h1>
	<ul>
		<li><a href="?ajax=true&action=update">Update Data</a></li>
		<li><a href="?ajax=true&action=view">View</a></li>
	</ul>

	<div id="result">

	</div>

</body>
</html>