<?php
namespace Model;

use Util\Database;

class Image {
	
	private $db;
	
	public function __construct() {	
		$this->db = Database::GetInstance();
	}
	
	public function AddImage($imagetitle, $filename, $imagelocation, $caption) {
		$imageid=0;
		$imagetitle=$this->db->real_escape_string($imagetitle);
		$caption=$this->db->real_escape_string($caption);
		$sql="INSERT INTO images (imagetitle, filename, imagelocation, caption) VALUES ('{$imagetitle}','{$filename}','{$imagelocation}','{$caption}')";
		if ($this->db->query($sql)) {			
			$sql="SELECT imageid FROM images WHERE filename = '{$filename}'";
			if ($result = $this->db->query($sql)) {
				if ($row = $result->fetch_row()) {	
					$imageid = $row[0];
				}
				$result->close();
			}	
		}
		return $imageid;
	}
	
	public function AddPostImage($imageid,$postid) {
		$sql="INSERT INTO postimage (imageid, postid) VALUES ('{$imageid}','{$postid}')";
		if ($this->db->query($sql)) {		
			return true;
		}
		else {
			return false;
		}
	}

	public function AddResponseImage($imageid,$responseid) {
		$sql="INSERT INTO responseimage (imageid, responseid) VALUES ('{$imageid}','{$responseid}')";
		if ($this->db->query($sql)) {		
			return true;
		}
		else {
			return false;
		}
	}
	
	public function GetImagesByPostId($postid) {
		$sql="SELECT b.* FROM postimage a left join images b on a.imageid=b.imageid where a.postid={$postid} and a.isactive=1";
		return $this->db->query($sql);
	}

	public function GetImageByResponseId($responseid) {
		$image=NULL;
		$sql="SELECT b.* FROM responseimage a left join images b on a.imageid=b.imageid where a.responseid={$responseid}";
		//echo $sql;
		if ($result=$this->db->query($sql)) { 
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {				
				$image=$row;
			}
			$result->close();
		}
		return $image;
	}
}