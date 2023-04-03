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

        <?php
        session_start();

        if (isset($_POST["submit-l"])) {
            $_SESSION["country"] = $_POST["land"];
            $_SESSION["currency"] = $_POST["currency"];
            $_SESSION["continent"] = $_POST["continent"];
            filterInput();
        } elseif (isset($_POST["final-submit"])) {
            echo "<p>Land: " . $_SESSION["filteredCountry"] . " is toegevoegd aan de database</p>";
            addToDB($db);
        } else {
            exit("U heeft deze pagina op de verkeerde manier bezocht!");
        }


        ?>

        <section class="admin-add-content">
            <form method="post" action="">
                <div class="admin-add">
                    <h3>Wilt u de volgende data toevoegen aan de database?</h3>
                    <label for="land">naam land:</label>
                    <input readonly value="<?php echo $_SESSION["country"] ?>" type="text" id="land" name="land"
                        required />
                    <label for="continent">naam continent:</label>
                    <input type="text" readonly value="<?php echo $_SESSION["continent"] ?>" id="continent"
                        name="continent" required />
                    <label for="currency">Munteenheid afkorting (3 char):</label>
                    <input type="text" readonly value="<?php echo $_SESSION["currency"] ?>" id="currency"
                        name="currency" required />
                    <input class="submit-admin" type="submit" name="final-submit" id="final-submit" value="Confirm">
                </div>
            </form>
            <?php
            function filterInput()
            {
                if (strlen($_SESSION["currency"]) > 3) {
                    header("Location: ./Databaseadd.php?message='U heeft te veel characters voor currency toegevoegd'");
                }
                $_SESSION["filteredCountry"] = htmlspecialchars($_SESSION["country"]);
                $_SESSION["filteredContinent"] = htmlspecialchars($_SESSION["continent"]);
                $_SESSION["filteredCurrency"] = htmlspecialchars($_SESSION["currency"]);

                if (!$_SESSION["filteredCountry"]) {
                    header("Location: ./Databaseadd.php?message='Land is incorrect!'");
                }
                ;
                if (!$_SESSION["filteredContinent"]) {
                    header("Location: ./Databaseadd.php?message='Continent is incorrect!'");

                }
                ;
                if (!$_SESSION["filteredCurrency"]) {
                    header("Location: ./Databaseadd.php?message='Currency is incorrect!'");
                }
                ;

            }


            function addToDB($db)
            {
                try {
                    $fullQuery = $db->prepare("INSERT INTO country (`name`, `continent`, `currency`) VALUES (:name, :continent, :currency)");
                } catch (PDOException $e) {
                    die("Fout bij verbinden met database: " . $e->getMessage());
                }
                $fullQuery->execute([
                    ":name" => $_SESSION["filteredCountry"],
                    ":continent" => $_SESSION["filteredContinent"],
                    ":currency" => $_SESSION["filteredCurrency"]
                ]);

                $message = "Land: " . $_SESSION["filteredCountry"] . " is toegevoegd aan de database";

                session_abort();
                header("Location: ../adminpages/Databaseadd.php?message=" . urlencode($message));
            }
            ?>
        </section>
    </main>
    <?php include "../includes/footer.html"; ?>
</body>

</html>