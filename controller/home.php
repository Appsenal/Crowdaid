<?php 

if ($this->isLogin) {
	$this->htmlHeader='<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.css">
		<script type="text/javascript" charset="utf8" src="../scripts/datatables/jquery.dataTables.min.js"></script>
		<script type="text/javascript">
			$(document).ready( function () {
				$("#logged-home-request").DataTable({"iDisplayLength": 5})} );
			$(document).ready( function () {
				$("#logged-home-offer").DataTable({"iDisplayLength": 5})} );
		</script>'; 
	$this->requestCount=0;
	$this->offerCount=0;
	
	//Get the posts for request to show it in homepage logged in
	$this->requestTable='<table id="logged-home-request" width="100%">';
	$this->requestTable=$this->requestTable.'<thead><tr>';
	$this->requestTable=$this->requestTable.'<th>Post Id</th>';
	$this->requestTable=$this->requestTable.'<th>Category</th>';
	$this->requestTable=$this->requestTable.'<th>Title</th>';
	$this->requestTable=$this->requestTable.'<th>Posted By</th>';
	$this->requestTable=$this->requestTable.'<th>Action</th>';
	$this->requestTable=$this->requestTable.'</tr></thead><tbody>';
						
	$result=$this->post->GetOpenPostOtherUserByType(0,$this->userid);
	$this->requestCount=$result->num_rows;
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$this->requestTable=$this->requestTable.'<tr>';
		$this->requestTable=$this->requestTable.'<td>'.$row['postid'].'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$row['cat'].'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$row['title'].'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$row['username'].'</td>';
							
		$linkview='<a href="/request/view/'.$row['postid'].'">View</a>';
		$linkresponse='<a href="/request/response/'.$row['postid'].'">Respond</a>';
							
		$this->requestTable=$this->requestTable.'<td>'.$linkview.' | '.$linkresponse.'</td>';
		$this->requestTable=$this->requestTable.'</tr>';
	}					
	$this->requestTable=$this->requestTable.'</tbody></table>';
	$result->close();
	
	//Get the posts for offer to show it in homepage logged in
	$this->offerTable='<table id="logged-home-offer" width="100%">';
	$this->offerTable=$this->offerTable.'<thead><tr>';
	$this->offerTable=$this->offerTable.'<th>Post Id</th>';
	$this->offerTable=$this->offerTable.'<th>Category</th>';
	$this->offerTable=$this->offerTable.'<th>Title</th>';
	$this->offerTable=$this->offerTable.'<th>Posted By</th>';
	$this->offerTable=$this->offerTable.'<th>Action</th>';
	$this->offerTable=$this->offerTable.'</tr></thead><tbody>';
						
	$result=$this->post->GetOpenPostOtherUserByType(1,$this->userid);
	$this->offerCount=$result->num_rows;
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$this->offerTable=$this->offerTable.'<tr>';
		$this->offerTable=$this->offerTable.'<td>'.$row['postid'].'</td>';
		$this->offerTable=$this->offerTable.'<td>'.$row['cat'].'</td>';
		$this->offerTable=$this->offerTable.'<td>'.$row['title'].'</td>';
		$this->offerTable=$this->offerTable.'<td>'.$row['username'].'</td>';					
		$linkview='<a href="/offer/view/'.$row['postid'].'">View</a>';
		$linkresponse='<a href="/offer/response/'.$row['postid'].'">Respond</a>';
							
		$this->offerTable=$this->offerTable.'<td>'.$linkview.' | '.$linkresponse.'</td>';
		$this->offerTable=$this->offerTable.'</tr>';
	}					
	$this->offerTable=$this->offerTable.'</tbody></table>';
	$result->close();
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
					/*"columnDefs": [
					{
						"targets": [ 0 ],
						"visible": false,
						"searchable": false
					}]*/
				});
			} );
			</script>';
	
	
	$this->requestCount=0;
	$this->offerCount=0;
	$this->activeMemberCount=$this->member->GetActiveMemberCount(0);
	$this->requestCount=$this->post->GetPostCountByType(0);
	$this->offerCount=$this->post->GetPostCountByType(1);
						
	/*$this->requestTable='<table id="post-table" width="100%">';
	$this->requestTable=$this->requestTable.'<thead><tr>';
	$this->requestTable=$this->requestTable.'<th>Post Id</th>';
	$this->requestTable=$this->requestTable.'<th>Category</th>';
	$this->requestTable=$this->requestTable.'<th>Title</th>';
	$this->requestTable=$this->requestTable.'<th>Posted By</th>';
	$this->requestTable=$this->requestTable.'</tr></thead><tbody>';
					
	$result=$this->post->GetActivePostByType(0); 
	$this->requestCount=$result->num_rows;
	while ($row = $result->fetch_row()) {
		$this->requestTable=$this->requestTable.'<tr>';
		$this->requestTable=$this->requestTable.'<td>'.$row[0].'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$row[17].'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$row[3].'</td>';
		$this->requestTable=$this->requestTable.'<td>'.$row[10].'</td>';
		$this->requestTable=$this->requestTable.'</tr>';
	}
	$result->close();						
	$this->requestTable=$this->requestTable.'</tbody></table>';	*/					
}

?>