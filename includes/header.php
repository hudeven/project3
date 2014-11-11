<?php
session_start();
?>


<!DOCTYPE html>
<html>
<head>
    <title><?php echo $page_title?></title>
    <link rel="stylesheet" href="style.css" type="text/css">
</head>
<body>
    <div class="header">
	<label><?php echo "Welcome ".$_SESSION['umid']."&nbsp;";?></label>
	<button name="Home" id="homeButton" onclick="window.location.href='index.php'">Home</button>
	<button name="Record" id="recordButton" onclick="window.location.href='record.php'">Record</button>

<?php if(!isset($_SESSION['logged_in']) or $_SESSION['logged_in']==false) {?>
	<button href="signin.php" id="signin" onclick="window.location.href='signin.php'">Sign in</button>
<?php
	}else{
?>
	<button href="signout.php" id="signout" onclick="window.location.href='signout.php'">Sign out</button>
<?php   }?>

    </div>

    <div class="box">

<!-- The <div> will be closed in footer.php-->

