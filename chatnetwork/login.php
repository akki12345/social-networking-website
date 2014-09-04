<?php include("connect.php")?>
<?php
//Start session
session_start();
	//Function to sanitize values received from the form. Prevents SQL injection
	function clean($str) {
		$str = @trim($str);
		if(get_magic_quotes_gpc()) {
			$str = stripslashes($str);
		}
		return mysql_real_escape_string($str);
	}
	
		//Sanitize the POST values
$UserName = clean($_POST['UserName']);
	$Password =(md5($_POST['Password']));
	
		//Create query
	$qry="SELECT * FROM members WHERE UserName='$UserName' AND Password='$Password'";
	$result=mysql_query($qry);
	
		//Check whether the query was successful or not
if($result) {
		if(mysql_num_rows($result) > 0) {
			//Login Successful
			session_regenerate_id();
			$member = mysql_fetch_assoc($result);
			$_SESSION['SESS_MEMBER_ID'] = $member['member_id'];
			$_SESSION['SESS_FIRST_NAME'] = $member['FirstName'];
			$_SESSION['SESS_LAST_NAME'] = $member['profImage'];
			
			session_write_close();
			header("location: profile.php");
			exit();
		}else {
		echo "<script>alert('Invalid Username And Password Please enter valid address!')</script>";exit();
		}
	}else {
		die("Query failed");
	}	
?>

