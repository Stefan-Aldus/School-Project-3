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
  <!-- session start -->
<?php
 session_start();
?>

  <header class="main-head">
    <!-- nav bar -->
    <?php include '../includes/nav.html' ?>
  </header>
  
<main class="bg">
  <div class="about-mk">
    <div class="about-mk-title">
    <h1>Medewerker klacht</h1>
    <p>Heeft u een klacht over een medewerker omdat de service traag was, of vind u dat u niet goed geholpen bent? Dien dan hier een klacht in en u zult binnen 24 uur gegaradeerd een antwoord terug ontvangen.
    </p>

    
    </div>
    <img class="about-mk-pic" src="./img/mederwerker.png" alt="">
  </div>

  <form class="formulieren" method="post" action="./Formulieren/medewerkerklacht-response.php">
  <div class="input-mk">
        <label for="name">Uw naam is:</label>
        <input class="textfield-1-mk type="text" id="name" name="name"pattern="[A-Za-z]+" required />
        <label for="email">Uw email is:</label>
        <input class="textfield-1-mk type="text" id="email" name="email" required />
        <label for="about:">Naam medewerker:</label>
        <input class="textfield-1-mk type="text" id="about" name="about" required />
        <label for="complaint">Wat is uw klacht:</label>
        <textarea name="complaint" id="complaint" required></textarea>
        <input class="textfield-2-mk"  type="submit" name="submit" id="submit" value="submit">
    </div>
  </form>

</main>

<?php include '../includes/footer.html'; ?>
</body>

</html>