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
      <h1> Member Home Page </h1>
      <p>display member name, address, phone, email, fines</p>
      <h3> list of media borrowed by user </h3>
      <ul>
        <li> book title <button>return</button> press to update media </li>
        <li> book title 2 <button>return</button> </li>
        <li> dvd title <button>return</button> </li>
        <li> equipment name <button>return</button> </li>
      </ul>
    </div>
  </body>
</html>
