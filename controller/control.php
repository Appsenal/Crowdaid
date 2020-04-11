<?php
use Model\Member;
use Model\Post;
use Model\Image;
use Model\Response;
use Util\API;

class Control {
	/*Model Variables*/
	private $member;
	private $post;
	private $image;
	private $response;
	
	/*url variables*/
	private $view;	
	private $method;
	private $query;	
	private $urlPath;
	private $key;
	
	/*member and session variables*/
	private $userid;
	private $username;		
	private $userinfo;	
	private $activeMemberCount;
	
	/* Variables for posts */
	private $postCount;
	private $requestCount;
	private $offerCount;
	private $requestTable;	
	private $userPostCount;
	private $postData;
	private $postUser;
	private $isPostOwner;
	private $categories;
	private $postHTML;
	private $isPostAccepted;
	private $isPostClosed;
	
	/*image variables*/
	private $fileTargetLocation;
	private $fileName;
	private $imageData;
	private $imageHTML;
	
	/*response variables*/
	private $isResponseAccepted;
	private $isResponseRejected;
	private $parentId;
	private $responseHTML;
	//private $responseId;
	
	/*page state variables*/
	private $isHome;
	private $islogin;
	
	/*page texts variables*/
	private $htmlHeader;	
	private $subTitle;
	private $notice;

	/*API variables*/
	private $API;
	
	public function __construct(){	
		$this->htmlHeader='';
		$this->subTitle='';
		$this->fileTargetURL='';
		$this->isPostOwner=false;
		
		// get the HTTP method, path and body of the request
		$method = $_SERVER['REQUEST_METHOD'];
		$this->urlPath = explode('/', trim($_SERVER['REQUEST_URI'],'/'));						
			
		// retrieve the page and the next value
		$page = preg_replace('/[^a-z0-9_]+/i','',array_shift($this->urlPath));
		//$query = array_shift($this->urlPath);
				
		$this->method=$method;
		$this->query='';
		$this->key='';
				
		if ($page=='') {
			$page='home';
			$this->isHome=true;
		}
		$this->view=$page;
		
		/*set model variables*/
		$this->member=new Member();
		$this->post=new Post();
		$this->image=new Image();
		$this->response=new Response();
		
		$this->ValidateSession();
	}

	public function LoadAPIClass() {
		$this->API=new API();
	}
		
	public function LoadCurrentView() {
		switch ($this->method) {
			case 'GET':
				 $this->ProcessGet(); break;
			case 'PUT':
				$this->LoadHome(); break;
			case 'POST':
				$this->ProcessPost(); break;
			case 'DELETE':
				$this->LoadHome(); break;
		}
	}
	
	private function ProcessGet() {
		if ($this->view=='logout') {
			$this->CloseSession();
			$this->RedirectPage('');
		}
		else {
			if (($this->isLogin==false) && (($this->view=='request') || ($this->view=='offer') || ($this->view=='profile'))) {
				//This will make sure that the views intended for logged in user will not show in logged out session
				$this->RedirectPage('');
			}
			else {
				if ($this->view=='home') {					
					include 'home.php';
				}
				elseif ($this->view=='request' || $this->view=='offer') {
					$this->query = array_shift($this->urlPath);
					include 'post_get.php'; 
				}
				include($_SERVER['DOCUMENT_ROOT']."/view/".$this->view."_view.php");
			}
		}
	}
	
	private function ProcessPost() {
		// Process user inputs for all pages.
		if ($this->view=='signup') {
			if ($this->ValidInput()) {
				$this->userinfo=array('email'=>$_POST['email'], 'username'=>$_POST['username'], 'password'=>$_POST['password'], 'status'=>'1', 'accounttype'=>'0');
				$memberid=$this->member->AddUser($this->userinfo);			
				$this->notice = "<span class='notice'>The user ".$_POST['username']." has been successfully added with userid: ".$memberid."</span>"; 
			}
			$this->LoadSignup();
		}
		elseif ($this->view=='login') {
			$credential=$this->member->Login($_POST['username'], $_POST['password']);
			if (!empty($credential)) {
				$_SESSION["userid"]=$credential["userid"];
				$_SESSION["email"]=$credential["email"];
				$_SESSION["username"]=$credential["username"];
				$_SESSION["password"]=$credential["password"];
								
				$this->username=$_SESSION["username"];
				
				$this->isLogin=true;				
				$this->RedirectPage('');
			}
			else {
				$this->notice="<span class='notice fail'>Invalid username or password.</span>";
				$this->LoadLogin();
			}
		}
		elseif ($this->view=='request' || $this->view=='offer') {			
			$this->query = array_shift($this->urlPath);
			include 'post_post.php';
		}	
		else {}
	}
	
