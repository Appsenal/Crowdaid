<?php
if ($this->query=='add') {
	$this->subTitle='- New';
	$this->categories='';	
	//$this->postHTML='';
	$result=$this->post->GetCategories();
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		if ($row['id']==1) {
			$this->categories=$this->categories."<option value='1' selected>".$row['title']."</option>";
		}
		else {
			$this->categories=$this->categories."<option value='".$row['id']."'>".$row['title']."</option>";
		}
	}
	if ($this->view=='request') {
		//$this->subTitle='- New Request';
	}
	else {
		//$this->subTitle='- New Offer';
	}
}
elseif ($this->query=='photo') {
	$this->subTitle='- View';
	$this->key=array_shift($this->urlPath);
	if (empty($this->key)) {
		$this->RedirectPage($this->view);
	}
	$this->isPostClosed=$this->post->IsPostClosed($this->key);
	$this->GetPostDataById($this->key);
	$this->GetImagesByPostHTML($this->key);
	if ($this->postUser==$this->userid) {
		$this->isPostOwner=true;
	}
}
elseif ($this->query=='response') {
	$this->subTitle='- View';
	$this->key=array_shift($this->urlPath);
	if (empty($this->key)) {
		$this->RedirectPage($this->view);
	}
	$this->GetPostDataById($this->key);
	//$this->GetImagesByPostHTML($this->key);
	//Determine if the post returned is owned by the user
	if ($this->postUser==$this->userid) {
		$this->isPostOwner=true;
		$responseCount=0;
		$this->responseHTML='';
		$parentid=$this->response->GetParentId($this->key, $this->userid);		
		//$this->isResponseAccepted=$this->response->IsReponseAccepted($parentid);
		$responsestatus=$this->response->GetResponseStatus($parentid);
		//(($responsestatus==0)?"<b style='color:#c92c2c;'>[You have rejected this response]</b>":"").
		$result=$this->response->GetInitialResponsesByPostId($this->key);		
		$responseCount=$result->num_rows;
		$this->responseHTML='<p><b>There is/are '.$responseCount.' response(s) for this post.</b></p>';
		while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
			$this->responseHTML=$this->responseHTML.'<button class="accordion"><b>'.$row['username'].'</b> responded - click to view discussion. '.(($responsestatus==1)?"<b style='color:#5bcc00;'>[You have accepted this response]</b>":"").'</button>';
			$this->responseHTML=$this->responseHTML.'<div class="panel"><p>';
			$this->responseHTML=$this->responseHTML.'<b>'.$row['username'].'</b> on <b>'.$row['date'].'</b> said:<br/>';
			$this->responseHTML=$this->responseHTML.$row['comment'];
			
			$responseimage=NULL;
			$responseimage=$this->image->GetImageByResponseId($row['id']);
			if ($responseimage!=NULL) {
				$this->responseHTML=$this->responseHTML.'<br/><a target="_blank" href="../images/uploads/'.$responseimage['filename'].'">
					<img src="../images/uploads/'.$responseimage['filename'].'" alt="'.$responseimage['imagetitle'].'" width="300" height="200">
					</a><br/>';
			}
			
			$result2=$this->response->GetPostResponsesByParentId($row['id']);
			while ($row2 = $result2->fetch_array(MYSQLI_ASSOC)) {
				//$this->responseHTML=$this->responseHTML.'<div class="panel">';
				$this->responseHTML=$this->responseHTML.'<br/><b>'.$row2['username'].'</b> on <b>'.$row2['date'].'</b> said:<br/>';
				$this->responseHTML=$this->responseHTML.$row2['comment'];
				
				$responseimage=NULL;
				$responseimage=$this->image->GetImageByResponseId($row2['id']);
				if ($responseimage!=NULL) {
					$this->responseHTML=$this->responseHTML.'<br/><a target="_blank" href="../images/uploads/'.$responseimage['filename'].'">
									<img src="../images/uploads/'.$responseimage['filename'].'" alt="'.$responseimage['imagetitle'].'" width="300" height="200">
									</a><br/>';
				}
			}
			$result2->close();
			$this->responseHTML=$this->responseHTML.'</p><p><b>Respond to the comment</b></p>				
				<form action="/'.$this->view.'/'.$this->query.'/'.$this->key.'" method="post">
					<textarea rows="3" cols="45" name="comment" class="text" placeholder="Post your message here..." required></textarea>
					<br />
					<input type="submit" name="submit-comment" value="Submit" class="button"><br/>
				</form>
				<br />';			
			if (!$this->isResponseAccepted) {
				$this->responseHTML=$this->responseHTML.'
				<form action="/'.$this->view.'/response/'.$this->key.'" method="post" name="acceptresponse">
						<input type="submit" name="accept" value="Accept" class="button">
						<!--input type="submit" name="reject" value="Reject" class="button"-->			
				</form><br/>';
			}
			$this->responseHTML=$this->responseHTML.'<br />
				</div>';

		}
		$result->close();
		$this->responseHTML=$this->responseHTML.'<script>var acc = document.getElementsByClassName("accordion");
				var i;

				for (i = 0; i < acc.length; i++) {
					acc[i].onclick = function(){
						/* Toggle between adding and removing the "active" class,
						to highlight the button that controls the panel */
						this.classList.toggle("active");

						/* Toggle between hiding and showing the active panel */
						var panel = this.nextElementSibling;
						if (panel.style.display === "block") {
							panel.style.display = "none";
						} else {
							panel.style.display = "block";
						}
					}
				}</script>'; 
	}
	else {
		$this->responseHTML='';
		$discussionCount=0;
		$result=$this->response->GetPostResponses($this->key, $this->userid);
		if ($result!=NULL) {
			$discussionCount=$result->num_rows;
			$this->responseHTML='<p><b>There is/are '.$discussionCount.' conversation(s) for this post.</b></p><div class="panel-box"><p>';
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
					$this->responseHTML=$this->responseHTML.'<b>'.$row['username'].'</b> on <b>'.$row['date'].'</b> said:<br/>';
					$this->responseHTML=$this->responseHTML.$row['comment'].'<br/>';
					$responseimage=NULL;
					$responseimage=$this->image->GetImageByResponseId($row['id']);
					if ($responseimage!=NULL) { 
						$this->responseHTML=$this->responseHTML.'<a target="_blank" href="../images/uploads/'.$responseimage['filename'].'">
											<img src="../images/uploads/'.$responseimage['filename'].'" alt="'.$responseimage['imagetitle'].'" width="300" height="200">
											</a><br/>';
					}
					//<a href="/'.$this->view.'/respond/'.$this->key.'">Reply</a>
			}
		}
		$this->responseHTML=$this->responseHTML.'</p><p><b>Respond to the '.(($discussionCount==0)?"post":"comment").'</b></p>
				<form action="/'.$this->view.'/'.$this->query.'/'.$this->key.'" method="post" enctype="multipart/form-data">		
					<input class="file-upload" type="file" name="file" size="25" />
					<input class="button" type="submit" name="upload" value="Upload" />
				</form>
							<form action="/'.$this->view.'/'.$this->query.'/'.$this->key.'" method="post">
								<textarea rows="3" cols="45" name="comment" class="text" placeholder="Post your message here..." required></textarea>
								<br />
								<input type="submit" value="Submit" class="button"><br/>
							</form>
							<br />
						</div>';
	}
}
elseif ($this->query=='view') {
	$this->subTitle='- View';
	$this->key=array_shift($this->urlPath);
	if (empty($this->key)) {
		$this->RedirectPage($this->view);
	}
	else {
		$this->parentId=$this->response->GetParentId($this->key, $this->userid);
		//$this->isResponseAccepted=$this->response->IsReponseAccepted($this->parentId);
		$this->isPostAccepted=$this->post->IsPostAccepted($this->key);
		$this->isPostClosed=$this->post->IsPostClosed($this->key);
		$this->GetPostDataById($this->key);
		if ($this->postUser==$this->userid) {
			$this->isPostOwner=true;
			/* Perfrom matching */
			$texttoapi=$this->postData['title'].' '.$this->postData['posttext'];
			//echo $texttoapi;
			if (!empty($texttoapi)) {
				$this->LoadAPIClass();
				if ($this->API->ClassifyText($texttoapi)==0) {
					$apiresponse=$this->API-> GetResponse();
					$api_array=json_decode($apiresponse);
					//echo $api_array['concept_list'][0]['form'];
					//echo '<br />';
					//echo $apiresponse;
					$formatching='';
					if ($api_array->status->code==0) {
						foreach($api_array->concept_list as $concept_list) {
							//$concept_list->form;
							if (!empty($formatching)) {
								$formatching=$formatching.' or ';
							}
							$formatching=$formatching."a.title like '%".$concept_list->form."%'";
							$formatching=$formatching." or a.posttext like '%".$concept_list->form."%'";
						}
						//echo $formatching;
						//if request, pull the data from offer. vice versa.
						if ($this->view=='request') {
							$posttype=1;
						}
						else {
							$posttype=0;
						}
						$this->postHTML='<div class="content-box" style="margin-top: 15px;">';
						$htmlTxt='';
						$result=$this->post->GetPostMatchingTextByType($posttype,$formatching);
						if (isset($result)) {
							while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
								$htmlTxt=$htmlTxt.'<a href="/'.(($row['type']==0)?'request':'offer').'/view/'.$row['postid'].'">'.$row['postid'].'-'.$row['title'].' posted by: '.$row['username'].'</a><br/>';
							}
						}
						if (empty($htmlTxt)) {
							$htmlTxt='<p>No match found.</p>';
						}
						$this->postHTML=$this->postHTML.'<p><b>Suggested match to your post:</b><br />'.$htmlTxt.'</p></div>';
					}
				}
			}
		}
	}
	//$this->GetImagesByPostHTML($this->key);	
}
else {
	$this->htmlHeader='<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
		<script type="text/javascript" charset="utf8" src="../scripts/datatables/jquery.dataTables.min.js"></script>
		<script type="text/javascript">
			$(document).ready( function () {
				$("#logged-home-request").DataTable({
					"iDisplayLength": 10
				})} );
		</script>'; 
	
	if ($this->view=='request') {
		$posttype=0;
	}
	else {
		$posttype=1;
	}

	/* 0-closed, 1-open, 2-accepted, 3-cancelled */
	if ($this->query=='accepted') {
		$status=2;	
	}
	elseif ($this->query=='closed') {
		$status=0;
	}
	elseif ($this->query=='cancelled') {
		$status=3;
	}
	else {
		$status=1;
	}

	$this->requestTable='<table id="logged-home-request" width="100%">';
	$this->requestTable=$this->requestTable.'<thead><tr>';
	$this->requestTable=$this->requestTable.'<th>Post Id</th>';
	$this->requestTable=$this->requestTable.'<th>Category</th>';
	$this->requestTable=$this->requestTable.'<th>Title</th>';
	$this->requestTable=$this->requestTable.'<th>Status</th>';
	$this->requestTable=$this->requestTable.'<th>Action</th>';
	$this->requestTable=$this->requestTable.'</tr></thead><tbody>';
							
	//$result=$this->post->GetPostByTypeByUser($posttype,$this->userid);
	if ($this->query=='responded') {
		$result=$this->post->GetUserRespondedPosts($posttype,$this->userid);
	}
	else {
		$result=$this->post->GetPostByTypeByUserByStatus($posttype,$this->userid,$status);
	}
	$this->userPostCount=$result->num_rows;
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$this->requestTable=$this->requestTable.'<tr>';
		$this->requestTable=$this->requestTable.'<td>'.$row['postid'].'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$row['cat'].'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$row['title'].'</td>';

		switch ($row['status']) {
			case 0:
				$this->requestTable=$this->requestTable.'<td>Closed</td>'; break;
			case 1:
				$this->requestTable=$this->requestTable.'<td>Open</td>'; break;
			case 2:
				$this->requestTable=$this->requestTable.'<td>Accepted</td>'; break;
			case 3:
				$this->requestTable=$this->requestTable.'<td>Cancelled</td>'; break;
		}
		//$this->requestTable=$this->requestTable.'<td>'.$row[3].'</td>';
					
		$linkphoto='<a href="/'.(($row['type']==0)?'request':'offer').'/photo/'.$row['postid'].'">Photo</a>';
		//$linkupdate='<a href="/'.(($row[1]==0)?'request':'offer').'/update/'.$row[0].'">Update</a>';
		$linkresponse='<a href="/'.(($row['type']==0)?'request':'offer').'/response/'.$row['postid'].'">Responses</a>';
		$linkview='<a href="/'.(($row['type']==0)?'request':'offer').'/view/'.$row['postid'].'">View</a>';
		//$linkdelete='<a href="/'.(($row[1]==0)?'request':'offer').'/delete/'.$row[0].'">Delete</a>';
							
		//$this->requestTable=$this->requestTable.'<td>'.$linkphoto.' | '.$linkupdate.' | '.$linkdelete.'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$linkview.' | '.$linkphoto.' | '.$linkresponse.'</td>';
		$this->requestTable=$this->requestTable.'</tr>';
	}					
	$this->requestTable=$this->requestTable.'</tbody></table>';
	$result->close();	
}
?>