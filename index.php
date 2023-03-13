<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="style.css">
  <title>Home</title>
  <!-- Linking font for navbar logo -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link
    href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
    rel="stylesheet">
  <base href="./">
</head>

<body>
  <header class="main-head">
    <!-- nav bar -->
    <?php include 'includes/nav.html'; ?>
  </header>

  <main class="bg">
    <section class="about-h">
      <div class="about-title-h">
        <h1>Welkom bij Brouwerskazen</h1>
        <p>Wij zijn BrouwersKazen. BrouwersKazen is een klein bedrijf dat gevestigd is in Spijkenisse in eind 2022 door
          4 studenten van het TCR MBO college: Jens Brouwershaven, Jesse van Vliet, Stefan Aldus en Rowen Bakkeren. Ons
          bedrijf is gemaakt met het motief om kaas van een goede kwaliteit en en lage prijs te verkopen. Ons grootste
          doel is om onze klanten blij te maken met onze hoge kwaliteit kaas. Wij zorgen ervoor dat we de beste kaas
          voor een goede en lage prijs aan u kunnen verkopen. </p>
      </div>


      <img class="about-pic" src="./img/tcrbuilding.jpg" alt="">


    </section>

    <section class="header-h">
      <div class="container-header-h">
        <div class="card-h" id="young">

          <p class="sharp-h">Jonge Kaas</p>

        </div>

        <div class="card-h" id="old">


          <p class="sharp-h">Oude Kaas</p>
        </div>
        <div class="card-h" id="sharp">
          <p class="sharp-h">Scherpe Kaas</p>


        </div>
      </div>
      <div class="container2-header-h">
        <div class="card2-h" id="accesoires">

          <p class="sharp-h">Accesoires</p>
        </div>
      </div>

    </section>



  </main>

  <!-- footer -->
  <?php include 'includes/footer.html'; ?>
  <script src="./app.js"></script>
</body>

</html>