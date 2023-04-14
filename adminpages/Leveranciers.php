<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <base href="../">
  <title>Leveranciers</title>
</head>

<body>
  <header class=>
    <!-- nav bar -->
    <?php include '../includes/nav.html' ?>
  </header>

  <main class="bg">
    <div class="about-mk">
      <div class="about-mk-title">
        <h1>Admin Levenraciers inzien</h1>
        <p> Op deze pagina kunt u de leveranciers inzien met hun geleverede producten</p>

      </div>
      <img class="about-mk-pic" src="./img/leverancier.png" alt="">
    </div>

    <section class="order-list2 small-margin">


      <form method="post" action="">
        <input type=" text" id="search" name="search" placeholder="Zoek op leverancier" />
      </form>



      <?php

      require "../includes/connDatabase.php";




      try {
        // Defines 3 queries
        $fullQuery = $db->prepare("SELECT suppliers.*, country.name AS countryname FROM `suppliers` INNER JOIN country ON country.countryid = suppliers.countryid WHERE country.countryid = suppliers.countryid; ");
        $fullQuery2 = $db->prepare("SELECT * FROM products");
        $fullQuery3 = $db->prepare("SELECT suppliers.*, country.name AS countryname FROM `suppliers` INNER JOIN country ON country.countryid = suppliers.countryid WHERE country.countryid = suppliers.countryid AND suppliers.name LIKE :name; ");

      } catch (PDOexception $e) {
        die("Fout bij verbinden met database: " . $e->getMessage());
      }

      // Executes the queries
      $fullQuery->execute();
      $fullQuery2->execute();

      // Stores the results from query 1 and 2
      $result = $fullQuery->fetchall(PDO::FETCH_ASSOC);
      $result2 = $fullQuery2->fetchall(PDO::FETCH_ASSOC);

      // Checks if the page got filtered and applies the filter
      if (isset($_POST["search"])) {
        $value = $_POST["search"];
        // Executes a query with a like clause that retrieves the suppliers
        $fullQuery3->execute([":name" => "%" . $value . "%"]);
        $result3 = $fullQuery3->fetchall();

        // If there are results do the code in the if block
        if ($fullQuery->rowCount() > 0) {

          // Echoes the supplier data as a table
          foreach ($result3 as $row) {

            echo "<table>";

            echo "<thead><th> Naam leverancier: " . $row["name"] . "</th>";
            echo "<th> Naam land: " . $row["countryname"] . "</th>";
            echo "<th> adress: " . $row["adress"] . "</th>";
            echo "</thead>";
            echo "<th> Naam product:  </th>";
            echo "<th>Type / smaak </th>";
            echo "<th> Prijs: product </th>";
            echo "</thead>";
            echo "<tbody>";
            echo "<tr>";

            // Echoes the product data as a table
            foreach ($result2 as $row2)
              if ($row["supplierid"] == $row2["supplierid"]) {
                echo "<td>" . $row2["name"] . "</td>";
                echo "<td> " . $row2["flavor"] . "</td>";
                echo "<td> €" . $row2["price"] . "</td>";
                echo "</tr>";
              }

            echo "</tbody>";
            echo "</table>";


          }

        } else {
          // If no results were found notify the user
          echo "Geen resultaten gevonden";
        }

        // Else checks if there are results for the query without the filter, and does the same as the above code
      } elseif ($fullQuery->rowCount() > 0) {

        foreach ($result as $row) {
          echo "<table>";

          echo "<thead><th> Naam leverancier: " . $row["name"] . "</th>";
          echo "<th> Naam land: " . $row["countryname"] . "</th>";
          echo "<th> adress: " . $row["adress"] . "</th>";
          echo "</thead>";
          echo "<th> Naam product:  </th>";
          echo "<th>Type / smaak </th>";
          echo "<th> Prijs: product </th>";
          echo "</thead>";
          echo "<tbody>";
          echo "<tr>";

          foreach ($result2 as $row2)
            if ($row["supplierid"] == $row2["supplierid"]) {
              echo "<td>" . $row2["name"] . "</td>";
              echo "<td> " . $row2["flavor"] . "</td>";
              echo "<td> €" . $row2["price"] . "</td>";
              echo "</tr>";
            }

          echo "</tbody>";
          echo "</table>";


        }

      } else {
        echo "Geen resultaten gevonden";
      }

      ?>
    </section>
  </main>
  <?php include '../includes/footer.html'; ?>
</body>

</html>