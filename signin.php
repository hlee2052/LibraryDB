<!DOCTYPE html>
<html>

<head>
  <title> Library Database </title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>


<body align="center">

  <h1> Welcome to the Library database (Team 12)</h1>
  <br><br>

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

    echo
    '</select>
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
    printResult("staff", executePlainSQL($stafflist));
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
      printResult("member", executePlainSQL($memberlist));
    }
    //Commit to save changes...
    OCILogoff($db_conn);
  } else {
    echo "cannot connect";
    $e = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($e['message']);
  }
  ?>
  <div class="new">
    <br><br>
    <h2> Sign up </h2>
    <form action="signin.php" method="post">
      Name<br> <input type="text" name="name" placeholder="name"></input>
      <br>Phone<br> <input type="text" name="phone" placeholder="phone"></input>
      <br>Email<br> <input type="text" name="email" placeholder="email"></input>
      <br>Address<br> <input type="text" name="address" placeholder="address"></input>
      <br><input type="submit" value="Sign up" name="new"></input>
    </form>
  </div>
</body>
</html>