	private function GetPostDataById($key) {
		$this->postData=array();		
		if ($result=$this->post->GetPostById($key)) { 
			if ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				//$postid = $row['postid'];
				//$category = $row['cat'];
				//$title = $row['title'];
				$this->postUser=$row['userid'];
				$this->postData=$row;
			}
			$result->close();
		}
	}
	
	private function GetImagesByPostHTML($postid) {
		$this->imageHTML='';		
		if ($result=$this->image->GetImagesByPostId($postid)) { 
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {				
				//$this->imageData=$row;
				$this->imageHTML=$this->imageHTML.'<div class="gallery">
								  <a target="_blank" href="../images/uploads/'.$row['filename'].'">
									<img src="../images/uploads/'.$row['filename'].'" alt="'.$row['imagetitle'].'" width="300" height="200">
								  </a>
								  <div class="desc">'.$row['caption'].'</div>
								</div>';
			}
			$result->close();
		}
	}
	
	private function ValidInput() {
		// Validate user inputs for all pages.
		$return=true;
		if ($this->view=='signup') {			
			if (empty($_POST['email'])) {
				$return=false;
				$this->notice="<span class='notice fail'>Email not supplied. Please enter your email.</span>";
			}
			elseif (empty($_POST['username'])) {
				$return=false;
				$this->notice="<span class='notice fail'>Username not supplied. Please enter your username.</span>";
			}
			elseif ($this->member->IsUserExist($_POST['username'])) {
				$return=false;
				$this->notice="<span class='notice fail'>The username is not available. Please enter another username.</span>";
			}
			elseif (empty($_POST['password'])) {
				$return=false;
				$this->notice="<span class='notice fail'>Password not supplied. Please enter your password.</span>";
			}			
			elseif ($_POST['password']!=$_POST['confirmpass']) {
				$return=false;
				$this->notice="<span class='notice fail'>Password confirmation failed. Please the same value in the password fields.</span>";
			}
			else {}
		}
		elseif ($this->view=='request' || $this->view=='offer') {
			if (empty($_POST['title'])) {
				$return=false;
				$this->notice="<span class='notice fail'>Title not supplied.</span>";
			}
			elseif (empty($_POST['posttext'])) {
				$return=false;
				$this->notice="<span class='notice fail'>Details not supplied.</span>";
			}
		}
		return $return;
	}
	
	private function UploadFile() {
		$this->notice="";
		$success="false";
		$target="";
		//if they DID upload a file...
		if($_FILES['file']['name']) {
			//if no errors...
			if(!$_FILES['file']['error']) {
				//now is the time to modify the future file name and validate the file				
				//can't be larger than 1 MB
				if($_FILES['file']['size'] > (1024000)) {
					$valid_file = false;
					$this->notice="<span class='notice fail'>Oops!  Your file\'s size is to large.</span>";
				}
				else {
					$valid_file = true;
				}				
				//if the file has passed the test
				if($valid_file)	{
					//move it to where we want it to be
					$currentdir = getcwd();
					$fileparts = explode(".", $_FILES["file"]["name"]);
					$newfilename = round(microtime(true)) . '.' . end($fileparts);					
					$target = $currentdir."/images/uploads/".$newfilename;
					move_uploaded_file($_FILES['file']['tmp_name'], $target);					
					$this->notice="<span class='notice success'>Upload success!</span>";
					$success=true;
					$this->fileTargetLocation=$target;
					$this->fileName=$newfilename;
				}
			}
			else {
				//set that to be the returned message
				$this->notice="<span class='notice fail'>Ooops!  Your upload triggered the following error:  ".$_FILES['photo']['error']."</span>";
			}
		}
		else {
			//$this->notice="<span class='notice fail'>No file to upload.</span>";
		}

		//you get the following information for each file:
		//$_FILES['field_name']['name']
		//$_FILES['field_name']['size']
		//$_FILES['field_name']['type']
		//$_FILES['field_name']['tmp_name']
		//echo $this->notice;
		
		return $success;
	}
	
	private function ValidateSession() {
		//This function will check if the session is still active
		session_start();
		if (isset($_SESSION["username"])) {
			$this->isLogin=true;
			$this->username=$_SESSION["username"];
			$this->userid=$_SESSION["userid"];
		}
		else {
			//$this->isLogin=true;
			$this->isLogin=false;
		}
	}
	
	private function CloseSession() {
		if (isset($_SESSION)) {
			session_unset();
			session_destroy();	
			$this->isLogin=false;			
		}
	}
	
	public function RedirectPage($page) {
		//header("Location: ".$_SERVER['SERVER_NAME']."/".$page); /* Redirect browser */
		header("Location: /".$page); /* Redirect browser */
		exit();
	}
	
	public function SetView($view) {
		$this->view=$view;
	}
	
	public function GetView() {
		return $this->view;
	}
	
	public function LoadView($view){		
		if ($view=='') {
			$view='home';
		}
		else {
			include($_SERVER['DOCUMENT_ROOT']."/view/".$view."_view.php");
		}
	}
	
	public function LoadHome() {
		include($_SERVER['DOCUMENT_ROOT']."/view/home_view.php");
	}
	
	public function LoadSignup() {
		include($_SERVER['DOCUMENT_ROOT']."/view/signup_view.php");
	}
	
	public function LoadLogin() {
		include($_SERVER['DOCUMENT_ROOT']."/view/login_view.php");
	}
	
	public function LoadRequest() {
		include($_SERVER['DOCUMENT_ROOT']."/view/request_view.php");
	}
}
?>