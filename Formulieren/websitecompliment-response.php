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

  <?php
  //starts a _POST session
  session_start();


  //Makes the submit button submit the information given into the database or say that youve gotten here in the wrong way
  if (isset($_POST["submit"])) {
    $_SESSION["name"] = $_POST["name"];
    $_SESSION["email"] = $_POST["email"];
    $_SESSION["about"] = $_POST["about"];
    $_SESSION["complaint"] = $_POST["complaint"];
  } else {
    echo "<h2>U bent niet op de juiste manier hier gekomen</h2>";

  }
  ?>
  <header class="main-head">
    <!-- nav bar -->
    <?php include '../includes/nav.html' ?>
  </header>
  <main class="bg">
    <div class="about-mk">
      <div class="about-mk-title">
        <h1>Website Compliment</h1>
        <p>
          Heeft u een compliment over onze website die
          u graag met ons wilt delen? Dien deze dan hier in.
        </p>



      </div>
      <img class="about-mk-pic" src="./img/medewerker.png" alt="">
    </div>

    <form class="formulieren" method="post" action="./Formulieren/productklacht-response.php">
      <div class="input-mk">
        <label for="name">Uw naam is:</label>
        <input class="textfield-1-mk type=" text" id="name" name="name" pattern="[A-Za-z]+"
          value="<?php echo $_SESSION["name"] ?> " required />
        <label for="email">Uw email is:</label>
        <input class="textfield-1-mk type=" text" id="email" name="email" value="<?php echo $_SESSION["email"] ?>"
          required />
        <label for="about:">Uw compliment gaat over:</label>
        <input class="textfield-1-mk type=" text" id="about" name="about" value=<?php echo $_SESSION["about"] ?>
          required />
        <label for="complaint">Wat is uw compliment:</label>
        <textarea name="complaint" id="complaint" required><?php echo $_SESSION["complaint"]; ?></textarea>
        <input class="textfield-2-mk" type="submit" name="submit" id="submit" value="submit">
      </div>
    </form>

  </main>

  <?php
  include '../includes/footer.html';
  ?>
</body>

</html>