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

        <section class="Admin-see-content">
            <div class="see-what">
                <form class="see-form" method="POST" action="">
                    <div>
                        <label for="see">Welke gegevens wilt u zien:</label>
                        <div class="see-radio">
                            <div>
                                <input type="radio" name="see" id="orders" value="orders">
                                <label for="orders">Bestellingen</label>
                            </div>
                            <div>
                                <input type="radio" name="see" id="lorem" value="lorem">
                                <label for="orders">Lorem</label>
                            </div>
                        </div>
                        <!-- Voeg hier eventueel andere inputs toe -->
                    </div>
                    <input class="submitbtn" type="submit" value="Filter Gegevens">
                </form>
            </div>
        </section>
        <section class="grid-container">
            <div class="grid-item">
                <div></div>
                <div></div>
                <div></div>
                <div></div>
            </div>
        </section>
    </main>
</body>

</html>