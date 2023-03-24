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
      <form method="post" action="">
        <div class="admin-add">
          <h3>Voeg land toe</h3>
          <label for="land">naam land:</label>
          <input type="text" id="land" name="land" required />
          <label for="continent">naam continent:</label>
          <input type="text" id="continent" name="continent" required />
          <label for="currency">Munteenheid afkorting ( 3 char):</label>
          <input type="text" id="currency" name="currency" required />
          <input class="submit-admin" type="submit" name="submit-l" id="submit-l" value="submit">

          <?php
          if (isset($_POST["submit-l"])) {
            $country = $_POST["land"];
            $continent = $_POST["continent"];
            $currency = $_POST["currency"];

            if (strlen($currency) > 3) {
              exit("<p>U heeft te veel characters voor currency toegevoegd</p>");
            }
            ;


            try {
              $fullQuery = $db->prepare("INSERT INTO country (`name`, `continent`, `currency`) VALUES (:name, :continent, :currency)");
            } catch (PDOException $e) {
              die("Fout bij verbinden met database: " . $e->getMessage());
            }
            $fullQuery->execute([
              ":name" => $country,
              ":continent" => $continent,
              ":currency" => $currency
            ]);

            echo "<p>land: " . $country . " is toegevoegd aan de database</p>";
          }
          ?>
        </div>
      </form>


      <form method="post" action="">
        <div class="admin-add">
          <h3>Voeg category toe</h3>
          <label for="category">naam category:</label>
          <input type="text" id="category" name="category" required />
          <input class="submit-admin" type="submit" name="submit-c" id="submit-c" value="submit">

          <?php
          if (isset($_POST["submit-c"])) {
            $category = $_POST["category"];

            try {
              $fullQuery = $db->prepare("INSERT INTO category (`name`) VALUES (:name)");
            } catch (PDOException $e) {
              die("Fout bij verbinden met database: " . $e->getMessage());
            }
            $fullQuery->execute([
              ":name" => $category
            ]);

            echo "<p>category: " . $category . " is toegevoegd aan de database</p>";
          }
          ?>
        </div>
      </form>

      <form method="post" action="">
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
            $retreiveCategories = $db->prepare("SELECT `name` FROM category");
            $retreiveCategories->execute();
            $categoryNames = $retreiveCategories->fetchAll();

            foreach ($categoryNames as $categoryName) {
              echo '<option class="<3 Berkhout" value="' . $categoryName['name'] . '">' . $categoryName['name'] . '</option>';

            }
            ?>
          </select>
          <label for="product">SupplierID:</label>
          <input min="2" max="<?php $suppcount = $db->prepare("SELECT count(supplierid) FROM suppliers");
          $suppcount->execute();
          $totalsupp = $suppcount->fetch();
          echo $totalsupp[0];
          ?>" type="number" id="product" name="suppid" required />
          <input class="submit-admin" type="submit" name="submit-p" id="submit-p" value="submit">


          <?php
          if (isset($_POST["submit-p"])) {
            $productname = $_POST["product-naam"];
            $producttype = $_POST["product-type"];
            $productflav = $_POST["product-flav"];
            $productprice = $_POST["product-price"];
            $producttex = $_POST["product-texture"];
            $productcat = $_POST["product-cat"];
            $suppid = $_POST["suppid"];
            try {
              $grabcatid = $db->prepare("SELECT categoryid FROM category WHERE `name` = :name");
            } catch (PDOException $e) {
              die("FOUT IN SQL QUERY " . $e->getMessage());
            }

            $grabcatid->execute([":name" => $productcat]);
            $catid = $grabcatid->fetch();


            if ($_POST["product-age"] > 0) {
              $productage = $_POST["product-age"];
              try {
                $addprod = $db->prepare("INSERT INTO products (`name`, age, `type`, flavor, price, texture, categoryid, supplierid) 
                                        VALUES (:name, :age, :type, :flavor, :price, :texture, :categoryid, :supplierid)");
              } catch (PDOException $e) {
                die("FOUT IN SQL QUERY " . $e->getMessage());
              }
              $addprod->execute([
                ":name" => $productname,
                ":age" => $productage,
                ":type" => $producttype,
                ":flavor" => $productflav,
                ":price" => $productprice,
                ":texture" => $producttex,
                ":categoryid" => $catid[0],
                ":supplierid" => $suppid
              ]);
            } else {
              try {
                $addprod = $db->prepare("INSERT INTO products (`name`, age, `type`, flavor, price, texture, categoryid, supplierid) 
                                        VALUES (:name, :age, :type, :flavor, :price, :texture, :categoryid, :supplierid)");
              } catch (PDOException $e) {
                die("FOUT IN SQL QUERY " . $e->getMessage());
              }
              $addprod->execute([
                ":name" => $productname,
                ":age" => null,
                ":type" => $producttype,
                ":flavor" => $productflav,
                ":price" => $productprice,
                ":texture" => $producttex,
                ":categoryid" => $catid[0],
                ":supplierid" => $suppid
              ]);
            }
            ;
          }
          // echo "<p>product: " . $productname . " is toegevoegd aan de database</p>";
          ?>
        </div>
      </form>


      <form method="post" action="">
        <div class="admin-add">
          <h3>Voeg Leverancier toe</h3>
          <label for="suppliername">Naam leverancier:</label>
          <input type="text" id="suppliername" name="suppliername" required />
          <label for="adress">Adres leverancier:</label>
          <input type="text" id="adress" name="adress" required />
          <label for="country">Land:</label>
          <select name="country-lz" id="country" -lz name="country-lz">
            <?php
            $findCountries = $db->prepare("SELECT * FROM country");
            $findCountries->execute();
            foreach ($findCountries as $country) {
              echo '<option class="<3 Berkhout" value="' . $country['name'] . '">' . $country['name'] . '</option>';
            }
            ?>
          </select>
          <input class="submit-admin" type="submit" name="submit-lz" value="submit">
          <?php

          if (isset($_POST["submit-lz"])) {
            $name = $_POST["suppliername"];
            $adress = $_POST["adress"];
            $countryName = $_POST["country-lz"];

            try {
              $fullQuery = $db->prepare("INSERT INTO suppliers (`name`, adress, countryid) VALUES (:name, :adress, :countryid)");
              $findCountryId = $db->prepare("SELECT countryid FROM country WHERE `name` = :countryname");
            } catch (PDOException $e) {
              die("Fout bij verbinden met database: " . $e->getMessage());
            }

            $findCountryId->execute([':countryname' => $countryName]);
            $countryId = $findCountryId->fetch()['countryid'];

            $fullQuery->execute([
              ":name" => $name,
              ":adress" => $adress,
              ":countryid" => $countryId
            ]);

            echo "<p>Leverancier: " . $name . " is toegevoegd aan de database</p>";
          }
          ?>
        </div>
      </form>
      <form method="post" action="">
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
          <?php

          if (isset($_POST["submit-cu"])) {
            $firstname = $_POST["customername"];
            $lastname = $_POST["customerlastname"];
            $email = $_POST["customeremail"];
            $country = $_POST["customercountry"];
            $province = $_POST["customerprovince"];
            $city = $_POST["customercity"];
            $adress = $_POST["customeradress"];
            $zipcode = $_POST["customerzip"];
            $phonenr = $_POST["customerphone"];
            $dob = $_POST["customerdob"];

            try {
              $fullQuery = $db->prepare("INSERT INTO customers (firstname, lastname, email, country, province, city, adress, zipcode, phonenumber, birthday) 
              VALUES (:firstname, :lastname, :email, :country, :province, :city, :adress, :zipcode, :phonenumber, :birthday)");
            } catch (PDOException $e) {
              die("Fout bij verbinden met database: " . $e->getMessage());
            }

            $fullQuery->execute([
              ":firstname" => $firstname,
              ":lastname" => $lastname,
              ":email" => $email,
              ":country" => $country,
              ":province" => $province,
              ":city" => $city,
              ":adress" => $adress,
              ":zipcode" => $zipcode,
              ":phonenumber" => $phonenr,
              ":birthday" => $dob
            ]);


            echo "<p>Klant: " . $firstname . " is toegevoegd aan de database</p>";
          }
          ?>
        </div>
      </form>


    </section>

  </main>
</body>

</html>