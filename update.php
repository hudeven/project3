<?php
session_start();
include_once("includes/connection.php");

if(isset($_SESSION['logged_in'])) {
    include('includes/header.php');
    
    if(isset($_POST['confirm_state'])) {
	$project_title=$_SESSION['project_title'];
	$umid = $_SESSION['umid'];
	$slots_id = $_SESSION['slots_id'];
	$query = $pdo->prepare("UPDATE slots SET seats_left=seats_left+1 WHERE id in (SELECT slots_id FROM registration WHERE students_umid=?)");
	$query->bindValue(1, $_SESSION['umid']);
	$query->execute();
	$query = $pdo->prepare("DELETE FROM registration WHERE students_umid=?");
	$query->bindValue(1, $umid);
	$query->execute();
	$_SESSION['insert'] = true;
	header('Location: index.php');
    }
	
?>


<form method="post" action="update.php">
<p>You have already registered a slot, do you want to replace it? </p>
<input type="hidden" name="confirm_state" value="true">
<input type="submit" value="Yes" class="myButton">
<input type="button" value="No" onclick="javascript:window.location='index.php'" class="myButton">
</form>


<?php
    include('includes/footer.php');

} else {
    include("signin.php");
}
?>

