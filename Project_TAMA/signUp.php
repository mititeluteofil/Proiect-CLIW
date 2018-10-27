<?php

	$con = mysqli_connect('127.0.0.1','root','','tama');
	if(!$con)
	{
		header("refresh:5; url=siteHTML_Home.html");
		exit("Connection to server failed");
	}
	if(!mysqli_select_db($con,'tama'))
	{
		header("refresh:5; url=siteHTML_Home.html");
		exit("Database not selected");
	}
	

	if(1>0) // name
	{
		
	if (isset($_REQUEST['name']))
	{
	  $Name = $_REQUEST['name'];
	}
	
	if(!$Name)
	{
		header("Location: siteHTML_Signup.php?name=error1");
		exit();
	}
	else if($Name)
	{
		
		if(strpos($Name, ' ') !== false)
		{
			header("Location: siteHTML_Signup.php?name=error3");
			exit();
		}
		
		$temp = $Name;
		$temp = str_replace("'" , "xx"  , $temp);
		$temp = str_replace("\\" , "xx"  , $temp);
		if(strlen($temp) != strlen($Name))
		{
			header("Location: siteHTML_Signup.php?name=error5");
			exit();
		}
		
		$Name=(filter_var($Name, FILTER_SANITIZE_MAGIC_QUOTES)) ;
		$sql = "SELECT name FROM users WHERE name = '$Name';";
		
		$result = $con->query($sql);
		if ($result->num_rows > 0) 
		{
			header("Location: siteHTML_Signup.php?name=error2");
			exit();
		}
		
		if(strlen($Name)>19)
		{
			header("Location: siteHTML_Page1.php?name=error4");
			exit();
		}
		
	}
	
	}
	
	if(1>0) // email
	{
	if (isset($_REQUEST['email']))
	{
	  $Email = $_REQUEST['email'];
	}
	if (!$Email)
	{
		header("Location: siteHTML_Signup.php?email=error1");
		exit();
	}
	else if($Email)
	{
		$temp = $Email;
		$temp = str_replace("'" , "xx"  , $temp);
		$temp = str_replace("\\" , "xx"  , $temp);
		if(strlen($temp) != strlen($Email))
		{
			header("Location: siteHTML_Signup.php?email=error3");
			exit();
		}
		
		$Email=(filter_var($Email, FILTER_SANITIZE_MAGIC_QUOTES)) ;
		$sql = "SELECT email FROM users WHERE email = '$Email';";
		
		$result = $con->query($sql);
		if ($result->num_rows > 0) 
		{
			header("Location: siteHTML_Signup.php?email=error2");
			exit();
		}
		if(!filter_var($Email, FILTER_VALIDATE_EMAIL))
		{
            header("Location: siteHTML_Signup.php?email=error3");
			exit();
        }
		
	}
	
	}
	
	if(1>0) // password
	{
	if (isset($_REQUEST['pass']))
	{
	  $Pass = $_REQUEST['pass'];
	}
	if(!$Pass)
	{
		header("Location: siteHTML_Signup.php?pass=error1");
		exit();
	}
	else if($Pass)
	{		
		if($Pass == trim($Pass) && strpos($Pass, ' ') !== false)
		{
			header("Location: siteHTML_Signup.php?pass=error3");
			exit();
		}
		$temp = $Pass;
		$temp = str_replace("'" , "xx"  , $temp);
		$temp = str_replace("\\" , "xx"  , $temp);
		if(strlen($temp) != strlen($Pass))
		{
			header("Location: siteHTML_Signup.php?pass=error4");
			exit();
		}
		
		if(strlen($Pass)<6)
		{
			header("Location: siteHTML_Signup.php?pass=error2");
			exit();
		}
	}
	
	}
	
	if(1>0) // re-pass
	{
	if (isset($_REQUEST['rePass']))
	{
	  $RePass = $_REQUEST['rePass'];
	}
	if(!$RePass)
	{
		header("Location: siteHTML_Signup.php?rep=error1");
		exit();
	}
	else if($RePass)
	{		
		if(strcmp($Pass,$RePass))
		{
			header("Location: siteHTML_Signup.php?rep=error2");
			exit();
		}
	}
	
	}

    $usrID = 0;
	$sql = "SELECT MAX(id) FROM users;";
	$result = $con->query($sql);
	$row = $result->fetch_assoc();
	$usrID = $row["MAX(id)"];
	
	$usrID = $usrID + 1;
	
	$Pass = password_hash($Pass, PASSWORD_DEFAULT);

	$sql = "INSERT INTO users VALUES ($usrID,'$Name','$Email','$Pass',1)";
		
	$result = $con->query($sql);

	
	header("Location: siteHTML_Created.html");

?>