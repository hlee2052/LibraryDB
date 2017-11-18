<!DOCTYPE html>
<html>

  <head>
    <title> Library Database </title>
    <link rel="stylesheet" type="text/css" href="style.php"/>
  </head>


  <body>
    <div class="menu">
      <a href="staff.php">Home</a>
      <a href="overdue.php">Overdue</a>
      <a href="event.php">events</a>
      <a href="signin.php">Sign out</a>
    </div>


  <!--setting the background color-->
  <style>
    body { background-color: Ivory }
  </style>

<!--a div class set up for the database heading-->
  <h1> Overdue Books </h1>

    <?php
    include "phpfunctions.php";
    function printResult($type, $result) { //prints results from a select statement
    	echo "<table style='border:2px solid red'>";
    	echo "<tr>
      <th style='border:1px solid black'>ID</th>
      <th style='border:1px solid black'>Name</th>
      <th style='border:1px solid black'>Borrowed by</th>
      </tr>";
    	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    		echo "<tr>
        <td style='border:1px solid red'>" . $row["MEDIAID"] . "</td>
        <td style='border:1px solid red'>" . $row["NAME"] . "</td>
        <td style='border:1px solid red'>" . $row["MNAME"] . "</td>
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
