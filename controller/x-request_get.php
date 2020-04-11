<?php
//if (isset($_SERVER['add'])) {
//	$this->query=$_SERVER['add'];
//}
//echo $this->query;
if ($this->query=='add') {	
}
elseif ($this->query=='photo') {
	$this->htmlHeader='<!-- Fine Uploader New/Modern CSS file
		====================================================================== -->
		<link href="../scripts/fine-uploader/fine-uploader-new.css" rel="stylesheet">

		<!-- Fine Uploader JS file
		====================================================================== -->
		<script src="../scripts/fine-uploader/fine-uploader.js"></script>

		<!-- Fine Uploader Thumbnails template w/ customization
		====================================================================== -->
		<script type="text/template" id="qq-template-manual-trigger">
			<div class="qq-uploader-selector qq-uploader" qq-drop-area-text="Drop files here">
				<div class="qq-total-progress-bar-container-selector qq-total-progress-bar-container">
					<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-total-progress-bar-selector qq-progress-bar qq-total-progress-bar"></div>
				</div>
				<div class="qq-upload-drop-area-selector qq-upload-drop-area" qq-hide-dropzone>
					<span class="qq-upload-drop-area-text-selector"></span>
				</div>
				<div class="buttons">
					<div class="qq-upload-button-selector qq-upload-button">
						<div>Select files</div>
					</div>
					<button type="button" id="trigger-upload" class="btn btn-primary">
						<i class="icon-upload icon-white"></i> Upload
					</button>
				</div>
				<span class="qq-drop-processing-selector qq-drop-processing">
					<span>Processing dropped files...</span>
					<span class="qq-drop-processing-spinner-selector qq-drop-processing-spinner"></span>
				</span>
				<ul class="qq-upload-list-selector qq-upload-list" aria-live="polite" aria-relevant="additions removals">
					<li>
						<div class="qq-progress-bar-container-selector">
							<div role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" class="qq-progress-bar-selector qq-progress-bar"></div>
						</div>
						<span class="qq-upload-spinner-selector qq-upload-spinner"></span>
						<img class="qq-thumbnail-selector" qq-max-size="100" qq-server-scale>
						<span class="qq-upload-file-selector qq-upload-file"></span>
						<span class="qq-edit-filename-icon-selector qq-edit-filename-icon" aria-label="Edit filename"></span>
						<input class="qq-edit-filename-selector qq-edit-filename" tabindex="0" type="text">
						<span class="qq-upload-size-selector qq-upload-size"></span>
						<button type="button" class="qq-btn qq-upload-cancel-selector qq-upload-cancel">Cancel</button>
						<button type="button" class="qq-btn qq-upload-retry-selector qq-upload-retry">Retry</button>
						<button type="button" class="qq-btn qq-upload-delete-selector qq-upload-delete">Delete</button>
						<span role="status" class="qq-upload-status-text-selector qq-upload-status-text"></span>
					</li>
				</ul>

				<dialog class="qq-alert-dialog-selector">
					<div class="qq-dialog-message-selector"></div>
					<div class="qq-dialog-buttons">
						<button type="button" class="qq-cancel-button-selector">Close</button>
					</div>
				</dialog>

				<dialog class="qq-confirm-dialog-selector">
					<div class="qq-dialog-message-selector"></div>
					<div class="qq-dialog-buttons">
						<button type="button" class="qq-cancel-button-selector">No</button>
						<button type="button" class="qq-ok-button-selector">Yes</button>
					</div>
				</dialog>

				<dialog class="qq-prompt-dialog-selector">
					<div class="qq-dialog-message-selector"></div>
					<input type="text">
					<div class="qq-dialog-buttons">
						<button type="button" class="qq-cancel-button-selector">Cancel</button>
						<button type="button" class="qq-ok-button-selector">Ok</button>
					</div>
				</dialog>
			</div>
		</script>
		<style>
        #trigger-upload {
            color: white;
            background-color: #00ABC7;
            font-size: 14px;
            padding: 7px 20px;
            background-image: none;
        }

        #fine-uploader-manual-trigger .qq-upload-button {
            margin-right: 15px;
        }

        #fine-uploader-manual-trigger .buttons {
            width: 36%;
        }

        #fine-uploader-manual-trigger .qq-uploader .qq-total-progress-bar-container {
            width: 60%;
        }
		</style>';
		//$this->htmlHeader='';
}
else {
	$this->htmlHeader='<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
		<script type="text/javascript" charset="utf8" src="../scripts/datatables/jquery.dataTables.min.js"></script>
		<script type="text/javascript">
			$(document).ready( function () {
				$("#post-table").DataTable({
					/*"order": [[ 0, "desc" ]]*/
					"ordering": false,
					"iDisplayLength": 5,
					"columnDefs": [
					{
						"targets": [ 0 ],
						"visible": false,
						"searchable": false
					}]
				});
			} );
			$(document).ready( function () {
				$("#logged-home").DataTable()} );
		</script>'; 
		
	$this->requestTable='<table id="logged-home">';
	$this->requestTable=$this->requestTable.'<thead><tr>';
	$this->requestTable=$this->requestTable.'<th>Category</th>';
	$this->requestTable=$this->requestTable.'<th>Title</th>';
	$this->requestTable=$this->requestTable.'<th>Action</th>';
	$this->requestTable=$this->requestTable.'</tr></thead><tbody>';
						
	$result=$this->post->GetPostByTypeByUser(0,$this->userid);
	$this->userPostCount=$result->num_rows;
	while ($row = $result->fetch_row()) {
		$this->requestTable=$this->requestTable.'<tr>';
		$this->requestTable=$this->requestTable.'<td>'.$row[10].'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$row[3].'</td>';
					
		$linkphoto='<a href="/'.(($row[1]==0)?'request':'offer').'/photo/'.$row[0].'">Photo</a>';
		$linkupdate='<a href="/'.(($row[1]==0)?'request':'offer').'/update/'.$row[0].'">Update</a>';
		$linkdelete='<a href="/'.(($row[1]==0)?'request':'offer').'/delete/'.$row[0].'">Delete</a>';
							
		$this->requestTable=$this->requestTable.'<td>'.$linkphoto.' | '.$linkupdate.' | '.$linkdelete.'</td>';
		$this->requestTable=$this->requestTable.'</tr>';
	}					
	$this->requestTable=$this->requestTable.'</tbody></table>';
	$result->close();
}
?>