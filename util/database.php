<?php 
namespace Util;

class Database
{
	private static $instance = NULL; 
	
	private function __construct(){}

	//private function __clone(){}
	
	public static function GetInstance() {
		if (!isset(self::$instance)) {
			self::$instance = mysqli_connect("localhost","username","password","crowdaid");
			if (mysqli_connect_errno())
			{
				echo "Failed to connect to MySQL: " . mysqli_connect_error();
			} 
		}
		return self::$instance;
	}
}

?>
