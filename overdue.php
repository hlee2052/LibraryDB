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
  <h1> Overdue media </h1>

    <?php
    include "phpfunctions.php";
    function printResult($type, $result) { //prints results from a select statement
      echo "<h2>" . $type . "</h2>";
    	echo "<table style='border:2px solid red'>";
    	echo "<tr>
      <th style='border:1px solid black'>ID</th>
      <th style='border:1px solid black'>Name</th>
      <th style='border:1px solid black'>Borrowed by</th>
      <th style='border:1px solid black'>Borrow date</th>
      <th style='border:1px solid black'>Days overdue</th>
      <th style='border:1px solid black'>Reserved</th>
      </tr>";
    	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
    		echo "<tr>
        <td style='border:1px solid red'>" . $row["MEDIAID"] . "</td>
        <td style='border:1px solid red'>" . $row["NAME"] . "</td>
        <td style='border:1px solid red'>" . $row["MID"] . "</td>
        <td style='border:1px solid red'>" . $row["BORROWDATE"] . "</td>
        <td style='border:1px solid red'>" . $row["DAYSOVERDUE"] . "</td>
        <td style='border:1px solid red'>" . $row["RESERVED"] . "</td>
        </tr>";
    	}
    	echo "</table>";
    }

    // Connect Oracle...
    if ($db_conn) {
      //GET BOOKS
      $booklist = executePlainSQL("select * from tab1");
    	printResult("Book", $booklist);
      //GET DVDS
      $dvdlist = executePlainSQL("select * from tab1");
    	printResult("DVD", $dvdlist);
      //GET EQUIPMENT
      $equiplist = executePlainSQL("select * from tab1");
    	printResult("Equipment", $equiplist);

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
