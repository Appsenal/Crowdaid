<?php
echo '<!DOCTYPE html>
		<html>
			<head>
				<meta charset="UTF-8">
				<title>Crowd Aid</title>
				<link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato">
				<style>
					
				</style>
			</head>
			<body>
				<div id="header">
					<h1>SSS API</h1>
				</div>
				<div id="content">
					<h2>How to Use?</h2>
					<p>
					<b>Format:</b><br />
					<span>http://sss.dakbayan.com/api.php/{type of info}/{ss number (without dash)}/</span>
					</p>
					<h3>Examples</h3>
					<p>
						<b>Fetch SSS Member record</b><br />
						<a href="http://sss.dakbayan.com/api.php/member/1006678141/">http://sss.dakbayan.com/api.php/member/1006678141/</a>
					</p>
					<p>
						<b>Fetch SSS Member Details record</b><br />
						<a href="http://sss.dakbayan.com/api.php/memberdetails/1006678141/">http://sss.dakbayan.com/api.php/memberdetails/1006678141/</a>
					</p>
					<p>
						<b>Fetch SSS Member Premium records</b><br />
						<a href="http://sss.dakbayan.com/api.php/premium/1006678141/">http://sss.dakbayan.com/api.php/premium/1006678141/</a>
					</p>
					<p>
						<b>Fetch SSS Member Address/Contact records</b><br />
						<a href="http://sss.dakbayan.com/api.php/contact/1006678141/">http://sss.dakbayan.com/api.php/contact/1006678141/</a>
					</p>
					<p>
						<b>Fetch SSS Member Employment records</b><br />
						<a href="http://sss.dakbayan.com/api.php/employment/1006678141/">http://sss.dakbayan.com/api.php/employment/1006678141/</a>
					</p>
					<p>
						<b>Fetch SSS Member ID Card Information</b><br />
						<a href="http://sss.dakbayan.com/api.php/card/1006678141/">http://sss.dakbayan.com/api.php/card/1006678141/</a>
					</p>
					<p>
						<b>Update SSS Member Information</b><br />
						<span>In Progress</span>
					</p>
				</div>
			</body>
		</html>';
?>