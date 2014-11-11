<?php
session_start();
include_once("includes/connection.php");

if (isset($_POST['umid'], $_POST['password'])) {
	$umid = $_POST['umid'];
	$password = md5($_POST['password']);
	
	if (empty($umid) or empty($password)) {
	    $error = "email or password is empty!";
	} else {
	    $query = $pdo->prepare("SELECT * FROM students WHERE umid = ? and password = ?");
	    $query->bindValue(1, $umid);
	    $query->bindValue(2, $password);
	    $query->execute();
	    $num = $query->rowCount();

	    if ($num == 1) {
		$_SESSION['logged_in'] = true;
		$users = $query->fetchall();
	        $_SESSION['umid'] = $users[0]['umid'];
		header("Location: index.php");
	    } else {
		$error = "username and password don't match!";
	    }
	}
    }
    
    include('includes/header.php');
?>

    <div class="form">
	<h3 class="center_align">Sign in<h3>
	<form action="signin.php" method="post" autocomplete="off">
	<?php if (isset($error)) {?>
	    <small style="color:#aa0000;"><?php echo $error;?>
	    <br><br></small>
	<?php } ?>
      	     <label>UMID &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</label>
	     <input type="text" name="umid" placeholder="UMID">
	     <br><br>
	     <label>Password</label>
	     <input type="password" name="password" placeholder="Password">
	     <br><br>
	     <input type="submit" value="Sign in" id="signInSubmitBtn">
	     &nbsp;&nbsp;
	     <a href="signup.php">Sign up</a>
	</form>
    </div>
	
<?php
    include('includes/footer.php');
?>
