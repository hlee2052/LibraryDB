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
      <div class="staff">
        <h2> Sign in as staff </h2>
        <form="staff">
          <select>
            <option>staff</option>
            <option>name</option>
            <option>queried</option>
            <option>from</option>
            <option>database</option>
          </select>
          <input type="submit" value="Sign in as staff"></input>
          submit should redirect the page to <a href="staff.php"> staff page </a>
        </form>
      </div>



      <div class="member">
        <h2> Sign in as member </h2>
        <form="member">
          <select>
            <option>member</option>
            <option>name</option>
            <option>queried</option>
            <option>from</option>
            <option>database</option>
          </select>
          <input type="submit" value="Sign in as member"></input>
          submit should redirect the page to <a href="member.php"> member page </a>
        </form>
      </div>



      <div class="new">
        <h2> Sign up </h2>
        <form="member">
          <input type="text" name="name" placeholder="First name, Last name"></input>
          <input type="text" name="phone" placeholder="phone"></input>
          <input type="text" name="email" placeholder="email"></input>
          <input type="text" name="address" placeholder="address"></input>
          <input type="submit" value="Sign up"></input>
        </form>
      </div>
    </div>

  </body>
</html>
