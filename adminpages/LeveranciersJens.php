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
        <input type=" text" id="search" name="search" placeholder="Zoek op land van leverancier" />
      </form>



      <?php

      require "../includes/connDatabase.php";
      #2 een query definieren
      


      try {
        // $fullQuery = $db->prepare("SELECT filmnaam, regisseur FROM film WHERE filmnaam LIKE 'b%'");
        $fullQuery = $db->prepare("SELECT suppliers.*, country.name AS countryname FROM `suppliers` INNER JOIN country ON country.countryid = suppliers.countryid WHERE country.countryid = suppliers.countryid; ");
        $fullQuery2 = $db->prepare("SELECT * FROM products");
        $fullQuery3 = $db->prepare("SELECT suppliers.*, country.name AS countryname FROM `suppliers` INNER JOIN country ON country.countryid = suppliers.countryid WHERE country.countryid = suppliers.countryid AND country.name LIKE :name; ");

      } catch (PDOexception $e) {
        die("Fout bij verbinden met database: " . $e->getMessage());
      }

      #3 query uitvoeren
// suppliers 
      $fullQuery->execute();

      //  products
      $fullQuery2->execute();

      #4 checken of er een resultaat is

      
      // suppliers
      $result = $fullQuery->fetchall(PDO::FETCH_ASSOC);

      // products
      $result2 = $fullQuery2->fetchall(PDO::FETCH_ASSOC);

      if (isset($_POST["search"])) {
        $value = $_POST["search"];
        $fullQuery3->execute([":name" => "%" . $value . "%"]);
        $result3 = $fullQuery3->fetchall();
        if ($fullQuery->rowCount() > 0) {

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


      } elseif ($fullQuery->rowCount() > 0) {

        foreach ($result as $row) {
          # filmnaam, regisseur, releasejaar etc moeten gelijk zijn aan de namen die gebruikt zijn in de query
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