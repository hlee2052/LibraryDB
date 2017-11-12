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
      <h1> Staff </h1>

      <table>
        <h2>Manager: (this should be automatically generated from group by.)</h2>
        <tr>
          <th>name</th>
          <th>location</th>
          <th>fines</th>
        </tr>
        <tr>
          <td>Carol</td>
          <td>richmond</td>
          <td>$0</td>
          <td><button>fire</button> press to remove from staff</td>
        </tr>
        <tr>
          <td>Jason</td>
          <td>vancouver</td>
          <td>$0</td>
          <td><button>fire</button></td>
        </tr>
      </table>

      <table>
        <h2>librarian: (this should be automatically generated from group by.)</h2>
        <tr>
          <th>name</th>
          <th>location</th>
          <th>fines</th>
        </tr>
        <tr>
          <td>Henry</td>
          <td>burnaby</td>
          <td>$0</td>
          <td><button>fire</button></td>
        </tr>
        <tr>
          <td>Raf</td>
          <td>north van</td>
          <td>$0</td>
          <td><button>fire</button></td>
        </tr>
      </table>

      <table>
        <h2>janitor: (this should be automatically generated from group by.)</h2>
        <tr>
          <th>name</th>
          <th>location</th>
          <th>fines</th>
        </tr>
        <tr>
          <td>a person who loses a lot of books and/or dvds</td>
          <td>port moody</td>
          <td>$10000</td>
          <td><button>fire</button></td>
        </tr>
        <tr>
          <td>a hard working person</td>
          <td>coquitlam</td>
          <td>$0</td>
          <td><button>fire</button></td>
        </tr>
        <tr>
          <td>a hard working person</td>
          <td>whistler</td>
          <td>$0</td>
          <td><button>fire</button></td>
        </tr>
        <tr>
          <td>a hard working person</td>
          <td>okanagan</td>
          <td>$0</td>
          <td><button>fire</button></td>
        </tr>
        <tr>
          <td>a hard working person</td>
          <td>surrey</td>
          <td>$0</td>
          <td><button>fire</button></td>
        </tr>
      </table>


      <table>
        <h2>staff who work in more than one location:</h2>
        <tr>
          <th>name</th>
        </tr>
        <tr>
          <td>a hard working person</td>
          <td><button>fire</button></td>
        </tr>
      </table>


    </div>
  </body>
</html>
