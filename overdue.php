<!DOCTYPE html>
<html>

<head>
  <title> Library Database </title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>


<body>
  <ul>
    <li><a href="staff.php">Home</a></li>
    <li><a class="active" href="overdue.php">Overdue</a></li>
    <li><a href="event.php">Events</a></li>
    <li style="float:right"><a href="signin.php">Sign out</a></li>
  </ul>


  <!--a div class set up for the database heading-->
  <h1> Overdue Books </h1>

  <?php
  include "phpfunctions.php";
  function printResult($type, $result) { //prints results from a select statement
    echo "<table>";
    echo "<tr>
    <th>Book ID</th>
    <th>Name</th>
    <th>Borrowed by</th>
    </tr>";
    while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
      echo "<tr>
      <td>" . $row["MEDIAID"] . "</td>
      <td>" . $row["NAME"] . "</td>
      <td>" . $row["MNAME"] . "</td>
      </tr>";
    }
    echo "</table>";
  }

  // Connect Oracle...
  if ($db_conn) {
    //GET BOOKS
    $booklist = "SELECT MB.name as MName, O.mediaid, B.bookTitle as Name, M.borrowDate
    FROM Orders O, Book B, Media M, Member MB
    WHERE O.mediaid = B.mediaid AND B.mediaid = M.mediaid AND Mb.mid = O.mid
    AND M.availability = 'no' AND (M.borrowDate + 36) < SYSDATE";
    printResult("Book", executePlainSQL($booklist));
    //GET DVDS
    $dvdlist = "SELECT MB.name as MName, O.mediaid, B.dvdTitle as Name, M.borrowDate
    FROM Orders O, DVD D, Media M, Member MB
    WHERE O.mediaid = B.mediaid AND B.mediaid = M.mediaid AND Mb.mid = O.mid
    AND M.availability = 'no' AND (M.borrowDate + 36) < SYSDATE";
    printResult("DVD", executePlainSQL($dvdlist));
    //GET EQUIPMENT
    $equiplist = "SELECT MB.name as MName, O.mediaid, E.equipname as Name, M.borrowDate
    FROM Orders O, Equipment E, Media M, Member MB
    WHERE O.mediaid = B.mediaid AND B.mediaid = M.mediaid AND Mb.mid = O.mid
    AND M.availability = 'no' AND (M.borrowDate + 36) < SYSDATE";
    printResult("Equipment", executePlainSQL($equiplist));
    //Commit to save changes...
    OCILogoff($db_conn);
  } else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
  }
  ?>
</body>
</html>
