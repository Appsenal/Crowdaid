<?php include 'header_view.php'; ?>
		<div id="content">
			<h2>Registration</h2>
			<p>Please enter your account information.</p>
			<div id="register" class="contentbox">
				<form action="/signup" method="post">
					<div>
						<div class="form-label">Email:</div>
						<input type="text" name="email" value="<? echo (isset($_POST['email']))?$_POST['email']:''; ?>" class="text" required />
					</div>
					<div>
						<div class="form-label">Username:</div>
						<input type="text" name="username" value="<? echo (isset($_POST['username']))?$_POST['username']:''; ?>" class="text" required />
					</div>
					<div>
						<div class="form-label">Password:</div>
						<input type="password" name="password" value="" class="text" required />
					</div>
					<div>
						<div class="form-label">Confirm Password:</div>
						<input type="password" name="confirmpass" value="" class="text" required />
					</div>				
					<input type="submit" value="Submit" class="button"><br/>
				</form> 
			</div>
			<?php echo $this->notice; ?><br/>
		</div>
<?php include 'footer_view.php'; ?>