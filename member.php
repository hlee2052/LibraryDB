<!DOCTYPE html>
<html>

<head>
  <title> Library Database </title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>


<body>
  <ul>
    <li><a class="active" href="member.php">Home</a></li>
    <li><a href="media_member.php">Search media</a></li>
    <li><a href="mediacatalog.php">Media Catalog</a></li>
    <li style="float:right"><a href="signin.php">Sign out</a></li>
  </ul>

  <!--a div class set up for the database heading-->
  <div>
    <h1> Member Home Page</h1>

    <p> Type Member ID to see the borrowed media: </p>
    <form method="POST" action="member.php">
      <p><input type="text" name="userID" size="6">
        <input type="submit" value="Search User" name="updateUser"></p>
      </form>
      <br>
      <br>
      <!--user returns book----->

      <p> Type mediaID to be returned: </p>
      <form method="POST" action="member.php">
        <p><input type="text" name="mediaID" size="6">
          <input type="submit" value="Return media" name="updateMedia"></p>
        </form>

      </div>

    <?php
    include "phpfunctions.php";

    function printResult($result) { //prints results from a select statement
      echo "<br>Got data from table tab1:<br>";
      echo "<table>";
      echo "<tr><th>ID</th><th>Name</th><th>Addresss</th></tr>";

      while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<tr><td>" . $row["NID"] . "</td><td>" . $row["NAME"] ."</td><td>" . $row["ADDRESS"]   .     "</td></tr>"; //or just use "echo $row[0]"

      }
      echo "</table>";

    }

    if ($db_conn){


      if (array_key_exists('updateUser', $_POST)) {

        $variable1 = 0;
        $variable1 = $_POST['userID'];
        $tuple = array (
          ":bind1" => $_POST['userID'],
        );
        $alltuples = array (
          $tuple
        );

        $SQLquery = "SELECT * FROM Member  WHERE mid='${variable1}'";

        //$stid = oci_parse($conn, $SQLquery);
        //$r = oci_execute($stid);



        $result = executePlainSQL($SQLquery);
        OCICommit($db_conn);
        echo "<br>The Current User<br>";

        echo "<table>";
        echo "<tr><th>memberID</th>
        <th>Fine</th>
        <th>Email</th>
        <th>phone</th>
        <th>Name</th>
        <th>address</th></tr>";

        while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
          echo "<tr><td>" . $row["MID"] . "</td><td>" .  $row["FINES"] ."</td><td>"  .$row["EMAIL"]. "</td><td>" .$row["PHONE"]."</td><td>"
          .$row["NAME"] ."</td><td>" . $row["ADDRESS"]. "</td></tr>"; //or just use "echo $row[0]"

        }
        echo "</table>";



        print "</br>";

        print "<br>Currently borrowed media List by memberID: ${variable1} </br>";


        $mediaQuery = "SELECT mediaid FROM Orders WHERE mid='${variable1}'";

        $resultMedia = executePlainSQL($mediaQuery);
        OCICommit($db_conn);
        echo "<table>";
        echo "<tr><th>mediaID</th></tr>";

        while ($row = OCI_Fetch_Array($resultMedia, OCI_BOTH)) {
          echo "<tr><td>" . $row["MEDIAID"] .  "</td></tr>"; //or just use "echo $row[0]"

        }
        echo "</table>";

        OCICommit($db_conn);


      }

      if (array_key_exists('updateMedia', $_POST)) {

        $variable1 = $_POST['mediaID'];
        $tuple = array (
          ":bind1" => $_POST['mediaID'],
        );
        $alltuples = array (
          $tuple
        );

        executeBoundSQL("delete from Orders where mediaid=:bind1", $alltuples);
        $r = oci_commit($db_conn);
        if (!$r) {
          $e = oci_error($db_conn);
          trigger_error(htmlentities($e['message']), E_USER_ERROR);
        }

        executeBoundSQL("UPDATE media Set reserved='False', availability='yes'
          WHERE mediaid=:bind1", $alltuples);
          $r = oci_commit($db_conn);
          if (!$r) {
            $e = oci_error($db_conn);
            trigger_error(htmlentities($e['message']), E_USER_ERROR);
          }
        }


        if ($_POST && $success) {
          //POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
          header("location: member.php");
        } else {
          // Select data...

          $allMembers = "SELECT mediaid, availability
          FROM Media
          WHERE availability='yes'";

          $memberList = executePlainSQL($allMembers);
          echo "<br>List of available media<br>";

          echo "<table>";
          echo "<tr><th>MediaId</th>
          <th>Availability</th>

          </tr>";

          while ($row = OCI_Fetch_Array($memberList, OCI_BOTH)) {
            echo "<tr><td>" . $row["MEDIAID"] . "</td><td>".$row["AVAILABILITY"]. "</td></tr>";
          }
          echo "</table>";
        }
      }
      ?>
  </body>
</html>
