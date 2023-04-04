<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="../">
<link rel="stylesheet" href="style.css">
    <title>Producten Per Catergorie</title>
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
        <h1>Welkom bij de productenaantallen pagina</h1>
        <p>Op deze pagina kunt u zien hoeveel producten per categorie wij verkopen.</p>
      </div>
      <img class="about-pic" src="./img/kaasmerk-kazen.png" alt="">
    </section>
    <section class="order-list2 small-margin">
    <?php
    require '../includes/connDatabase.php';

    try{
      $fullQuery = $db->prepare("SELECT category.name AS 'Categorie' , COUNT(*) AS 'Aantal' FROM products INNER JOIN category ON category.categoryid = products.categoryid GROUP BY category.name;");
    }

    catch (PDOexception $e) {
      die("Fout bij verbinden met database: " . $e->getMessage());
    }

    $fullQuery->execute();
    $result = $fullQuery->fetchall(PDO::FETCH_ASSOC);
    ?>

    <table>
      <thead>
        <th>Categorie</th>
        <th>Aantal producten
        </th>
      </thead>
      <tbody>
        <?php
         if ($fullQuery->rowCount() > 0) {
          foreach ($result as $row) {
            echo "<tr><td>" . $row["Categorie"] . "</td>";
            echo "<td>" . $row["Aantal"] . "</td></tr>";
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