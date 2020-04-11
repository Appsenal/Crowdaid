<?php
namespace Model;

use Util\Database;

class Response {
	private $db;
	
	public function __construct() {	
		$this->db = Database::GetInstance();
	}
	
	public function AddResponse($postid, $userid, $comment, $parentid) {
		$responseid=NULL;
		$comment=$this->db->real_escape_string($comment);
		$sql="INSERT INTO response (postid, userid, comment, parentid) VALUES ('{$postid}','{$userid}','{$comment}','{$parentid}')";
		if ($this->db->query($sql)) {
			//return true;
			$sql="SELECT max(id) FROM response WHERE userid={$userid}";
			if ($result = $this->db->query($sql)) {
				if ($row = $result->fetch_row()) {	
					$responseid = $row[0];
				}
				$result->close();
			}
		}
		return $responseid;
	}

	public function AddResponseStatus($parentid, $status) {
		/* 0=rejected, 1=accepted */
		$sql="INSERT INTO responsestatus (parentid, status) VALUES ('{$parentid}','{$status}')";
		if ($this->db->query($sql)) {
			return true;
		}
		else {
			return false;
		}
	}

	public function AcceptResponse($postid, $userid, $parentid) {
		$sql="INSERT INTO response (postid, userid, comment, parentid) VALUES ('{$postid}','{$userid}','*Accepted this response*','{$parentid}')";
		if ($this->db->query($sql)) {
			return $this->AddResponseStatus($parentid, 1);
		}
		else {
			return false;
		}
	}

	public function RejectResponse($postid, $userid, $parentid) {
		$sql="INSERT INTO response (postid, userid, comment, parentid) VALUES ('{$postid}','{$userid}','*Rejected this response*','{$parentid}')";
		if ($this->db->query($sql)) {
			return $this->AddResponseStatus($parentid, 0);
		}
		else {
			return false;
		}
	}

	public function GetResponseStatus($parentid) {
		$status=NULL;
		$sql="select status from responsestatus where parentid={$parentid}";
		if ($result = $this->db->query($sql)) {			
			if ($row = $result->fetch_array(MYSQLI_ASSOC))  {	
				$status = $row['status'];				
			}
			$result->close();
		}
		return $status;
	}

	public function IsReponseAccepted($parentid) {
		$status=$this->GetResponseStatus($parentid);
		if ($status==1) {
			return true;
		}
		else {
			return false;
		}
	}

	public function IsReponseRejected($parentid) {
		$status=$this->GetResponseStatus($parentid);
		if ($status==0) {
			return true;
		}
		else {
			return false;
		}
	}
	
	public function GetInitialResponsesByPostId($postid) {
		$sql="SELECT a.id, a.date, a.comment, b.* FROM response a left join account b on a.userid=b.userid WHERE a.postid={$postid} and a.parentid=0";
		return $this->db->query($sql);
	}

	public function GetPostResponsesByParentId($parentid) {
		//$parentid=0;
		//$return=array();
		//get the parent id
		//$parentid=$this->GetParentId($postid, $userid);
		
		//pull all the related responses
		$sql="SELECT * FROM response a left join account b on a.userid=b.userid where a.parentid={$parentid} order by a.id asc";
		return $this->db->query($sql);		
	}
	
	public function GetParentId($postid, $userid) {
		$parentid=0;
		$sql="SELECT id, parentid FROM response where postid={$postid} and userid={$userid} limit 1";
		//echo $sql;
		if ($result = $this->db->query($sql)) {			
			if ($row = $result->fetch_array(MYSQLI_ASSOC))  {	
				if ($row['parentid']==0) {
					$parentid = $row['id'];
				}
				else {					
					$parentid = $row['parentid'];
				}
			}
			$result->close();
		}
		return $parentid;
	}
	
	public function GetPostResponses($postid, $userid) {
		$parentid=0;
		//$return=array();
		//get the parent id
		$parentid=$this->GetParentId($postid, $userid);
		
		//pull all the related responses
		if ($parentid!=0) {
			$sql="SELECT * FROM response a left join account b on a.userid=b.userid where ((a.id={$parentid} and a.postid={$postid}) or a.parentid={$parentid}) order by a.id asc";
			//echo $sql;	
			return $this->db->query($sql);		
		}
		else {
			return NULL;
		}
	}
}
?>