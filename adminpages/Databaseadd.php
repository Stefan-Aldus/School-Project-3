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
    <?php
    include '../includes/nav.html';
    require "../includes/connDatabase.php";

    // gets the msg that has been set in one of the filters.php
    // and echo's it with JavaScript
    if (isset($_GET['message'])) {
      echo "<script> alert('" . $_GET['message'] . "')</script>";
    }
    ?>
  </header>


  <main class="bg">
    <div class="about-mk">
      <div class="about-mk-title">
        <h1>Admin data toevoegen</h1>
        <p> Op deze pagina kunt u data toevoegen tot de database, pas op met wat je toevoegt!
        </p>

      </div>
      <img class="about-mk-pic" src="./img/mederwerker.png" alt="">
    </div>

    <section class="admin-add-content">
      <form method="post" action="filters/filterlandinput.php">
        <div class="admin-add">
          <h3>Voeg land toe</h3>
          <label for="land">naam land:</label>
          <input type="text" id="land" name="land" required />
          <label for="continent">naam continent:</label>
          <input type="text" id="continent" name="continent" required />
          <label for="currency">Munteenheid afkorting ( 3 char):</label>
          <input type="text" id="currency" name="currency" required />
          <input class="submit-admin" type="submit" name="submit-l" id="submit-l" value="submit">
        </div>
      </form>


      <form method="post" action="filters/filtercategoryinput.php">
        <div class="admin-add">
          <h3>Voeg category toe</h3>
          <label for="category">naam category:</label>
          <input type="text" id="category" name="category" required />
          <input class="submit-admin" type="submit" name="submit-c" id="submit-c" value="submit">
        </div>
      </form>

      <form method="post" action="filters/filterproductinput.php">
        <div class="admin-add">
          <h3>Voeg product toe</h3>
          <label for="product">Naam product:</label>
          <input type="text" id="product" name="product-naam" required />
          <label for="product">Leeftijd product: (optioneel)</label>
          <input type="number" id="product" name="product-age" />
          <label for="product">Soort product:</label>
          <input type="text" id="product" name="product-type" required />
          <label for="product">Smaak product:</label>
          <input type="text" id="product" name="product-flav" required />
          <label for="product">Prijs product:</label>
          <input type="number" id="product" name="product-price" required />
          <label for="product">Textuur product:</label>
          <input type="text" id="product" name="product-texture" required />
          <label for="product">Cat product:</label>
          <select name="productcat" id="productcat" name="product-cat">
            <?php
            // defines a Query for catorgory's
            $retreiveCategories = $db->prepare("SELECT `name` FROM category");
            $retreiveCategories->execute();
            $categoryNames = $retreiveCategories->fetchAll();
            // for each catorgory it will echo it in the select
            foreach ($categoryNames as $categoryName) {
              echo '<option class="<3 Berkhout" value="' . $categoryName['name'] . '">' . $categoryName['name'] . '</option>';

            }
            ?>
          </select>
          <label for="product">SupplierID:</label>
          <!-- defines a Query to count the amount of supllies -->
          <input min="2" max="<?php $suppcount = $db->prepare("SELECT count(supplierid) FROM suppliers");
          $suppcount->execute();
          $totalsupp = $suppcount->fetch();
          echo $totalsupp[0];
          ?>" type="number" id="product" name="suppid" required />
          <input class="submit-admin" type="submit" name="submit-p" id="submit-p" value="submit">


          
        </div>
      </form>


      <form method="post" action="filters/filtersupplierinput.php">
        <div class="admin-add">
          <h3>Voeg Leverancier toe</h3>
          <label for="suppliername">Naam leverancier:</label>
          <input type="text" id="suppliername" name="suppliername" required />
          <label for="adress">Adres leverancier:</label>
          <input type="text" id="adress" name="adress" required />
          <label for="country">Land:</label>
          <select name="country-lz" id="country" -lz name="country-lz">
            <?php
            // defines a Query for all country's
            $findCountries = $db->prepare("SELECT * FROM country");
            $findCountries->execute();
            // for each country result it will echo the country name into the select
            foreach ($findCountries as $country) {
              echo '<option class="<3 Berkhout" value="' . $country['name'] . '">' . $country['name'] . '</option>';
            }
            ?>
          </select>
          <input class="submit-admin" type="submit" name="submit-lz" value="submit">
        </div>
      </form>
      <form method="post" action="filters/filterklantinput.php">
        <div class="admin-add">
          <h3>Voeg Klant toe</h3>
          <label for="customername">Voornaam Klant:</label>
          <input type="text" id="customername" name="customername" required />
          <label for="customerlastname">Achternaam Klant:</label>
          <input type="text" id="customerlastname" name="customerlastname" required />
          <label for="customeremail">Email klant:</label>
          <input type="text" id="customeremail" name="customeremail" required />
          <label for="customercountry">Land v.d. klant:</label>
          <input type="text" id="customercountry" name="customercountry" required />
          <label for="customerprovince">Provincie v.d. klant:</label>
          <input type="text" id="customerprovince" name="customerprovince" required />
          <label for="customercity">Stad v.d. klant:</label>
          <input type="text" id="customercity" name="customercity" required />
          <label for="customeradress">Adress v.d. klant:</label>
          <input type="text" id="customeradress" name="customeradress" required />
          <label for="customerzip">Postcode v.d. klant:</label>
          <input type="text" id="customerzip" name="customerzip" required />
          <label for="customerphone">Telefoon Nr. v.d. klant:</label>
          <input type="text" id="customerphone" name="customerphone" required />
          <label for="customerdob">Geboortedatum v.d. klant:</label>
          <input type="date" id="customerdob" name="customerdob" required />
          <input class="submit- admin" type="submit" name="submit-cu" value="submit">
           
          
        </div>
      </form>


    </section>

  </main>
  <?php

  include "../includes/footer.html";
  ?>

</body>

</html>