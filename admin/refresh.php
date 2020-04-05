<?php

$con = mysqli_connect("localhost","root","","poll");

session_start();

if(empty($_SESSION['admin_id'])) {
 header("location:access-denied.php");
}

?> 

<?php

$positions = mysqli_query($con,"SELECT * FROM tbPositions") or die("There are no records to display ... \n" . mysqli_error()); 

?>

<?php

if (isset($_POST['Submit'])) {
  $position = addslashes( $_POST['position'] ); 
   
  $result = mysqli_query($con,"SELECT * FROM tbCandidates WHERE candidate_position='$position'")
  or die(" There are no records at the moment ... \n"); 
}

?>

<?php


//}

?>

<html>
<head>
  <title>Vote-Chain</title>
  <link href="layout/styles/layout.css" rel="stylesheet" type="text/css" media="all">
  <script language="JavaScript" src="js/admin.js"></script>
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
  <div>
    <table width="420" align="center">
      <form name="fmNames" id="fmNames" method="post" action="refresh.php" onSubmit="return positionValidate(this)">
        <tr>
          <td bgcolor="#5D7B9D" style="color:#ffffff">Choose Party</td>
          <td bgcolor="#5D7B9D" style="color:#000000">
            <div class="my-select">
              <SELECT NAME="position" id="position">
                <OPTION  VALUE="select"><p style="color:black";>Select</p>
                <?php 

                while( $row = mysql_fetch_array( $positions ) ) {
                  echo "<OPTION VALUE=$row[position_name]>$row[position_name]"; 
                }

                ?>
              </SELECT>
            </div>
          </td>
          <td bgcolor="#5D7B9D" style="color:#000000"><input type="submit" name="Submit" value="See Results" class="my-button" /></td>
        </tr>
        <tr>
        </tr>
      </form> 
    </table>
    
    <br>

    <table width="420" align="center">
      <tr>
        <td bgcolor="#5D7B9D" style="color:#ffffff">Candidate Name</td>
        <td bgcolor="#5D7B9D" style="color:#ffffff">Vote(s)</td>
      </tr>

      <?php

      if( isset( $_POST['Submit'] ) ) {
        $result = mysqli_query($con,"SELECT * FROM tbcandidates WHERE candidate_position='$position'") or die("There are no records to display ... \n" . mysqli_error());

        while( $row = mysqli_fetch_array( $result ) ) {
          $blockchain = fopen( "../blockchain/blocks.txt", "r" ) or die( "Unable to open file!" );
          $candidate = $row['candidate_name'];

          $votes = 0;
          while( !feof( $blockchain ) ) {
            $data = fgets( $blockchain );
            if( substr_count( $data, $candidate ) ) {
              $votes += substr_count( $data, $candidate );
            }
          }

          fclose( $blockchain );

          echo "<tr>";
          echo "<td style='color: black;'>".$candidate."</td>";
          echo "<td style='color: black;'>"."<b>".$votes."</b>"."</td>";

/*          echo "<td style='color: black;'>".$row['candidate_name']."</td>";
          echo "<td style='color: black;'>"."<b>".$row['candidate_cvotes']."</b>"."</td>";*/
          echo "</tr>";
        }
      }

      ?>
        
    </table>
  
  </div>
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