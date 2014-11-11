<?php
session_start();
include_once("includes/connection.php");

if(isset($_SESSION['logged_in'])) {
    include('includes/header.php');
    
    if(isset($_POST['project_title'])) {
	$project_title=$_POST['project_title'];
	$_SESSION['project_title'] = $project_title;
	$umid = $_SESSION['umid'];
	$slots_id = $_POST['slots'];
	$_SESSION['slots_id'] = $slots_id;

	$query = $pdo->prepare("SELECT * FROM registration WHERE students_umid = ?");
	$query->bindValue(1, $umid);
	$query->execute();
	$results = $query->fetchall();
	$_SESSION['insert'] = false;
	if(count($results) > 0)
	{
	    header("Location: update.php");
	}else{
	    $_SESSION['insert'] = true;
	}
    }
	
    if(isset($_SESSION['insert']) && $_SESSION['insert'] == true) {
	$query = $pdo->prepare("SELECT * FROM slots WHERE id=?");
	$query->bindValue(1, $_SESSION['slots_id']);
	$query->execute();
	$result = $query->fetchall();
	$seats_left = $result[0]['seats_left'];
	if($seats_left > 0) {
	    $seats_left -= 1;
	    $query = $pdo->prepare("UPDATE slots SET seats_left=? WHERE id=?");
	    $query->bindValue(1, $seats_left);
	    $query->bindValue(2, $_SESSION['slots_id']);
	    $query->execute();

  	    $query = $pdo->prepare("INSERT INTO registration (students_umid, slots_id, project_title) values (?,?,?)");
	    $query->bindValue(1, $_SESSION['umid']);
	    $query->bindValue(2, $_SESSION['slots_id']);
	    $query->bindValue(3, $_SESSION['project_title']);
	    $query->execute();
	}
	$_SESSION['insert'] = false;

    }
	
?>

<h3 class="center_align">Home page</h3>
<br>

<?php 
$query = $pdo->prepare("SELECT * FROM registration,slots WHERE students_umid=? and registration.slots_id=slots.id");
$query->bindValue(1, $_SESSION['umid']);
$query->execute();
$result = $query->fetchall();
    if(count($result) > 0) {
    	echo '<p>You have registered slot "'.str_replace('-','&ndash;',$result[0]["time_slot"]).'" for project "'.$result[0]["project_title"].'"</p>';
    } else {
	echo "<p>You haven't registered any slots</p>";
    }


$query = $pdo->prepare("SELECT * FROM slots");
$query->execute() or die(print_r($query->errorInfo(), true));
$slots = $query->fetchall();
?>


<form method="post" action="index.php">
<select name="slots" id="slots_drop">
<?php foreach($slots as $slot) { 
    if($slot['seats_left'] > 0) {
?>
    <option value=<?php echo $slot["id"];?>> <?php echo $slot["time_slot"]."  ...... ".$slot['seats_left']."  seats left";?>  </option>
<?php 
    }
  }
 ?>
</select>
<br><br>
<label>Project title</label>
<input type="text" name="project_title" required/>
<br><br>
<input type="submit" value="Submit" class="myButton">
</form>


<?php
    include('includes/footer.php');

} else {
    include("signin.php");
}
?>

