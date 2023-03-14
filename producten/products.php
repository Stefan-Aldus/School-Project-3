<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../style.css">
  <!-- Linking font for navbar logo -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <title>Producten - Brouwerskazen</title>
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
          <div class="filter-type">
            <label class="multiple-footnote" for="type">Type Kaas:</label>
            <div>

              <select multiple name="type[]" id="selector">
                <option value="Young">Jonge Kaas</option>
                <option value="Old">Oude Kaas</option>
                <option value="Sharp">Scherpe Kaas</option>
                <option value="Accesoires">Assecoires</option>
              </select>
            </div>
          </div>
          <input type="submit" value="submit">
        </form>
      </section>


      <section class="products-a small-margin">
        <?php

        // Check if the "type" variable is set in the $_POST array
        if (isset($_POST["type"])) {
          // Create an empty array to store the individual type conditions and a params array to store the parameter values
          $typeConditions = [];
          $params = [];
          // Loop through the "type" array values
          foreach ($_POST["type"] as $value) {
            // Create a new condition for each value and add it to the $typeConditions array
            $typeConditions[] = 'name = :type' . count($params);
            // Add the parameter value to the $params array with a unique key
            $params[':type' . count($params)] = $value;
          }
          // Concatenate all the type conditions using the "OR" operator and add it to the $whereClause variable
          $whereClause = 'WHERE ' . implode(' OR ', $typeConditions);
          try {
            // Prepare the SQL query to retrieve the category IDs based on the selected types and execute it with the parameter values
            $categoryIdQuery = $db->prepare("SELECT categoryid FROM category $whereClause");
            $categoryIdQuery->execute($params);
            $categoryids = $categoryIdQuery->fetchAll(PDO::FETCH_COLUMN);
            // Create a comma-separated string of the category IDs to use in the main query
            $categoryidString = implode(',', $categoryids);
          } catch (PDOException $e) {
            // Handle any errors that may occur during the database connection or query execution
            die("Fout bij verbinden met database: " . $e->getMessage());
          }
          try {
            // Prepare the full SQL query with the category IDs and execute it with the parameter value
            $fullQuery = $db->prepare("
              SELECT products.*, category.name AS Category, suppliers.name AS Supplier, category.categoryid
              FROM products
              INNER JOIN category ON category.categoryid = products.categoryid
              INNER JOIN suppliers ON products.supplierid = suppliers.supplierid
              WHERE category.categoryid IN ($categoryidString)
            ");
            $fullQuery->execute();
          } catch (PDOException $e) {
            // Handle any errors that may occur during the database connection or query execution
            die("Fout bij verbinden met database: " . $e->getMessage());
          }
        } else {
          try {
            $fullQuery = $db->prepare(
              "SELECT products.*, category.name AS Category, suppliers.name AS Supplier FROM products 
             INNER JOIN category ON category.categoryid = products.categoryid 
             INNER JOIN suppliers ON products.supplierid = suppliers.supplierid"
            );
            $fullQuery->execute();
          } catch (PDOexception $e) {
            die("Fout bij verbinden met database: " . $e->getMessage());
          }
        }


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

  <script defer src="app2.js"></script>
</body>

</html>