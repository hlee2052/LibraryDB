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
      <h1> media page </h1>

      <form>
        <input type="text" name="search" placeholder="search title"/>
        <input type="submit" value="Search"></input>
      </form>

      <table>
        <h2>Books:</h2>
        <tr>
          <th>mediaid</th>
          <th>booktitle</th>
          <th>reserved</th>
          <th>avaliability</th>
          <th>location</th>
        </tr>
        <tr>
          <td>1234</td>
          <td>a book</td>
          <td>no</td>
          <td>yes</td>
          <td>richmond</td>
          <td> <button>borrow</button> press to update media</td>
        </tr>
        <tr>
          <td>4321</td>
          <td>another book</td>
          <td>no</td>
          <td>no</td>
          <td>vancouver</td>
        </tr>
      </table>

      <table>
        <h2>DVD:</h2>
        <tr>
          <th>mediaid</th>
          <th>dvdtitle</th>
          <th>reserved</th>
          <th>avaliability</th>
          <th>location</th>
        </tr>
        <tr>
          <td>2345</td>
          <td>a movie</td>
          <td>no</td>
          <td>yes</td>
          <td>langley</td>
          <td> <button>borrow</button></td>
        </tr>
        <tr>
          <td>5432</td>
          <td>another movie</td>
          <td>no</td>
          <td>yes</td>
          <td>north van</td>
          <td> <button>borrow</button></td>
        </tr>
      </table>

      <table>
        <h2>equipment:</h2>
        <tr>
          <th>mediaid</th>
          <th>booktitle</th>
          <th>reserved</th>
          <th>avaliability</th>
          <th>location</th>
        </tr>
        <tr>
          <td>3456</td>
          <td>a computer</td>
          <td>yes</td>
          <td>no</td>
          <td>burnaby</td>
        </tr>
        <tr>
          <td>6543</td>
          <td>a printer</td>
          <td>yes</td>
          <td>no</td>
          <td>surrey</td>
        </tr>
      </table>

    </div>
  </body>
</html>
