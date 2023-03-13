<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <title>Document</title>
  <base href="../">
</head>

<body>
  <header class="main-head">
    <!-- nav bar -->
    <?php include '../includes/nav.html';
    require '../includes/connDatabase.php';
    ?>
  </header>

  <main class="bg">
    <section class="about-p-a">
      <div class="about-title-h">
        <h1>Welkom bij de product pagina</h1>
        <p>Op de product pagina vind u alle soorten en maten van producten die wij verkopen, heeft u een klacht over een
          product of een vraag ga naar de formulieren pagina </p>
      </div>
      <img class="about-pic" src="./img/kaasmerk-kazen.png" alt="">
    </section>

    <div class="flex-a">
<section class="filter-a">
<form method="post" action="">
     <label for="1">Jong</label>      
     <input type="radio"  name="1" value="1" />
    
</form>
</section>


    <section class="products-a small-margin">
      <?php



if (isset($_POST["submit"])) {

}

      // else {
        try {
        
          $fullQuery = $db->prepare("SELECT products.*, category.name AS Category, suppliers.name AS Supplier FROM products INNER JOIN category ON category.categoryid = products.categoryid INNER JOIN suppliers ON products.supplierid = suppliers.supplierid ");
        } catch (PDOexception $e) {
          die("Fout bij verbinden met database: " . $e->getMessage());
        }
      // }

      #3 query uitvoeren
      $fullQuery->execute();

      #4 checken of er een resultaat is
      // echo "aantal regels is: " . $fullQuery->rowCount();
      $result = $fullQuery->fetchall(PDO::FETCH_ASSOC);

      #5 resultaat op scherm tonen
      ?>
      <?php

      if ($fullQuery->rowCount() > 0) {

        foreach ($result as $product) {
          # filmnaam, regisseur, releasejaar etc moeten gelijk zijn aan de namen die gebruikt zijn in de query
          echo "<div>" . "
                    <h3>Naam: " . $product["name"] . "</h3>
                    <ul>
                      <li>Leeftijd: " . $product["age"] . " maanden oud</li>
                      <li>Type: " . $product["type"] . "</li>
                      <li>Flavor: " . $product["flavor"] . "</li>
                      <li>Texture: " . $product["texture"] . "</li>
                      <li>Prijs: $" . $product["price"] . " per kilogram</li>
                      <li>Supplier: " . $product["Supplier"] . "</li>
                      <li>Category: " . $product["Category"] . "</li>
                    </ul>
                  </div>";

        }

      } else {
        echo "Geen resultaten gevonden";
      }

      ?>
    </section>
  </div>
  </main>

</body>

</html>