<?php include 'header_view.php'; ?>
		<div id="content">
			<h2>Login</h2>
			<p>Please enter your username and password.</p>
			<div id="login" class="contentbox">
				<form action="/login" method="post">
					<!--Username:<br/-->
					<input type="text" name="username" value="" class="text" required placeholder="Enter Username">
					<br/>
					<!--Password:<br/-->
					<input type="password" name="password" value="" class="text" required placeholder="Enter Password">
					<br/>									
					<input type="submit" value="Login" class="button"><br/>
				</form> 
			</div>
			<?php echo $this->notice; ?><br/>
		</div>
<?php include 'footer_view.php'; ?>