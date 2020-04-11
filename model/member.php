<?php
namespace Model;

use Util\Database;

class Member {
	
	private $db;
	
	public function __construct() {	
		$this->db = Database::GetInstance();
	}
	
	public function AddUser($user) {
		$id='';
		
		$sql="INSERT INTO account (username, password, email, status, accounttype) VALUES ('{$user['username']}', '{$user['password']}', '{$user['email']}', '{$user['status']}', '{$user['accounttype']}')";
		
		if ($this->db->query($sql)) {
			
			$sql="SELECT userid FROM account WHERE username = '{$user['username']}'";
			//echo $query;
			if ($result = $this->db->query($sql)) {
				if ($row = $result->fetch_row()) {	
					$id = $row[0];
				}
				$result->close();
			}			
		}
		 
		return $id;		
	}
	
	public function GetActiveMemberCount() {
		$count=0;
		$sql="Select count(*) from account where status=1";
		if ($result = $this->db->query($sql)) {
			if ($row = $result->fetch_row()) {	
				$count = $row[0];
			}
			$result->close();
		}
		return $count;
	}
	
	public function IsUserExist($username) {
		$return=false;
		$sql="SELECT userid FROM account WHERE username = '{$username}'";
		
		if ($result = $this->db->query($sql)) {
			if ($result->num_rows>0) {
				$return=true;
			}
			$result->close();
		}
		return $return;
	}
	
	public function Login($username, $password) {
		$credential=array();
		$sql="SELECT userid, email, username, password FROM account WHERE username = '{$username}' AND password = '{$password}'";
		if ($result = $this->db->query($sql)) {
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$credential = $row;
			}
			$result->close();
		}
		return $credential;
	}
}
?>