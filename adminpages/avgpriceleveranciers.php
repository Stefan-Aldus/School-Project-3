<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <base href="../">
  <link rel="stylesheet" href="style.css">
  <title>Document</title>
</head>

<body>
  <header class="main-head">
    <!-- nav bar -->
    <?php include '../includes/nav.html' ?>
  </header>

  <main class="bg">
    <div class="about-mk">
      <div class="about-mk-title">
        <h1>Gemiddelde Prijs Leveranciers</h1>
        <p> Op deze pagina kunt u de gemiddelde productprijs van elke leverancier inzien</p>

      </div>
      <img class="about-mk-pic" src="./img/leverancier.png" alt="">
    </div>
    <section class="order-list2 small-margin">


      <?php
      # uitleg jesse
      # require maakt connectie met database
      require "../includes/connDatabase.php";

      # een query maken en proberen
      try {
        $fullQuery = $db->prepare("SELECT DISTINCT supplierid, AVG(price), FORMAT(AVG(price) ,2) as avgprice FROM products GROUP BY supplierid");
      }
      # de catch als hij niet werkt
      catch (PDOexception $e) {
        die("Fout bij verbinden met database: " . $e->getMessage());
      }


      #stap 3 de quarry uit voeren
      $fullQuery->execute();
      $result = $fullQuery->fetchall(PDO::FETCH_ASSOC);
      ?>

      <table>
        <thead>
          <th>Id leverancier</th>
          <th>Gemiddelde prijs products</th>
        </thead>
        <tbody>

          <?php
          # checken of er resultaat is
          if ($fullQuery->rowCount() > 0) {
            # voor elke regel in phpmyadmind sql database result
            foreach ($result as $row) {
              echo "<tr><td>" . $row["supplierid"] . "</td>";
              echo "<td>" . $row["avgprice"] . "</td></tr>";
            }

          } else {
            echo "Geen resultaten gevonden";
          }
          ?>
        </tbody>
        </table>
    </section>




  </main>
  <?php include '../includes/footer.html'; ?>
</body>

</html>