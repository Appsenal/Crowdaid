<div id="request-info-box">
<p>
<b>Post Id: </b><?php echo $this->postData['postid']; ?>
</p>
<p>
<b>Category: </b><?php echo $this->postData['cat']; ?>
</p>
<p>
<b>Title: </b><?php echo $this->postData['title']; ?>
</p>
</div>
<div id="photo-box">
	<p><b>Upload Photo</b></p>
	<div id="photo-upload-form" class="content-box">
		<form action="/<?php echo $this->view; ?>/photo/<?php echo $this->key; ?>" method="post" enctype="multipart/form-data">		
			<input class="file-upload" type="file" name="file" size="25" />
			<input class="button" type="submit" name="submit" value="Submit" />
		</form>
	</div>
	<div id="main-gallery-box" class="gallery-box">
		<p><b>Images for this post:</b></p>
		<?php 
			
			echo (empty($this->imageHTML))?'You have not uploaded any photo yet.':$this->imageHTML;		
		?>
	</div>
	<div class="spacer"></div>
</div>

<?php echo $this->notice; ?><br/>