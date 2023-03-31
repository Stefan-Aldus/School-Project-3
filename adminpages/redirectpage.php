<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Database Inzien - Brouwerskazen</title>
    <link rel="stylesheet" href="../style.css">
    <base href="../">
</head>

<body>
    <header class="main-head">
        <!-- nav bar -->
        <?php include '../includes/nav.html' ?>
    </header>


    <main class="bg">
        <div class="about-mk">
            <div class="about-mk-title small-margin">
                <h1>Database inzien</h1>
                <p> Op deze pagina kunt u geredirect worden naar de pagina's waar u de database kunt inzien!
                </p>

            </div>
        </div>
        <section class="select-which small-margin">
            <h2>Selecteer welke data u wilt inzien</h2>
            <a href="adminpages/landen.php"><button>Landen</button></a>
            <a href="adminpages/bestellingen.php"> <button>Bestellingen</button></a>
            <a href="adminpages/leveranciers.php"><button>Leveranciers</button></a>
            <a href="adminpages/bestelregels.php"><button>Bestelregels</button></a>

        </section>
    </main>
    <?php include '../includes/footer.html' ?>
</body>

</html>