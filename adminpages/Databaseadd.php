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

            require "../includes/connDatabase.php";

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

            require "../includes/connDatabase.php";

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


    </section>

  </main>
</body>

</html>