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

    <div class="title_db">
      <p> Library Database </p>
    </div>

    <p> Reset Table </p>
    <form method="POST" action="libdatabase.php">
    <p><input type="submit" value="Reset" name="reset"></p>
    </form>

    <p> Library Events </p>
    <p><font size="2"> Event ID&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      Event Name&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Start Time&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      EndTime</font></p>
    <form method="POST" action="libdatabase.php">
    <!--refresh page when submit-->

       <p><input type="text" name="insNo" size="8">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="text" name="insName" size="8">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="text" name="insStartTime" size="8">&nbsp;&nbsp;&nbsp;&nbsp;
          <input type="text" name="insEndTime" size="8">
    <!--define two variables to pass the value-->
          <input type="submit" value="insert" name="insertsubmit"></p>
    </form>

  </body>
  </html>
