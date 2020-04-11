<?php
namespace Model;

use Util\Database;

class Post {
	
	private $db;
	private $newPostId;
	
	public function __construct() {	
		$this->db = Database::GetInstance();
	}
	
	public function AddPost($type, $category, $title, $posttext, $postedby, $status) {
		$title=$this->db->real_escape_string($title);
		$posttext=$this->db->real_escape_string($posttext);
		$sql="INSERT INTO post (type, category, title, posttext, postedby, status) VALUES ('{$type}','{$category}','{$title}','{$posttext}','{$postedby}','{$status}')";
		//echo $sql;
		if ($this->db->query($sql)) {			
			/*$sql="SELECT max(postid) FROM post WHERE postedby = '{$postedby}'";
			if ($result = $this->db->query($sql)) {
				if ($row = $result->fetch_row()) {	
					$this->newPostId = $row[0];
				}
				$result->close();
			}*/
			return true;
		}
		else {
			return false;
		}
	}

	public function UpdatePostStatus($postid, $status) {
		/* 0-closed, 1-open, 2-accepted, 3-cancelled */
		$sql="UPDATE post set status={$status} where postid='{$postid}'";
		
		if ($this->db->query($sql)) {			
			return true;
		}
		else {
			return false;
		}	
	}

	public function NewPostID() {
		return $this->newPostId;
	}
	
	public function SetPostAccepted($postid) {
		/* this will be called when the post owner accepted the response */
		return $this->UpdatePostStatus($postid, 2);
	}

	public function SetPostClosed($postid) {
		/* this will be called when the post owner accepted the response */
		return $this->UpdatePostStatus($postid, 0);
	}

	public function GetPostMatchingTextByType($type,$text) {
		/*$like='';	
		foreach ($text as &$value) {
			if (!empty($like)) {
				$like=$like.' or ';
			}
			$like=$like."title like '".$value."'";
			$like=$like." or posttext like '".$value."'";
		}*/
		if (!empty($text)) {
			$text=" and (".$text.")";
			$sql="SELECT a.*, b.*, c.title cat FROM post as a left join account as b on a.postedby=b.userid left join category as c on c.id=a.category where a.type={$type}".$text;
			//echo $sql;
			return $this->db->query($sql);
		}
		else {
			return NULL;
		}
	}

	public function GetPostStatusByPostId($postid) {
		$status=NULL;
		$sql="SELECT status FROM post where postid={$postid}";
		if ($result = $this->db->query($sql)) {
			if ($row = $result->fetch_row()) {	
				$status = $row[0];
			}
			$result->close();
		}
		return $status;
	}

	public function IsPostAccepted($postid) {
		if ($this->GetPostStatusByPostId($postid)==2) {
			return true;
		}
		else {
			return false;
		}
	}

	public function IsPostClosed($postid) {
		if ($this->GetPostStatusByPostId($postid)==0) {
			return true;
		}
		else {
			return false;
		}
	}

	public function GetCategories() {
		$sql="Select * from category";
		return $this->db->query($sql);
	}
		
	public function GetPostBySQL($sql) {
		//$sql="Select * from post where type = '{$type}'";
		//return $this->db->query($sql);
	}
		
	public function GetPost() {
		$sql="Select * from post";
		return $this->db->query($sql);
	}
	
	public function GetPostById($postid) {
		$sql="SELECT a.*, b.*, c.title cat FROM post as a left join account as b on a.postedby=b.userid left join category as c on c.id=a.category where postid={$postid}";
		return $this->db->query($sql);
	}
	
	public function GetActivePostByType($type) {
		$sql="SELECT * FROM post as a left join account as b on a.postedby=b.userid left join category as c on c.id=a.category where type = '{$type}' and a.status=1 order by postid desc";
		return $this->db->query($sql);
	}
	
	public function GetPostByUser($userid) {
		$sql="SELECT * FROM post as a left join category as c on c.id=a.category where postedby = '{$userid}'";
		return $this->db->query($sql);
	}
	
	public function GetPostByTypeByUser($type,$userid) {
		$sql="SELECT * FROM post as a left join category as c on c.id=a.category where postedby = '{$userid}' and type = '{$type}'";
		return $this->db->query($sql);
	}

	public function GetPostByTypeByUserByStatus($type,$userid,$status) {
		$sql="SELECT a.*,c.title cat FROM post as a left join category as c on c.id=a.category where postedby = '{$userid}' and type = '{$type}' and status = '{$status}'";
		return $this->db->query($sql);
	}
	
	public function GetUserRespondedPosts($type,$userid) {
		$sql="SELECT a.*,c.title cat FROM post as a left join category as c on c.id=a.category where type = '{$type}' and postid in (SELECT postid FROM response where userid={$userid})";
		return $this->db->query($sql);
	}
	
	public function GetPostOtherUserByType($type,$userid) {
		$sql="SELECT a.*,b.*,c.title cat FROM post as a left join account as b on a.postedby=b.userid left join category as c on c.id=a.category where postedby <> '{$userid}' and type = '{$type}'";
		return $this->db->query($sql);
	}

	public function GetOpenPostOtherUserByType($type,$userid) {
		$sql="SELECT a.*,b.*,c.title cat FROM post as a left join account as b on a.postedby=b.userid left join category as c on c.id=a.category where postedby <> '{$userid}' and type = '{$type}' and a.status=1";
		return $this->db->query($sql);
	}
	
	public function GetPostCount() {
		$count=0;
		$sql="Select count(*) from post";
		if ($result = $this->db->query($sql)) {
			if ($row = $result->fetch_row()) {	
				$count = $row[0];
			}
			$result->close();
		}
		return $count;
	}
	
	public function GetPostCountByType($type) {
		$count=0;
		$sql="Select count(*) from post where type = '{$type}'";
		if ($result = $this->db->query($sql)) {
			if ($row = $result->fetch_row()) {	
				$count = $row[0];
			}
			$result->close();
		}
		return $count;
	}
}
?>