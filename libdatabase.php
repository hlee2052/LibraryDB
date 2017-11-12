<!DOCTYPE html>
<html>

  <head>
  <title> Library Database </title>
  <link rel="stylesheet" type="text/css" href="style.php"/>
  </head>
  <body>

  <!--setting the background color-->
  <style>
    body { background-color: Ivory }
  </style>

<!--a div class set up for the database heading-->
    <div class="title_db">
      <p> Library Database </p>
    </div>

<!-- this will later be our drop table SQL command-->
    <p> Reset Table </p>
    <form method="POST" action="libdatabase.php">
    <p><input type="submit" value="reset" name="reset"></p>
    </form>

    <p> Insert Library Events </p>
    <p><font size="2"> Event ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      Event Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Start Time&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      EndTime</font></p>
    <form method="POST" action="libdatabase.php">
    <!--refresh page when submit-->

       <p><input type="text" name="evNo" size="8">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="text" name="evName" size="8">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="text" name="evStartTime" size="8">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="text" name="evEndTime" size="8">
    <!--define 4 variables to pass the value-->

          <input type="submit" value="insert" name="insertsubmit"></p>
          <!-- this is our insert SQL command-->
          <!--type:"submit" defines a submit button
              value:"insert" the text that is printed on the button
              name: "insertsubmit" the name we will use to create the SQL command-->
          </form>

    <p> Update Library Event Name </p>
    <p><font size="2"> Old Name&nbsp;&nbsp;&nbsp;&nbsp;
    New Name</font></p>
    <form method="POST" action="libdatabase.php">
      <!--input 1-->
      <p><input type="text", name="oldName" size="16">
      <!--input 2-->
        <input type="text" name="newName" size="16">
        <input type="submit" value="update" name="updatesubmit"></p>
    </form>
    </body>
</html>

    <?php
    $success = True;
    //need to pass variables here
    //$db_connection = OCILogon("ora_username", "password", "dbhost.ugrad.cs.ubc.ca:1522/ug");


    function executePlainSQL($commandString){
      // function that executes SQL commands with bound variables
      global $db_connection, $success;
      $statement = OCIParse($db_connection, $commandString);

      if (!$statement){
        echo "<br>Cannot parse the following commands: " . $commandString . "<br>";
        $error = OCI_Error($db_connection);
        echo htmlentities($error['message']);
        $success = False;
      }

      $exec = OCIExecute($statement, OCI_DEFAULT);
      if (!$r){
        echo "<br>Cannot execute the following command: " . $commandString . "<br>";
        $error = OCI_Error($statement);
        echo htmlentities($error['message']);
        $success = false;
      } else {

      }
      return $statement;

    }

function executeBountSQL($commandString, $list){
  global $db_connection, $success;
  $statement = OCIParse($db_connection, $commandString);
  // parse SQL command
  if (!$statement){
    echo "<br> Cannor parse the following command: " . $commandString. "<br>";
    $error = OCI_Error($db_connection);
    echo htmlentities($error['message']);
    $success = False;
  }

  foreach ($list as $tuple) {
    foreach ($tuple as $bind => $val){
      OCIBindByName($statement, $bind, $val);
      unset($val);
      }

  $r = OCIExecute($statement, OCI_default);
  //executes SQL command
  if (!$r) {
    echo "<br> Cannot execute the following command: " .commandString. "<br>";
    $error = OCI_Error($statement);
    echo htmlentities ($error['message']);
    echo "<br>";
    $success = False;
  }
}
}

  function printResult($result){
    echo "<br> Got data from Events table: <br>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
      echo $row[0];
    }
    echo "</table>";
  }


?>
