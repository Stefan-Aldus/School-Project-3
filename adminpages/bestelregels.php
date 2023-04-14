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
  <title>Bestelregels inzien</title>
</head>

<body>
  <?php
  include '../includes/nav.html';
  ?>

  <main class="bg">
    <div class="about-mk">
      <div class="about-mk-title">
        <h1>Admin bestelregels inzien</h1>
        <p> Op deze pagina kunt u de bestelregels inzien</p>

      </div>
      <img class="about-br-pic" src="./img/orderrules.png" alt="picture of a cart">
    </div>


    <section class="order-list2 small-margin">
      <form action="" method="post">
        <input type="text" placeholder="Filteren Op Product" name="filterbs" id="filterbs">
      </form>
      <?php
      # verbinding maken met databse
      require "../includes/connDatabase.php";


      #quary defineren
      if (!isset($_POST["filterbs"])) {
        try {
          # orderrules quarry
          $fullQuery = $db->prepare("SELECT orderrules.*, products.name AS productname
      FROM orderrules
      INNER JOIN products ON products.productid = orderrules.productid
      WHERE products.productid = orderrules.productid
      ORDER BY orderid;");
          # order quarry
          $fullQuery2 = $db->prepare("SELECT * FROM orders");
          $fullQuery->execute();
          $fullQuery2->execute();
          // if Querry doesnt work activate the catch with the error msg
        } catch (PDOexception $e) {
          die("Fout bij verbinden met database: " . $e->getMessage());
        }
      } else {
        try {
          # orderrules quarry
          $fullQuery = $db->prepare("SELECT orderrules.*, products.name AS productname
                                    FROM orderrules
                                    INNER JOIN products ON products.productid = orderrules.productid
                                    WHERE products.name LIKE :productname
                                    ORDER BY orderid;");
          # order quarry
          $fullQuery2 = $db->prepare("SELECT orders.*, products.name AS productname
          FROM orders
          INNER JOIN orderrules ON orders.orderid = orderrules.orderid
          INNER JOIN products ON products.productid = orderrules.productid
          WHERE products.name LIKE :productname
          ORDER BY orders.orderid;");

          $fullQuery->execute([":productname" => $_POST["filterbs"]]);
          $fullQuery2->execute([":productname" => $_POST["filterbs"]]);
          // if Querry doesnt work activate the catch with the error msg
        } catch (PDOexception $e) {
          die("Fout bij verbinden met database: " . $e->getMessage());
        }
      }

      // fetches all the result
      $result = $fullQuery->fetchall(PDO::FETCH_ASSOC);
      $result2 = $fullQuery2->fetchall(PDO::FETCH_ASSOC);

      // checks if row count is higher then 0
      if ($fullQuery->rowCount() > 0) {
        // if its higher then 0 then is echo's the table
        foreach ($result2 as $order) {
          echo "<table>";

          echo "<thead><th> OrderID: " . $order["orderid"] . "</th>";
          echo "<th> CustomerID: " . $order["customerid"] . "</th>";
          echo "<th> Bestel datum: " . $order["date"] . "</th>";
          echo "<th> Order prijs $: " . $order["price"] . "</th>";
          echo "</thead>";
          echo "<th> Naam product:  </th>";
          echo "<th>ProductID</th>";
          echo "<th> Hoeveelheid: </th>";
          echo "<th> Prijs product: : </th>";
          echo "</thead>";
          echo "<tbody>";
          echo "<tr>";
         
          // this does the same as the one above except it does it so it can retrieve data about the products
          foreach ($result as $orderrule)
          // this makes sure the right products get put in the right supplier table
            if ($order["orderid"] == $orderrule["orderid"]) {
              echo "<td>" . $orderrule["productname"] . "</td>";
              echo "<td> " . $orderrule["productid"] . "</td>";
              echo "<td> " . $orderrule["quantity"] . "</td>";
              echo "<td> €" . $orderrule["price"] . "</td>";
              echo "</tr>";
            }

          echo "</tbody>";
          echo "</table>";


        }
        // if no results are found it echo's 'geen resultaten gevonden'
      } else {
        echo "Geen resultaten gevonden";
      }

      ?>
    </section>


  </main>
  <?php include '../includes/footer.html'; ?>

</body>

</html>