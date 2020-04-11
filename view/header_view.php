<!DOCTYPE html>
<html>
	<head>
		<!-- Developer: Pierre Amparado -->
		<!-- This will fix the issue in which the css will not load if there is a "/" in the end of the url path - pierre -->
		<base href="/" />
		<meta charset="UTF-8">
		<title>Crowd Aid</title>
		<link rel="stylesheet" type="text/css" href="../styles.css" />	
		<!--link rel="stylesheet" type="text/css" href="http://fonts.googleapis.com/css?family=Lato"-->
		<link href="http://fonts.googleapis.com/css?family=Noto+Sans:400,700" rel="stylesheet" type="text/css" />		
		
		<script type="text/javascript" charset="utf8" src="../scripts/jquery-3.2.1.min.js"></script>
		<?php echo $this->htmlHeader; ?>				
	</head>	
	<body>
		<div id="header">			
			<div id="logo">
				<a href="/">
					<img src="/images/logo.png">
				</a>
			</div>				
			<div id="header-box">
				<?php 
				if ($this->isLogin) {
					echo '<div id="username-label"><span style="color:#36CD52;">Welcome</span> '.$this->username.'</div>';
					echo '<a id="profile" class="link-button" href="/profile">Profile</a>';
					echo '<a id="logout" class="link-button" href="/logout">Logout</a>';					
				}
				else {
					echo '<a id="login" class="link-button" href="/login">Login</a>
						<a id="sign-up" class="link-button" href="/signup">Sign Up</a>';
				}
				?>
			</div>
			<h2><a href="/" style="text-decoration:none;color: #1d8be8;">Crowd Aid</a></h2>
			<span style="font-size:14px;color:#156db5;">We will answer your health or medical needs through crowdsourcing.</span>
		</div>
		<div id="menu">
			<a href="/" <?php echo ($this->view=='home')?'class="menu-selected"':''; ?>>Home</a>
			<?php
			if ($this->isLogin) {
				echo '<a href="/request" '.(($this->view=='request')?'class="menu-selected"':'').'>Request</a> 
					<a href="/offer" '.(($this->view=='offer')?'class="menu-selected"':'').'>Offer</a>';
			}
			?>
			<a href="/about" <?php echo ($this->view=='about')?'class="menu-selected"':''; ?>>About Us</a> 
			<a href="/contact" <?php echo ($this->view=='contact')?'class="menu-selected"':''; ?>>Contact Us</a> 
		</div>