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


      <table>
        <caption>Product Leveranciers</caption>
        <tr>
          <th>ProductID</th>
          <th>Product Name</th>
          <th>Product Age</th>
          <th>Product Type</th>
          <th>Product Flavor</th>
          <th>Product Price</th>
          <th>Product Texture</th>
          <th>Leverancier</th>
          <th>Categorie</th>
        </tr>

        <?php

        require "../includes/connDatabase.php";
        #2 een query definieren
        

        // Tries the queries reuired for the retrieval of the suppliers and products
        try {
          // Retrieves products and suppliers
          $fullQuery = $db->prepare(
            "SELECT products.*, suppliers.name AS suppname, category.name AS catname FROM products 
              INNER JOIN suppliers ON products.supplierid = suppliers.supplierid 
              INNER JOIN category ON category.categoryid = products.categoryid
              WHERE suppliers.name LIKE :name"
          );

          // Catches any exceptions and stops the program
        } catch (PDOexception $e) {
          die("Fout bij verbinden met database: " . $e->getMessage());
        }
        //  Executing the query
        if (!isset($_POST["search"])) {
          $fullQuery->execute([":name" => "%" . "%"]);
        } else {
          $fullQuery->execute([":name" => "%" . $_POST["search"] . "%"]);
        }
        $results = $fullQuery->fetchall(PDO::FETCH_ASSOC);

        foreach ($results as $result) {
          echo '<tr>';
          echo '<td>' . $result["productid"] . '</td>';
          echo '<td>' . $result["age"] . '</td>';
          echo '<td>' . $result["type"] . '</td>';
          echo '<td>' . $result["flavor"] . '</td>';
          echo '<td>' . $result["price"] . '</td>';
          echo '<td>' . $result["texture"] . '</td>';
          echo '<td>' . $result["suppname"] . '</td>';
          echo "<td>" . $result["catname"] . "</td>";
          echo '</tr>';
        }
        ?>
      </table>
    </section>
  </main>
  <?php include '../includes/footer.html'; ?>
</body>

</html>