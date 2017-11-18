<!DOCTYPE html>
<html>

  <head>
    <title> Library Database </title>
    <link rel="stylesheet" type="text/css" href="style.php"/>
  </head>


  <body>
    <div class="menu">
      <!--can't get this to work for some reason... < ?php require 'menu.php';?>-->
      <a href="member.php">Home</a>
      <a href="media_member.php">Search media</a>
	  <a href="mediacatalog.php">Media Catalog</a>
      <a href="signin.php">Sign out</a>
    </div>


  <!--setting the background color-->
  <style>
    body { background-color: Ivory }
  </style>

<!--a div class set up for the database heading-->
    <div>
      <h1> Media Catalog </h1>
    </div>
  </body>
</html>

<?php
$success = True;
$db_connection = OCILogon("ora_i4i8", "a68033083", "dbhost.ugrad.cs.ubc.ca:1522/ug");

function executePlainSQL($commandString){
  // function that executes SQL commands with bound variables
  global $db_connection, $success;
  $statement = OCIParse($db_connection, $commandString);

  if (!$statement){
    echo "<br>Cannot parse the following command: " . $commandString . "<br>";
    $error = OCI_Error($db_connection);
    echo htmlentities($error['message']);
    $success = False;
  }

  $exec = OCIExecute($statement, OCI_DEFAULT);
  if (!$exec){
    echo "<br>Cannot execute the following command for EPSQL: " . $commandString . "<br>";
    $error = OCI_Error($statement);
    echo htmlentities($error['message']);
    $success = false;
  } else {

  }
  return $statement;
}

function executeBoundSQL($commandString, $list){
  global $db_connection, $success;
  $statement = OCIParse($db_connection, $commandString);
// parse SQL command
  if (!$statement){
    echo "<br> Cannot parse the following command: " . $commandString . "<br>";
    $error = OCI_Error($db_connection);
    echo htmlentities($error['message']);
    $success = False;
  }

  foreach ($list as $tuple) {
    foreach ($tuple as $bind => $val){
      OCIBindByName($statement, $bind, $val);
      unset($val);
    }
    $exec = OCIExecute($statement, OCI_NO_AUTO_COMMIT);
    //executes SQL command
    if (!$exec) {
      echo "<br>Cannot execute the following command for EBSQL: " . $commandString . "<br>";
      $error = OCI_Error($statement);
      echo htmlentities ($error['message']);
      echo "<br>";
      $success = False;
    }
  }
}

function printResult($result){
  echo "<br><h2>Books:</h2><br>";
	echo "<table style='border:2px solid black'>";
	echo "<tr>
<th style='border:1px solid black'>Media Id</th>
  <th style='border:1px solid black'>Book Title</th>
  <th style='border:1px solid black'>Reserved</th>
  <th style='border:1px solid black'>Availability</th>
  <th style='border:1px solid black'>Location</th>
  </tr>";

  while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
    echo "<tr><td style='border:1px solid black'>" . $row["MEDIAID"] . "</td>
    <td style='border:1px solid black'>" . $row["BOOKTITLE"] . "</td>
    <td style='border:1px solid black'>" . $row["RESERVED"] . "</td>
    <td style='border:1px solid black'>" . $row["AVAILABILITY"] . "</td>
	<td style='border:1px solid black'>" . $row["LOCNAME"] . "</td>
    </tr>";
  }
  echo "</table>";
}

function printResult2($result){
  echo "<br><h2>DVDs:</h2><br>";
	echo "<table style='border:2px solid black'>";
	echo "<tr>
<th style='border:1px solid black'>Media Id</th>
  <th style='border:1px solid black'>DVD Title</th>
  <th style='border:1px solid black'>Reserved</th>
  <th style='border:1px solid black'>Availability</th>
  <th style='border:1px solid black'>Location</th>
  </tr>";

  while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
    echo "<tr><td style='border:1px solid black'>" . $row["MEDIAID"] . "</td>
    <td style='border:1px solid black'>" . $row["DVDTITLE"] . "</td>
    <td style='border:1px solid black'>" . $row["RESERVED"] . "</td>
    <td style='border:1px solid black'>" . $row["AVAILABILITY"] . "</td>
	<td style='border:1px solid black'>" . $row["LOCNAME"] . "</td>
    </tr>";
  }
  echo "</table>";
}

function printResult3($result){
  echo "<br><h2>Equipment:</h2><br>";
	echo "<table style='border:2px solid black'>";
	echo "<tr>
<th style='border:1px solid black'>Media Id</th>
  <th style='border:1px solid black'>Equipment Name</th>
  <th style='border:1px solid black'>Reserved</th>
  <th style='border:1px solid black'>Availability</th>
  <th style='border:1px solid black'>Location</th>
  </tr>";

  while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
    echo "<tr><td style='border:1px solid black'>" . $row["MEDIAID"] . "</td>
    <td style='border:1px solid black'>" . $row["EQUIPNAME"] . "</td>
    <td style='border:1px solid black'>" . $row["RESERVED"] . "</td>
    <td style='border:1px solid black'>" . $row["AVAILABILITY"] . "</td>
	<td style='border:1px solid black'>" . $row["LOCNAME"] . "</td>
    </tr>";
  }
  echo "</table>";
}

if ($db_connection){
  if ($_POST && $success) {
    header ("location: mediacatalog.php");
  } else {
    $result = executePlainSQL("select * from BookCatalog");
    printResult($result);
	
	$result = executePlainSQL("select * from DVDCatalog");
    printResult2($result);
	
	$result = executePlainSQL("select * from EquipmentCatalog");
    printResult3($result);
  }
  OCILogoff($db_connection);
} else {
  echo "cannot connect";
	$error = OCI_Error(); // For OCILogon errors pass no handle
	echo htmlentities($error['message']);
}
?>
