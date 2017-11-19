<!DOCTYPE html>
<html>

<head>
  <title> Library Database </title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>


<body>
  <ul>
    <li><a href="member.php">Home</a></li>
    <li><a class="active" href="media_member.php">Search Media</a></li>
    <li><a href="mediacatalog.php">Media Catalog</a></li>
    <li style="float:right"><a href="signin.php">Sign out</a></li>
  </ul>

  <div>
    <h1> Media - Book page </h1>
    <p>Search book with keyword to see who borrowed it (allows partial search, case insensitive):
    </p>
    <form method="POST" action="media_member.php">
      <p><input type="text" name="bookString" size="6">
        <input type="submit" value="Search Book" name="searchBook"></p>
      </form>

      <p> Search how many books are there given exact title: (case insensitive) </p>
      <form method="POST" action="media_member.php">
        <p><input type="text" name="numBookString" size="6">
          <input type="submit" value="search number of books" name="numBook"></p>
        </form>

    <?php

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

      if (array_key_exists('searchBook', $_POST)) {

        $variable1 = 0;
        $variable1 = strtoupper($_POST['bookString']);

        $stringMatch = '%'.$variable1.'%';

        if ($stringMatch!==''){
          $tuple = array (
            ":bind1" => $stringMatch,
          );
          $alltuples = array (
            $tuple
          );

          $SQLquery = "SELECT MB.name, O.mediaid, B.bookTitle
          FROM Orders O, Book B, Media M, Member MB
          WHERE O.mediaid = B.mediaid AND B.mediaid = M.mediaid
          AND
          MB.mid = O.mid
          AND UPPER(B.bookTitle) LIKE '${stringMatch}'";

          $result = executePlainSQL($SQLquery);
          OCICommit($db_conn);
          echo "<br>See who has checked out the books containing the keyword<br>";

          echo "<table>";
          echo "<tr><th>Name</th><th>MediaID</th><th>book title</th></tr>";

          while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
            echo "<tr><td>" . $row["NAME"] . "</td><td>" .  $row["MEDIAID"] ."</td><td>"  .$row["BOOKTITLE"]."</td></tr>";
          }
          echo "</table>";
        }
      }

      if (array_key_exists('numBook', $_POST)) {
        $variable1 = strtoupper($_POST['numBookString']);
        $stringMatch = $variable1;
        $tuple = array (
          ":bind1" => $stringMatch,
        );
        $alltuples = array (
          $tuple
        );

        $SQLquery = "SELECT COUNT(B.mediaid) as MYCOUNT , B.bookTitle
        FROM  Book B
        Where upper(B.bookTitle) like upper('${variable1}')
        GROUP BY B.bookTitle";

        $result = executePlainSQL($SQLquery);
        OCICommit($db_conn);
        echo "<br>Number of books given title<br>";

        echo "<table>";
        echo "<tr><th>Title</th><th>Quantity</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
          echo "<tr><td>" . $row["BOOKTITLE"] . "</td><td>" .  $row["MYCOUNT"] ."</td></tr>";
        }
        echo "</table>";
      }

      if (array_key_exists('showEvent', $_POST)) {

        $SQLquery = "SELECT * FROM Event Order By startTime DESC";
        $result = executePlainSQL($SQLquery);

        OCICommit($db_conn);
        echo "<br> Event sorted by the latest start time<br>";

        echo "<table>";
        echo "<tr><th>event ID</th><th>startTime</th><th>endTime</th><th>eventName</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
          echo "<tr><td>" . $row["EID"] . "</td><td>" .  $row["STARTTIME"] ."</td><td>"  .$row["ENDTIME"]."</td><td>"
          .$row["ENAME"].
          "</td></tr>";
        }
        echo "</table>";
      }

      if (array_key_exists('showEventNum', $_POST)) {

        $SQLquery = "SELECT * FROM Location";
        $result = executePlainSQL($SQLquery);

        OCICommit($db_conn);
        echo "<br> Number of Events by Locations<br>";

        echo "<table>";
        echo "<tr><th>Location Name</th><th>Number</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
          echo "<tr><td>" . $row["LOCNAME"] . "</td><td>" .  $row["COUNT()"] . "</td></tr>";
        }
        echo "</table>";
      }

      $r = oci_commit($db_conn);
      if (!$r) {
        $e = oci_error($db_conn);
        trigger_error(htmlentities($e['message']), E_USER_ERROR);
      }

      if ($_POST && $success) {
        //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
        header("location: media_member.php");
      } else {
        OCILogoff($db_conn);
      }
    }
    ?>
    </div>
  </body>
</html>
