<?php

session_start();
$con = mysqli_connect("localhost","root","","poll");
//If your session isn't valid, it returns you to the login screen for protection
if( empty($_SESSION['admin_id']) ){
   header("location:access-denied.php");
}
//retrive positions from the tbpositions table
$result=mysqli_query($con,"SELECT * FROM tbPositions")
or die("There are no records to display ... \n" . mysqli_error()); 
if (mysqli_num_rows($result)<1){
    $result = null;
}

?>

<?php

// inserting sql query
if (isset($_POST['Submit'])) {
$newPosition = addslashes( $_POST['position'] ); //prevents types of SQL injection

$sql = mysqli_query( $con,"INSERT INTO tbPositions(position_name) VALUES ('$newPosition')" )
        or die("Could not insert position at the moment". mysqli_error() );

// redirect back to positions
   header("Location: positions.php");
}

?>

<?php

// deleting sql query
// check if the 'id' variable is set in URL
if (isset($_GET['id']))
{
// get id value
$id = $_GET['id'];

// delete the entry
$result = mysqli_query($con,"DELETE FROM tbPositions WHERE position_id='$id'")
or die("The position does not exist ... \n"); 

// redirect back to positions
header("Location: positions.php");
}

?>

<html>
<head>
  <title>Vote-Chain</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
  <link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
  <script language="JavaScript" src="js/user.js"></script>
</head>

<body id="top">

<div class="wrapper row1">
  <header id="header" class="hoc clear"> 
    
    <div id="logo" class="fl_left">
      <h1><a href="admin.php">Vote-Chain</a></h1>
    </div>
    <nav id="mainav" class="fl_right">
      <ul class="clear">
        <li class="active"><a href="admin.php">Home</a></li>
        <li><a class="drop" href="#">Admin Panel</a>
          <ul>
            <li><a href="manage-admins.php">Admin Manager</a></li>
            <li><a href="positions.php">Manage Parties</a></li>
            <li><a href="candidates.php">Manage Members</a></li>
            <li><a href="refresh.php">Results</a></li>
          </ul>
        </li>
        
        <li><a href="logout.php">Logout</a></li>
      </ul>
    </nav>
  </header>
</div>

<div id="header" class="hoc clear"></div>

<div>
	<table width="380" align="center">
		<CAPTION><h3 style="color: #ffffff">ADD NEW PARTY</h3></CAPTION>

		<form name="fmPositions" id="fmPositions" action="positions.php" method="post" onsubmit="return positionValidate(this)">
			<tr>
			    <td bgcolor="#5D7B9D" style="color: #ffffff; width: 30%;">Party Name</td>

			    <td bgcolor="#5D7B9D" style="color: #000000; width: 40%;">
			    	<input type="text" name="position" value="" class="my-input"/>
			    </td>

			    <td bgcolor="#5D7B9D" style="color: #000000; width: 30%;">
			    	<input type="submit" name="Submit" value="Add" class="my-button"/>
			    </td>
			</tr>
		</form>
	</table>

	<table border="0" width="420" align="center">
		<CAPTION><h3 style="color: #ffffff">AVAILABLE PARTIES</h3></CAPTION>
		<tr bgcolor="#5D7B9D">
		  <td bgcolor="#5D7B9D" style="color: #ffffff">Party ID</td>
		  <td bgcolor="#5D7B9D" style="color: #ffffff">Party Name</td>
      <td bgcolor="#5D7B9D"></td>
		</tr>

		<?php

		//loop through all table rows
		while ($row=mysqli_fetch_array($result)) {
			echo "<tr>";
			echo '<td style="color: #000000">' . $row['position_id']."</td>";
			echo '<td style="color: #000000">' . $row['position_name']."</td>";
			echo '<td style="color: #000000">'.'<a style="color: #5D7B9D" href="positions.php?id=' . $row['position_id'] . '"><b>Delete Party</b></a></td>';
			echo "</tr>";
		}

		mysqli_free_result($result);
		

		?>

	</table>
</div>

<a id="backtotop" href="#top"><i class="fa fa-chevron-up"></i></a>

<!-- JAVASCRIPTS -->
<script src="layout/scripts/jquery.min.js"></script>
<script src="layout/scripts/jquery.backtotop.js"></script>
<script src="layout/scripts/jquery.mobilemenu.js"></script>
<!-- IE9 Placeholder Support -->
<script src="layout/scripts/jquery.placeholder.min.js"></script>
<!-- / IE9 Placeholder Support -->
</body>
</html>