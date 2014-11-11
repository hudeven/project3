<?php
session_start();
include_once("includes/connection.php");

if (isset($_POST['email'], $_POST['umid'], $_POST['first_name'], $_POST['last_name'], $_POST['password'])) {
	$email = $_POST['email'];
	$_SESSION['email'] = $_POST['email'];
	$password = md5($_POST['password']);
	$_SESSION['password'] = $password;
	$confirm_password = md5($_POST['confirm_password']);
	$_SESSION['confirm_password'] = $confirm_password;
	$umid = $_POST['umid'];
	$_SESSION['umid'] = $_POST['umid'];
	$first_name = $_POST['first_name'];
	$_SESSION['first_name'] = $_POST['first_name'];
	$last_name = $_POST['last_name'];	
	$_SESSION['last_name'] = $_POST['last_name'];	
        $phone = $_POST['phone'];
        $_SESSION['phone'] = $_POST['phone'];

	$std_style = "color: black";
	$high_light = "color: red";
	$password_style = $std_style;
	$confirm_style = $std_style;
	$umid_style = $std_style;
	$first_style = $std_style;
	$last_style = $std_style;
	$phone_style= $std_style;
	$email_style = $std_style;


	if (empty($email) or empty($password) or empty($confirm_password) or empty($umid) or empty($first_name) or empty($last_name) or empty($phone)) {
	    $error = "You must fill all the fields!";
	} else if ($password != $confirm_password){
	    $error = "password and confirm password don't match!";
	    $password_style = $high_light;
	    $confirm_style = $high_light;
	} else if(!preg_match("/^[0-9]{8}$/", $umid)) {
	    $error = "umid must be 8 digits";
	    $umid_style = $high_light;
	} else if(!preg_match("/^[a-zA-Z]{1,80}$/", $first_name)) {
	    $error = "first name must be letters";
	    $first_style = $high_light;
	} else if(!preg_match("/^[a-zA-Z]{1,80}$/", $last_name)) {
	    $error = "last name must be letters";
	    $last_style = $high_light;
	} else if(!preg_match("/^[0-9]{3}[-][0-9]{3}[-][0-9]{4}$/", $phone)) {
	    $error = "Phone number must be like this: 313-454-7878";
	    $phone_style = $high_light;
	} else if (!preg_match("/^[a-zA-Z0-9]{1,38}[@][a-zA-Z0-9_]{1,20}[.][a-zA-Z0-9]{1,20}$/", $email)) {
	    $error = "Please input valid email address!";
	    $email_style = $high_light;
	} else {
	    $query = $pdo->prepare("INSERT INTO students (email, password,umid, first_name, last_name, phone)  values (?,?,?,?,?,?)");
	    $query->bindValue(1, $email);
	    $query->bindValue(2, $password);
	    $query->bindValue(3, $umid);
	    $query->bindValue(4, $first_name);
	    $query->bindValue(5, $last_name);
	    $query->bindValue(6, $phone);
	    $query->execute();
	    
	    $_SESSION['logged_in'] = true;
            $_SESSION['umid'] = $umid;
            header("Location: index.php");    
	}
    }

     include('includes/header.php');
?>
	<br /><br />
	
	<div class="form">
	<h3 class="center_align">Sign up</h3>
	<?php if (isset($error)) {?>
	    <small style="color:#aa0000;"><?php echo $error;?>
	    <br></small>
	<?php } 
	?>

	<form action="signup.php" method="post">
	     <label>UMID</label>
	     <input type="text" name="umid" id="umid" value="<?php echo $_SESSION['umid']?>" style="<?php echo $umid_style;?>">
	     <br><br>
	     <label>Email</label>
	     <input type="text" name="email" id="email" value="<?php echo $_SESSION['email']?>" style="<?php echo $email_style;?>">
	     <br><br>
	     <label>Password</label>
	     <input type="password" name="password" id="password" value="<?php echo $_SESSION['password']?>" style="<?php echo $password_style;?>">
	     <br><br>
	     <label>Confirm</label>
	     <input type="password" name="confirm_password" id="confirm_password" value="<?php echo $_SESSION['confirm_password']?>" style="<?php echo $confirm_style?>">
	     <br><br>
	     <label>First name</label>
	     <input type="text" name="first_name" id="first_name" value="<?php echo $_SESSION['first_name']?>" style="<?php echo $first_style;?>">
	     <br><br>
	     <label>Last name</label>
	     <input type="text" name="last_name" id="last_name" value="<?php echo $_SESSION['last_name']?>" style="<?php echo $last_style;?>">
	     <br><br>     
	     <label>Phone</label>
             <input type="text" name="phone" value="<?php echo $_SESSION['phone']?>" style="<?php echo $phone_style;?>">
	     <br><br>     
	     <input type="submit" value="Sign up" class="myButton">
	</form>
	</div>

<script>
function highLight($var)
{
    document.getElementById($var).style.color="blue";
}
</script>
<?php
    include('includes/footer.php');
?>
