<!DOCTYPE html>
<html>

<head>
  <title> Library Database </title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>


<body>
  <ul>
    <li><a href="staff.php">Home</a></li>
    <li><a href="overdue.php">Overdue</a></li>
    <li><a class="active" href="event.php">Events</a></li>
    <li style="float:right"><a href="signin.php">Sign out</a></li>
  </ul>


  <!--a div class set up for the database heading-->
  <h1> Event </h1>

  <!-- <p>If you wish to reset the table, press the reset button. If this is the first time you're running this page, you MUST use reset</p>
  <form method="POST" action="event.php">
  <p><input type="submit" value="Reset" name="reset"></p>
</form> -->
<h2> Create New Event </h2>
<form method ="POST" action="event.php">
  Event ID: <input type="text" name="eid" placeholder="event ID"></input>
  Start Time: <input type="text" name="startTime" placeholder="YYYY-MM-DD 00.00"></input>
  End Time: <input type="text" name="endTime" placeholder="YYYY-MM-DD 00.00"></input>
  Event Name: <input type="text" name="ename" placeholder="event name"></input>
  Room: <input type="text" name="roomNumber" placeholder="room number"></input>
  Location: <input type="text" name="lid" placeholder="event location"></input>
  <input type="submit" value="insert" name="insertsubmit"></input>
</form>

<h2> Cancel Event </h2>
<form method ="POST" action="event.php">
  <input type="text" name="oldeid" placeholder="event ID"></input>
  <input type="submit" value="cancel" name="deleteupdate"></input>
</form>
</body>
</html>

<?php
$success = True;
$db_connection = OCILogon("ora_n4s0b", "a18623124", "dbhost.ugrad.cs.ubc.ca:1522/ug");
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
  echo "<br><h2>List of Events</h2><br>";
  echo "<table>";
  echo "<tr>
  <th>Event ID</th>
  <th>Start Time</th>
  <th>End Time</th>
  <th>Name</th>
  <th>Room</th>
  <th>Location</th>
  </tr>";

  while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
    echo "<tr><td>" . $row["EID"] . "</td>
    <td>" . $row["STARTTIME"] . "</td>
    <td>" . $row["ENDTIME"] . "</td>
    <td>" . $row["ENAME"] . "</td>
    <td>" . $row["ROOMNUMBER"] . "</td>
    <td>" . $row["LID"] . "</td>
    </tr>";
  }
  echo "</table>";
}

if ($db_connection){
  if (array_key_exists('insertsubmit', $_POST)){
    $tuple = array (
      ":bind1" => $_POST['eid'],
      ":bind2" => $_POST['startTime'],
      ":bind3" => $_POST['endTime'],
      ":bind4" => $_POST['ename'],
      ":bind5" => $_POST['roomNumber'],
      ":bind6" => $_POST['lid']
    );
    $alltuples = array (
      $tuple
    );
    executeBoundSQL("insert into event values (:bind1, :bind2, :bind3, :bind4, :bind5, :bind6)", $alltuples);
    OCICommit($db_connection);
  }

  if (array_key_exists ('deleteupdate', $_POST)){
    $tuple = array (":bind1" => $_POST['oldeid']);
    $alltuples = array ($tuple);
    executeBoundSQL("delete from event where eid = :bind1", $alltuples);
    OCICommit($db_connection);
  }

  if ($_POST && $success) {
    header ("location: event.php");
  } else {
    $result = executePlainSQL("select * from event");
    printResult($result);
  }
  OCILogoff($db_connection);
} else {
  echo "cannot connect";
  $error = OCI_Error(); // For OCILogon errors pass no handle
  echo htmlentities($error['message']);
}
?>
