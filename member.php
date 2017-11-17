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
      <a href="signin.php">Sign out</a>
    </div>


  <!--setting the background color-->
  <style>
    body { background-color: Ivory }
  </style>

<!--a div class set up for the database heading-->
    <div>
      <h1> Member Home Page (D4) </h1>
	  
	  <p> Type Member ID to see the borrowed media: </p>
	  <form method="POST" action="member.php">
       <p><input type="text" name="userID" size="6">
          <input type="submit" value="Search User" name="updateUser"></p>
      </form>
	  <br />
	  <br />
	  <!-----user returns book----->
	  
	  <p> Type mediaID to be returned: </p>
	  <form method="POST" action="member.php">
       <p><input type="text" name="mediaID" size="6">
          <input type="submit" value="Return media" name="updateMedia"></p>
      </form>
	  
	  
	  
	  
	  
	  
	  
	  <!--
      <p>display member name, address, phone, email, fines</p>
      <h3> list of media borrowed by user </h3>
      <ul>
        <li> book title <button>return</button> press to update media </li>
        <li> book title 2 <button>return</button> </li>
        <li> dvd title <button>return</button> </li>
        <li> equipment name <button>return</button> </li>
      </ul>
	  -->
    </div>
  </body>
</html>



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

function printResult($result) { //prints results from a select statement
	echo "<br>Got data from table tab1:<br>";
	echo "<table>";
	echo "<tr><th>ID</th><th>Name</th><th>Addresss</th></tr>";

	while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
		echo "<tr><td>" . $row["NID"] . "</td><td>" . $row["NAME"] ."</td><td>" . $row["ADDRESS"]   .     "</td></tr>"; //or just use "echo $row[0]" 

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
	
		echo "<table style='border:2px solid black'>";
		echo "<tr><th style='border:1px solid black'>memberID</th>
		<th style='border:1px solid black'>Fine</th>
		<th style='border:1px solid black'>Email</th>
		<th style='border:1px solid black'>phone</th>
		<th style='border:1px solid black'>Name</th>
		<th style='border:1px solid black'>address</th></tr>";

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
		echo "<table style='border:2px solid black'>";
		echo "<tr><th style='border:1px solid black'>mediaID</th></tr>";

		while ($row = OCI_Fetch_Array($resultMedia, OCI_BOTH)) {
			echo "<tr><td>" . $row["MEDIAID"] .  "</td></tr>"; //or just use "echo $row[0]" 

		}
		echo "</table>";
		
		OCICommit($db_conn);
		
		
		/* DONT USE THIS
		print $variable1;
	print "<table border='1'>\n";
    while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print "<tr>\n";
    foreach ($row as $item) {
       print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
     print "</tr>\n";
         }
       print "</table>\n";
       */
	   
	   
		}
		
	if (array_key_exists('updateMedia', $_POST)) {
		
		$variable1 = $_POST['mediaID'];
		$tuple = array (
				":bind1" => $_POST['mediaID'],
			);
			$alltuples = array (
				$tuple
			);
		
		//$SQLquery = "SELECT * FROM Member  WHERE mid='${variable1}'";
		
		//$stid = oci_parse($conn, $SQLquery);
		//$r = oci_execute($stid); 
		//OCICommit($db_conn);
		
		
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
	
		echo "<table style='border:2px solid black'>";
		echo "<tr><th style='border:1px solid black'>MediaId</th>
		<th style='border:1px solid black'>Availability</th>
		
		<th style='border:1px solid black'>Fines</th></tr>";

		while ($row = OCI_Fetch_Array($memberList, OCI_BOTH)) {
			echo "<tr><td>" . $row["MEDIAID"] . "</td><td>".$row["AVAILABILITY"]. "</td></tr>";
		}
		echo "</table>";
		
		
		
		
	}

	//Commit to save changes...
	OCILogoff($db_conn);

}


// Fetch the results of the query

//oci_free_statement($stid);
//oci_close($db_conn);

?>







