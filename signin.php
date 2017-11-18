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

    <?php
    include "phpfunctions.php";
    function printResult($type, $result) {
      echo
      '<div class="' . $type . '">
        <h2> Sign in as ' . $type . ' </h2>
        <form action="' . $type . '.php" method="post">
          <select>';

      while ($row = OCI_Fetch_Array($result, OCI_BOTH)) {
        echo "<option>" . $row["MID"] . $row["NAME"] . "</option>";
      }

      echo '</select>
          <input type="submit" value="Sign in as ' . $type . '" name="' . $type . '"></input>
        </form>
      </div>';
    }

    // Connect Oracle...
    if ($db_conn) {
      //Staff
      $stafflist = "SELECT M.name as NAME, M.mid as ID
        FROM Staff S, Member M
        WHERE S.mid = M.mid";
      printResult("Staff", executePlainSQL($stafflist));
      $getNextID = "SELECT MAX(mid) as mid FROM Member";
      $max = executePlainSQL($getNextID);
      while ($temp = OCI_Fetch_Array($max, OCI_BOTH)) {
        $newID = $temp["MID"] + 1;
      }
    	if (array_key_exists('new', $_POST)) {
  				// Update tuple using data from user
  				$tuple = array (
  					":bind1" => $_POST['email'],
  					":bind2" => $_POST['phone'],
            ":bind3" => $_POST['name'],
            ":bind4" => $_POST['address']
  				);
  				$alltuples = array (
  					$tuple
  				);
          $insertSQL = "INSERT INTO Member VALUES($newID, 0, :bind1, :bind2, :bind3, :bind4)";
  				executeBoundSQL($insertSQL, $alltuples);
  				OCICommit($db_conn);
  		} if ($_POST && $success) {
      		header("location: signin.php");
      	} else {
          //Member
          $memberlist = "SELECT name as NAME, mid as ID FROM Member M";
          printResult("Member", executePlainSQL($memberlist));
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
  </body>
</html>
