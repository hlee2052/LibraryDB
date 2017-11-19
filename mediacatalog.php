<!DOCTYPE html>
<html>

<head>
  <title> Library Database </title>
  <link rel="stylesheet" type="text/css" href="style.css"/>
</head>


<body>
  <ul>
    <li><a href="member.php">Home</a></li>
    <li><a href="media_member.php">Search Media</a></li>
    <li><a class="active" href="mediacatalog.php">Media Catalog</a></li>
    <li style="float:right"><a href="signin.php">Sign out</a></li>
  </ul>

  <!--a div class set up for the database heading-->
  <h1> Media Catalog </h1>

  <?php
  include "phpfunctions.php";

  function printResult($result){
    echo "<br><h2>Books:</h2><br>";
    echo "<table>";
    echo "<tr>
    <th>Media Id</th>
    <th>Name</th>
    <th>Availability</th>
    <th>Location</th>
    </tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
      echo "<tr><td>" . $row["MEDIAID"] . "</td>
      <td>" . $row["BOOKTITLE"] . "</td>
      <td>" . $row["AVAILABILITY"] . "</td>
      <td>" . $row["LOCNAME"] . "</td>
      </tr>";
    }
    echo "</table>";
  }

  function printResult2($result){
    echo "<br><h2>DVDs:</h2><br>";
    echo "<table>";
    echo "<tr>
    <th>Media Id</th>
    <th>DVD Title</th>
    <th>Availability</th>
    <th>Location</th>
    </tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
      echo "<tr><td>" . $row["MEDIAID"] . "</td>
      <td>" . $row["DVDTITLE"] . "</td>
      <td>" . $row["AVAILABILITY"] . "</td>
      <td>" . $row["LOCNAME"] . "</td>
      </tr>";
    }
    echo "</table>";
  }

  function printResult3($result){
    echo "<br><h2>Equipment:</h2><br>
    <table><tr>
    <th>Media Id</th>
    <th>Equipment Name</th>
    <th>Availability</th>
    <th>Location</th>
    </tr>";

    while ($row = OCI_Fetch_Array($result, OCI_BOTH)){
      echo "<tr><td>" . $row["MEDIAID"] . "</td>
      <td>" . $row["EQUIPNAME"] . "</td>
      <td>" . $row["AVAILABILITY"] . "</td>
      <td>" . $row["LOCNAME"] . "</td>
      </tr>";
    }
    echo "</table>";
  }

  if ($db_conn){
    if ($_POST && $success) {
      header ("location: mediacatalog.php");
    } else {
      $result = executePlainSQL("select * from BookCatalog");
      printResult($result);

      $result = executePlainSQL("select * from DVDCatalog");
      printResult2($result);

      $result = executePlainSQL("select * from EquipmentCatalog");
      printResult3($result);
    }
    OCILogoff($db_conn);
  } else {
    echo "cannot connect";
    $error = OCI_Error(); // For OCILogon errors pass no handle
    echo htmlentities($error['message']);
  }
  ?>
</body>
</html>
