<?php
session_start();
include_once("includes/connection.php");

if(isset($_SESSION['logged_in'])) {
    include('includes/header.php');
	
?>

<h3 class="center_align">Registration Record</h3>
<br>

<?php 
$query = $pdo->prepare("SELECT * FROM registration,slots,students WHERE registration.students_umid=students.umid and registration.slots_id=slots.id");
$query->execute();
$result = $query->fetchall();

echo "<table>
	 <tr>
	     <th>UMID</th>
	     <th>First Name</th>
	     <th>Last Name</th>
	     <th>Project</th>
	     <th>Email</th>
	     <th>Phone</th>
	     <th>Time</th>
	 <tr>";


foreach($result as $item){
    echo "<tr>
	     <td>".$item['umid']."</td>
	     <td>".$item['first_name']."</td>
	     <td>".$item['last_name']."</td>
	     <td>".$item['project_title']."</td>
	     <td>".$item['email']."</td>
	     <td>".$item['phone']."</td>
	     <td>".$item['time_slot']."</td>
	  </tr>";
	      	      
}

echo "</table>";

?>


<?php
    include('includes/footer.php');

} else {
    include("signin.php");
}
?>

