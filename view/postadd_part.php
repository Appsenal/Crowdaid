<div id="request" class="content-box page-content">
	<form action="/<?php echo $this->view; ?>/add" method="post">
		<p>Post Type: <?php echo $this->view; ?></p>
		<p>Category:<br/>
		<select name='category' class='dropdown text'>
			<?php
				echo $this->categories;
			?>
			<!--option value='1' selected>Equipment/Device</option>
			<option value='2'>Monetary</option>
			<option value='3'>Information</option-->
		</select></p>
		<p>Title:<br/>
		<input type="text" name="title" value="" class="text" size="60" required>
		</p>
		<p>Your Story:<br/>
		<textarea rows="5" cols="45" name="posttext" class="text" placeholder="Describe more details here..." required></textarea>
		</p>									
		<p><input type="submit" value="Submit" class="button"></p>
	</form> 
</div>
<?php echo $this->notice; ?><br/>