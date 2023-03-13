<!DOCTYPE html>
<html lang="en">
<?php include '../includes/connDatabase.php ' ?>
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
    <h1>Admin data toevoegen</h1>
    <p> Op deze pagina kunt u data toevoegen tot de database, pas op met wat je toevoegt!
    </p>

    </div>
    <img class="about-mk-pic" src="./img/mederwerker.png" alt="">
  </div>

<section class="Admin-add-content">
<div class="land-add">
  <form method="POST" action="">
  <label for="land">naam land:</label>
  <input type="text" id="land" name="land" required />
  <label for="continent">naam continent:</label>
  <input type="text" id="continent" name="continent" required />
  <label for="continent">Munteenheid afkorting ( 3 char):</label>
  <input type="text" id="continent" name="continent" required />

  </form>
</div>


</section>

  </main>
</body>

</html>