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
    <div class="title_db" align="center">
      <h1> Sign In </h1>

      <div class="new">
        <h2> Sign up </h2>
        <form action="signin.php" method="post">
          <input type="text" name="name" placeholder="First name, Last name"></input>
          <input type="text" name="phone" placeholder="phone"></input>
          <input type="text" name="email" placeholder="email"></input>
          <input type="text" name="address" placeholder="address"></input>
          <input type="submit" value="Sign up" name="new"></input>
        </form>
      </div>

    <?php
    include "phpfunctions.php";
    function printResult($type, $result) { //prints results from a select statement
      echo
      '<div class="' . $type . '">
        <h2> Sign in as ' . $type . ' </h2>
        <form action="' . $type . '.php" method="post">
          <select>';

      while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<option>" . $row["NID"] . "</option>";
      }

      echo '</select>
          <input type="submit" value="Sign in as ' . $type . '" name="' . $type . '"></input>
        </form>
      </div>';
    }

    // Connect Oracle...
    if ($db_conn) {
      //Staff
      $stafflist = executePlainSQL("select * from tab1");
      printResult("staff", $stafflist);
      //Member
      $memberlist = executePlainSQL("select * from tab1");
      printResult("member", $memberlist);
    	if (array_key_exists('member', $_POST)) {
    			//Getting the values from user and insert data into the table
    			$tuple = array (
    				":bind1" => $_POST['insNo'],
    				":bind2" => $_POST['insName']
    			);
    			$alltuples = array (
    				$tuple
    			);
    			executeBoundSQL("insert into tab1 values (:bind1, :bind2)", $alltuples);
    			OCICommit($db_conn);

    		} else
    			if (array_key_exists('new', $_POST)) {
    				// Update tuple using data from user
    				$tuple = array (
    					":bind1" => $_POST['oldName'],
    					":bind2" => $_POST['newName']
    				);
    				$alltuples = array (
    					$tuple
    				);
    				executeBoundSQL("update tab1 set name=:bind2 where name=:bind1", $alltuples);
    				OCICommit($db_conn);

    		}
//check if i really need this. does it reload without this?
    	if ($_POST && $success) {
    		//POST-REDIRECT-GET -- See http://en.wikipedia.org/wiki/Post/Redirect/Get
    		header("location: oracle-test.php");
    	} else {
    		// Select data...
    		$result = executePlainSQL("select * from tab1");
    		printResult($result);
    	}

    	//Commit to save changes...
    	OCILogoff($db_conn);
    } else {
    	echo "cannot connect";
    	$e = OCI_Error(); // For OCILogon errors pass no handle
    	echo htmlentities($e['message']);
    }
    ?>
    </div>
  </body>
</html>
