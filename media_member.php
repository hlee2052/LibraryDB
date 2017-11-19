<!DOCTYPE html>
<html>

  <head>
    <title> Library Database </title>
    <link rel="stylesheet" type="text/css" href="style.css"/>
  </head>

  <body>
    <div class="menu">
      <a href="member.php">Home</a>
      <a href="media_member.php">Search media</a>
	    <a href="mediacatalog.php">MediaCatalog</a>
      <a href="signin.php">Sign out</a>
    </div>


  <!--setting the background color-->
  <style>
    body { background-color: Ivory }
  </style>

<!--a div class set up for the database heading-->
    <div>
      <h1> Media - Book page </h1>


	   <p><font size="4">Search book with keyword(partial keyword ok, case insensitive):</font>
	   <br><font size="3">only first name shown, no sensitive info(id) shown</font></br>
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









    </div>
  </body>
</html>

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


		//$stid = oci_parse($conn, $SQLquery);
		//$r = oci_execute($stid);

		$result = executePlainSQL($SQLquery);
		OCICommit($db_conn);
			echo "<br>See who has checked out the books containing the keyword<br>";

		echo "<table style='border:2px solid black'>";
		echo "<tr><th style='border:1px solid black'>Name</th><th style='border:1px solid black'>MediaID</th><th style='border:1px solid black'>book title</th></tr>";

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





		//$stid = oci_parse($conn, $SQLquery);
		//$r = oci_execute($stid);

		$result = executePlainSQL($SQLquery);
		OCICommit($db_conn);
			echo "<br>Number of books given title<br>";

		echo "<table style='border:2px solid black'>";
		echo "<tr><th style='border:1px solid black'>Title</th><th style='border:1px solid black'>Quantity</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
			echo "<tr><td>" . $row["BOOKTITLE"] . "</td><td>" .  $row["MYCOUNT"] ."</td></tr>";
		}
		echo "</table>";
		}







	if (array_key_exists('showEvent', $_POST)) {

		$SQLquery = "SELECT * FROM Event Order By startTime DESC";


		$result = executePlainSQL($SQLquery);

		OCICommit($db_conn);
		echo "<br><font size='4pt'>> Event sorted by the latest start time<font><br>";

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
		echo "<br><font size='4pt'>> Number of Events by Locations<font><br>";
		echo "<table>";
		echo "<tr><th>Location Name</th><th>Number</th></tr>";

		while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
			echo "<tr><td>" . $row["LOCNAME"] . "</td><td>" .  $row["COUNT()"] . "</td></tr>";
		}
		echo "</table>";
	}
?>
