<?php
if ($this->query=='photo') {
	$imageid=0;	
	$this->subTitle='- Photo';
	$this->key=array_shift($this->urlPath);
	if (!empty($this->key)) {			
		//$this->GetPostDataById($this->key);	
		if ($this->UploadFile()) {
			$imageid=$this->image->AddImage($_POST['title'], $this->fileName, $this->fileTargetLocation, $_POST['caption']);
			if ($imageid!=0) {
				if ($this->image->AddPostImage($imageid,$this->key)) {
					$this->notice="<span class='notice'>The image was saved successfully.</span>";
				}
				else {
					$this->notice="<span class='notice fail'>There is a problem when linking the post and image.</span>";
				}
			}
			else {
				$this->notice="<span class='notice fail'>There is a problem saving the image.</span>";
			}
		}
		//$this->GetImagesByPostHTML($this->key);
	}
	$this->RedirectPage($this->view.'/'.$this->query.'/'.$this->key);
	//$this->LoadRequest();	
}
elseif ($this->query=='add') {
	if ($this->view=='request') {
		$posttype=0;
	}
	else {
		$posttype=1;
	}
	
	if ($this->ValidInput()) {
		if ($this->post->AddPost($posttype, $_POST['category'], $_POST['title'], $_POST['posttext'], $this->userid, 1)) {
			$this->notice="<span class='notice'>Your post was saved successfully.</span>";
		}
		else {
			$this->notice="<span class='notice fail'>Something is wrong.</span>";
		}
	}
	$this->RedirectPage($this->view);
}
elseif ($this->query=='response') {
	$parentid=0;
	$responseid=NULL;
	$this->key=array_shift($this->urlPath);
	$parentid=$this->response->GetParentId($this->key, $this->userid);
	//if (isset($_POST['submit-comment'])) {
	if (isset($_POST['comment']) || !empty($_POST['comment'])) {
		$responseid=$this->response->AddResponse($this->key, $this->userid, $_POST['comment'],$parentid);
		//if ($this->response->AddResponse($this->key, $this->userid, $_POST['comment'],$parentid)) {
		//	$this->notice="<span class='notice'>Your response message was saved successfully.</span>";
		//}
		//else {
		//	$this->notice="<span class='notice fail'>Failed to save your response message.</span>";
		//}
	}		
	elseif (isset($_POST['accept'])) {
		//echo 'accepted';
		$this->post->SetPostAccepted($this->key);
		$this->response->AcceptResponse($this->key, $this->userid, $parentid);
	}
	elseif (isset($_POST['reject'])) {
		//echo 'rejected';
		$this->response->RejectResponse($this->key, $this->userid, $parentid);
	}
	elseif (isset($_POST['upload'])) {
		//upload photo		
		if ($this->UploadFile()) {
			$responseid=$this->response->AddResponse($this->key, $this->userid, '*photo uploaded*',$parentid);
			$imageid=$this->image->AddImage('Response#'.$this->key, $this->fileName, $this->fileTargetLocation, '');
			if ($imageid!=0) {
				if ($this->image->AddResponseImage($imageid,$responseid)) {
					$this->notice="<span class='notice'>The image was saved successfully.</span>";
				}
				else {
					$this->notice="<span class='notice fail'>There is a problem when linking the post and image.</span>";
				}
			}
			else {
				$this->notice="<span class='notice fail'>There is a problem saving the image.</span>";
			}
		}
		//$this->GetImagesByResponseHTML($this->key);
	}
	else {}

	$this->RedirectPage($this->view.'/'.$this->query.'/'.$this->key);
}
elseif ($this->query=='view') {
	$this->key=array_shift($this->urlPath);
	if (isset($_POST['close'])) {
		$this->post->SetPostClosed($this->key);
	}
	$this->RedirectPage($this->view.'/'.$this->query.'/'.$this->key);
}
else {
	
}

?>