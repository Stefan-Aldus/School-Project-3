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
  <div class="about-mk">
            <div class="about-mk-title">
                <h1>Admin Orders inzien</h1>
                <p> Op deze pagina kunt u de Orders inzien die onze klanten hebben besteld!</p>

            </div>
            <img class="about-mk-pic" src="./img/mederwerker.png" alt="">
        </div>
    <?php
    $statement = $db -> prepare("
    SELECT customers.firstname AS firstname, customers.customerid AS customerid, COUNT(orders.orderid) AS orders
    FROM customers 
    LEFT JOIN orders ON customers.customerid = orders.customerid
    GROUP BY customers.customerid;
    ");
    $statement -> execute();

    $result = $statement -> fetchAll();
    
    ?>
<section class="country-stuff">
    <table >
      <caption>Spreiding Bestellingen</caption>
      <thead>
      <tr>
        <th>Naam Klant</th>
        <th>Klant ID</th>
        <th>Hoeveel Bestellingen</th>
      </tr>
      </thead>
      <tbody>
<?php
foreach ($result as $result2) {
  echo '<tr>';
  echo '<td>' . $result2["firstname"] . '</td>';
  echo '<td>' . $result2["customerid"] . '</td>';
  echo '<td>' . $result2["orders"] . '</td>';
  echo '</tr>';
}
?>
      </tbody>
    </table>
</section>
  </main>
  
</body>

</html>