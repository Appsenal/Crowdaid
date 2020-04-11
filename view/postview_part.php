<div id="post-box" class="content-box">
	<div id="view-box" class="content-box">
		<div class="tab-label">
			<?php 
			echo '<a class="tab '.(($this->query=='view')?'tab-focus':'').'" href="/'.$this->view.'/view/'.$this->key.'">Info</a>
			<a class="tab '.(($this->query=='photo')?'tab-focus':'').'" href="/'.$this->view.'/photo/'.$this->key.'">Photo</a>
			<a class="tab '.(($this->query=='response')?'tab-focus':'').'" href="/'.$this->view.'/response/'.$this->key.'">Response</a>';
			?>
		</div>
		<div class="tab-content">
			<?php if ($this->query=='view') {?>
				<p><b>Post Id: </b><?php echo $this->postData['postid']; ?></p>
				<p><b>Category: </b><?php echo $this->postData['cat']; ?></p>
				<p><b>Title: </b><?php echo $this->postData['title']; ?></p>
				<p><b>Story: </b><?php echo $this->postData['posttext']; ?></p>
				<p><b>Posted By: </b><?php echo $this->postData['username']; ?></p>
				<p><b>Email: </b><?php echo $this->postData['email']; ?></p>
			<?php
				if ($this->isPostOwner) {					
					$infobeginform='<form action="/'.$this->view.'/view/'.$this->key.'" method="post" name="cancelpost">';
					//if ($this->isResponseAccepted) {
					if ($this->isPostAccepted) {
						echo $infobeginform.'<input type="submit" name="close" value="Close this '.$this->view.'" class="button">';
						echo '</form>';
					}
					elseif ($this->isPostClosed) {
						echo '<p>This post is closed.</p>';
					}
					else {
						//$infohtml='<input type="submit" name="cancel" value="Cancel this '.$this->view.'" class="button">';
						echo $infobeginform.'<input type="submit" name="cancel" value="Cancel this '.$this->view.'" class="button">';
						echo '</form>';
					}
					
				}
			}
			elseif ($this->query=='photo') {
				if ($this->isPostOwner) {
					if ($this->isPostClosed) {
					}
					else {
			?>
					<p><b>Upload Photo</b></p>
					<div id="photo-upload-form" class="content-box">
						<form action="/<?php echo $this->view; ?>/photo/<?php echo $this->key; ?>" method="post" enctype="multipart/form-data">	
							<p>Title: <input type="text" name="title" value="" class="text" size="60" required></p>
							<p>Caption: <input type="text" name="caption" value="" class="text" size="60"></p>
							<input class="file-upload" type="file" name="file" size="25" /><br />
							<input class="button" type="submit" name="submit" value="Upload" />
						</form>
					</div>
					<?php }}?>
					<div id="main-gallery-box" class="gallery-box">
						<p><b>Images for this post:</b></p>
						<?php 
							echo (empty($this->imageHTML))?'<p>No photos has been uploaded yet.</p>':$this->imageHTML;		
						?>
					</div>	
			<?php 	
					} 
			else {				
					echo $this->responseHTML;
			}?>
			<div class="spacer content-box"></div>
		</div>
		<?php echo $this->postHTML; ?>
	</div>
</div>	
