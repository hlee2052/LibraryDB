<!--Test Oracle file for UBC CPSC 304
  Created by Jiemin Zhang, 2011
  Modified by Simona Radu and others
  This file shows the very basics of how to execute PHP commands
  on Oracle.  
  specifically, it will drop a table, create a table, insert values
  update values, and then query for values
 
  IF YOU HAVE A TABLE CALLED "tab1" IT WILL BE DESTROYED

  The script assumes you already have a server set up
  All OCI commands are commands to the Oracle libraries
  To get the file to work, you must place it somewhere where your
  Apache server can run it, and you must rename it to have a ".php"
  extension.  You must also change the username and password on the 
  OCILogon below to be your ORACLE username and password -->

<p>If you wish to reset the table, press the reset button. If this is the first time you're running this page, you MUST use reset</p>
<form method="POST" action="testingPHP.php">
   
<p><input type="submit" value="Reset" name="reset"></p>
</form>

<p>Insert values into tab1 below !!!!:</p>
<p><font size="2"> Number&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
Addresss
</font></p>
<form method="POST" action="testingPHP.php">
<!--refresh page when submit-->

   <p><input type="text" name="insNo" size="6"><input type="text" name="insName" 
size="18"><input type="text" name="insAddr" size="16">
<!--define two variables to pass the value-->
      
<input type="submit" value="insert" name="insertsubmit"></p>
</form>
<!-- create a form to pass the values. See below for how to 
get the values--> 

<p> Update the name by inserting the old and new values below: </p>
<p><font size="2"> Old Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
New Name</font></p>
<form method="POST" action="testingPHP.php">
<!--refresh page when submit-->

   <p><input type="text" name="oldName" size="6"><input type="text" name="newName" 
size="18">
<!--define two variables to pass the value-->
      
<input type="submit" value="update" name="updatesubmit"></p>
<input type="submit" value="run hardcoded queries" name="dostuff"></p>
</form>



<p> Update the ADDRESS by inserting the old and new values below: </p>
<p><font size="2"> Old ADDRESS&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; 
New ADDRESS</font></p>


<form method="POST" action="testingPHP.php">
<!--refresh page when submit-->

   <p><input type="text" name="oldName1" size="6"><input type="text" name="newName1" 
size="18">
<!--define two variables to pass the value-->
      
<input type="submit" value="update" name="updatesubmit1"></p>
<input type="submit" value="run hardcoded queries" name="dostuff"></p>
</form>




<p> Delete all the rows with the given address: </p>
<p><font size="2"> ADDRESS</font></p>


<form method="POST" action="testingPHP.php">
<!--refresh page when submit-->

   <p><input type="text" name="address" size="6">
<!--define two variables to pass the value-->
      
<input type="submit" value="update" name="deleteSubmit"></p>
<input type="submit" value="run hardcoded queries" name="dostuff"></p>
</form>
























<?php

$conn = OCILogon("ora_i4i8", "a68033083", "dbhost.ugrad.cs.ubc.ca:1522/ug");
if (!$conn) {
    $e = oci_error();
    trigger_error(htmlentities($e['message'], ENT_QUOTES), E_USER_ERROR);
}

// Prepare the statement
$stid = oci_parse($conn, 'SELECT * FROM Member');
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


if ($conn){
	if (array_key_exists('insertsubmit', $_POST)) {
		print "<table border='1'>\n";
while ($row = oci_fetch_array($stid, OCI_ASSOC+OCI_RETURN_NULLS)) {
    print "<tr>\n";
    foreach ($row as $item) {
        print "    <td>" . ($item !== null ? htmlentities($item, ENT_QUOTES) : "&nbsp;") . "</td>\n";
    }
    print "</tr>\n";
}
print "</table>\n";

		}
}


// Fetch the results of the query

oci_free_statement($stid);
oci_close($conn);

?>

