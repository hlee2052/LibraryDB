<!DOCTYPE html>
<html>

<head>
  <title> Library Database </title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>


<body>
  <ul>
    <li><a class="active" href="staff.php">Home</a></li>
    <li><a href="overdue.php">Overdue</a></li>
    <li><a href="event.php">Events</a></li>
    <li style="float:right"><a href="signin.php">Sign out</a></li>
  </ul>

  <!--a div class set up for the database heading-->
  <div>

    <p>Show staff who have fines to pay:</p>
    <form method="POST" action="staff.php">
      <p><input type="submit" value="show staff with fines to pay" name="staffFines"></p>
    </form>


    <p>Fire Staff with given ID:</p>
    <form method="POST" action="staff.php">
      <p><input type="text" name="staffID" size="6">
        <input type="submit" value="Fire staff given ID" name="fireStaff"></p>
      </form>


      <p>Show staff who work at multiple locations:</p>
      <form method="POST" action="staff.php">
        <p><input type="submit" value="show staff who works at multiple locations" name="staffLocation"></p>
      </form>
    </div>
  </body>
  </html>



  <?php


  function alert($msg) {
    echo "<script type='text/javascript'>alert('$msg');</script>";
  }

  function executePlainSQL($cmdstr) { //takes a plain (no bound variables) SQL command and executes it
    //echo "<br>running ".$cmdstr."<br>";
    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr); //There is a set of comments at the end of the file that describe some of the OCI specific functions and how they work

    if (!$statement) {
      echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
      $e = OCI_Error($db_conn); // For OCIParse errors pass the
      // connection handle
      echo htmlentities($e['message']);
      $success = False;
    }

    $r = OCIExecute($statement, OCI_DEFAULT);
    if (!$r) {
      echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
      $e = oci_error($statement); // For OCIExecute errors pass the statementhandle
      echo htmlentities($e['message']);
      $success = False;
    } else {

    }
    return $statement;
  }

  function printResult($result) { //prints results from a select statement
    echo "<br>Got data from table tab1:<br>";
    echo "<table>";
    echo "<tr><th>ID</th><th>Name</th><th>Addresss</th></tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
      echo "<tr><td>" . $row["NID"] . "</td><td>" . $row["NAME"] ."</td><td>" . $row["ADDRESS"]."</td></tr>"; //or just use "echo $row[0]"

    }
    echo "</table>";

  }

  function executeBoundSQL($cmdstr, $list) {
    /* Sometimes the same statement will be executed for several times ... only
    the value of variables need to be changed.
    In this case, you don't need to create the statement several times;
    using bind variables can make the statement be shared and just parsed once.
    This is also very useful in protecting against SQL injection.
    See the sample code below for how this functions is used */

    global $db_conn, $success;
    $statement = OCIParse($db_conn, $cmdstr);

    if (!$statement) {
      echo "<br>Cannot parse the following command: " . $cmdstr . "<br>";
      $e = OCI_Error($db_conn);
      echo htmlentities($e['message']);
      $success = False;
    }

    foreach ($list as $tuple) {
      foreach ($tuple as $bind => $val) {
        //echo $val;
        //echo "<br>".$bind."<br>";
        OCIBindByName($statement, $bind, $val);
        unset ($val); //make sure you do not remove this. Otherwise $val will remain in an array object wrapper which will not be recognized by Oracle as a proper datatype

      }
      $r = OCIExecute($statement, OCI_DEFAULT);
      if (!$r) {
        echo "<br>Cannot execute the following command: " . $cmdstr . "<br>";
        $e = OCI_Error($statement); // For OCIExecute errors pass the statement handle
        echo htmlentities($e['message']);
        echo "<br>";
        $success = False;
      }
    }

  }

  /*
  Start of the code
  */

  $db_conn = OCILogon("ora_i4i8", "a68033083", "dbhost.ugrad.cs.ubc.ca:1522/ug");
  if (!$db_conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
  }

  // Prepare the statement
  $stid ;

  $stid = oci_parse($db_conn, 'SELECT * FROM Staff');
  if (!$stid) {
    $e = oci_error($conn);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
  }
  
  // Perform the logic of the query
  $r = oci_execute($stid);
  if (!$r) {
    $e = oci_error($stid);
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
  }


  if ($db_conn){


    if (array_key_exists('staffFines', $_POST)) {



      $SQLquery = "SELECT M.name, S.mid, S.role,  M.fines
      FROM Staff S, Member M
      WHERE S.mid = M.mid and M.fines>0";



      //$stid = oci_parse($conn, $SQLquery);
      //$r = oci_execute($stid);

      $result = executePlainSQL($SQLquery);
      OCICommit($db_conn);
      echo "<br>List of Staff members wth fines to pay</br>";

      echo "<table>";
      echo "<tr><th>Name</th>
      <th>Member ID</th>
      <th>Role</th>
      <th>Fines</th></tr>";

      while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["NAME"] . "</td><td>".$row["MID"]."</td><td>".$row["ROLE"]."</td><td>$".$row["FINES"]. ".00</td></tr>";
      }
      echo "</table>";
      echo "</table>";

    }

    if (array_key_exists('fireStaff', $_POST)) {


      $variable1 = $_POST['staffID'];

      $tuple = array (
        ":bind1" => $_POST['staffID'],
      );
      $alltuples = array (
        $tuple
      );

      $SQLquery ="DELETE
      FROM  Staff
      Where Staff.mid =:bind1";


      //$stid = oci_parse($conn, $SQLquery);
      //$r = oci_execute($stid);

      executeBoundSQL($SQLquery, $alltuples);

      //commit after executeBoundSQL


      $message = "The staff with id ${variable1} has been fired if exists in the database";
      echo "<script type='text/javascript'>alert('$message');</script>";
      $r = oci_commit($db_conn);
      if (!$r) {
        $e = oci_error($db_conn);
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
      }


    }

    if (array_key_exists('staffLocation', $_POST)) {



      $SQLquery =
      "SELECT mid, name
      FROM Member
      where MID  in (
        SELECT E.mid
        FROM StaffEmployment E
        GROUP BY E.mid
        HAVING COUNT(empId)>1)";




        //$stid = oci_parse($conn, $SQLquery);
        //$r = oci_execute($stid);

        $result = executePlainSQL($SQLquery);
        OCICommit($db_conn);
        echo "<br>Employer that works at multiple loc<br>";

        echo "<table>";

        echo "<tr><th>Name</th>
        <th>Member ID</th>

        </tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
          echo "<tr><td>".$row["MID"]."</td><td>".$row["NAME"]. "</td></tr>";
        }
        echo "</table>";
      }


      ////////////////////////

      $r = oci_commit($db_conn);
      if (!$r) {
        $e = oci_error($db_conn);
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
      }

      if ($_POST && $success) {
        //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
        header("location: staff.php");
      } else {
        // Select data...

        $allMembers = "SELECT M.name, S.mid, S.role,  M.fines
        FROM Staff S, Member M
        WHERE S.mid = M.mid";

        $memberList = executePlainSQL($allMembers);
        echo "<br>List of Current Staff Members<br>";

        echo "<table>";
        echo "<tr><th>Name</th>
        <th>Member ID</th>
        <th>Role</th>
        <th>Fines</th></tr>";

        while ($row = OCI_Fetch_Array($memberList, OCI_BOTH)) {
          echo "<tr><td>" . $row["NAME"] . "</td><td>".$row["MID"]."</td><td>".$row["ROLE"]."</td><td>".$row["FINES"]. "</td></tr>";
        }
        echo "</table>";


        OCILogoff($db_conn);
      }

    }

    ?>
