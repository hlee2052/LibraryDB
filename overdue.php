<!DOCTYPE html>
<html>

  <head>
    <title> Library Database </title>
    <link rel="stylesheet" type="text/css" href="style.php"/>
  </head>


  <body>
    <div class="menu">
      <!--can't get this to work for some reason... < ?php require 'menu.php';?>-->
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
    <div>
      <h1> Overdue media </h1>

      <table>
        <h2>Books:</h2>
        <tr>
          <th>mediaid</th>
          <th>booktitle</th>
          <th>reserved</th>
          <th>borrow date</th>
          <th>days overdue</th>
          <th>borrowed by</th>
        </tr>
        <tr>
          <td>ugh pls assume data is here</td>
        </tr>
      </table>

      <table>
        <h2>DVD:</h2>
        <tr>
          <th>mediaid</th>
          <th>dvdtitle</th>
          <th>reserved</th>
          <th>borrow date</th>
          <th>days overdue</th>
          <th>borrowed by</th>
        </tr>
      </table>

      <table>
        <h2>equipment:</h2>
        <tr>
          <th>mediaid</th>
          <th>equipmentname</th>
          <th>reserved</th>
          <th>borrow date</th>
          <th>days overdue</th>
          <th>borrowed by</th>
        </tr>
      </table>

    </div>
  </body>
</html>
