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
      <h1> Event </h1>

      <div class="new">
        <h2> Create new event </h2>
        <form="new_event">
          <input type="text" name="eventName" placeholder="event name"></input>
          <input type="text" name="start_time" placeholder="start_time"></input>
          <input type="text" name="end_time" placeholder="end_time"></input>
          <input type="text" name="room" placeholder="add list of rooms"></input>
          <input type="text" name="media" placeholder="add list of media"></input>
          <input type="submit" value="Submit"></input>
        </form>
      </div>

      <table>
        <h2>List of events:</h2>
        <tr>
          <th>event name</th>
          <th>start_time</th>
          <th>end_time</th>
          <th>room</th>
          <th>location</th>
          <th>media</th>
        <tr>
          <td>ugh pls assume data is here</td>
        </tr>
      </table>

      <table>
        <h2>Stats:</h2>
        <tr>
          <th>location</th>
          <th># of events</th>
          <th>year</th>
      </table>

    </div>
  </body>
</html>
