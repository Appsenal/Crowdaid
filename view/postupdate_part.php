<div id="post-view-box" class="content-box">
	<p><b>Post Id: </b><?php echo $this->postData['postid']; ?></p>
	<p><b>Category: </b><?php echo $this->postData['cat']; ?></p>
	<p><b>Title: </b><?php echo $this->postData['title']; ?></p>
	<p><b>Description: </b><?php echo $this->postData['posttext']; ?></p>
	<p><b>Posted By: </b><?php echo $this->postData['username']; ?></p>
	<p><b>Email: </b><?php echo $this->postData['email']; ?></p>
	<div id="main-gallery-box" class="gallery-box">
		<p><b>Images for this post:</b></p>
		<?php 			
			echo (empty($this->imageHTML))?'The poster have not uploaded any photo yet.':$this->imageHTML;		
		?>
	</div>
	<div class="spacer content-box"></div>
</div>	
<div id="comment-box" class="content-box">
	<br />
	<?php //if ($this->query=='respond') {
			echo '<h3>Responses</h3><br/>';
			if (empty($this->responseHTML)) {
				echo 'You did not respond this post yet.';
			}
			else {
				echo $this->responseHTML;
			}
			echo '<p><b>Respond to the post</b></p>
			<form action="/'.$this->view.'/'.$this->query.'/'.$this->key.'" method="post">
				<textarea rows="3" cols="45" name="comment" class="text" placeholder="Post your message here..." required></textarea>
				<br />
				<input type="submit" value="Submit" class="button"><br/>
			</form>';		
		//}
		//else {
			//if (empty($this->responseHTML)) {
				
			//}
			//else {
				//echo '<h3>Responses</h3><br/>';
				//echo $this->responseHTML;
				//echo '<a id="respond-request" class="link-button" href="/'.$this->view.'/respond/'.$this->key.'">Respond to this post</a>';
			//}
		//}
	?>
</div>

<?php if ($this->query=='respond') {
	}
	else {
		/*echo '<div id="comment-box" class="content-box">
			<p><b>Discussion</b></p>
			<form action="/'.$this->view.'/'.$this->query.'/'.$this->key.'" method="post">
				<textarea rows="3" cols="45" name="comment" class="text" placeholder="Post your comment here..." required></textarea>
				<br />
				<input type="submit" value="Submit" class="button"><br/>
			</form> 
		</div>';*/
	}
?>