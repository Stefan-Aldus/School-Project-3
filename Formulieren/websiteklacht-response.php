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
session_start();


      //Makes the submit button submit the information given into the database or say that youve gotten here in the wrong way
      if(isset($_POST["submit"])) {
           $_SESSION["name"] = $_POST["name"];
           $_SESSION["email"] = $_POST["email"];
           $_SESSION["about"] = $_POST["about"];
           $_SESSION["complaint"] = $_POST["complaint"];
            }
       else {
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
    <h1>Website klacht</h1>
    <p>Heeft u een klacht over onze website omdat de website traag was, of vind u dat de website niet mooi is? Dien dan hier een klacht in en u zult binnen 24 uur gegaradeerd een antwoord terug ontvangen.
    </p>
   
    
    </div>
  </div>
  <form class="formulieren" method="post" action="./Formulieren/websiteklacht-response.php">
      <div class="input-mk">
        <label for="name">Uw naam is:</label>
        <input class="textfield-1-mk type=" text" id="name" name="name" pattern="[A-Za-z]+"
          value="<?php echo $_SESSION["name"] ?> " required />
        <label for="email">Uw email is:</label>
        <input class="textfield-1-mk type=" text" id="email" name="email" value="<?php echo $_SESSION["email"] ?>"
          required />
        <label for="about:">Deel website:</label>
        <input class="textfield-1-mk type=" text" id="about" name="about" value=<?php echo $_SESSION["about"] ?>
          required />
        <label for="complaint">Wat is uw klacht:</label>
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