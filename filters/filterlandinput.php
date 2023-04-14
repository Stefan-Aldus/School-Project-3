<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="../">
    <link rel="stylesheet" href="style.css">
    <title>Check Input - Brouwerskazen</title>
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
        // starts the session
        session_start();
        // Checks if the original form is submitted, and calls the filterinput function
        if (isset($_POST["submit-l"])) {
            // $_POST's get stored in to session variables since the page gets refreshed
            $_SESSION["country"] = $_POST["land"];
            $_SESSION["currency"] = $_POST["currency"];
            $_SESSION["continent"] = $_POST["continent"];
            filterInput();
            // checks if the final-submit for is submitted then it will echo a msg and calls the addtodatabase function
        } elseif (isset($_POST["final-submit"])) {
            echo "<p>Land: " . $_SESSION["filteredCountry"] . " is toegevoegd aan de database</p>";
            addToDB($db);
            // if neither is the case it will give you a msg en exits the progam
        } else {
            exit("U heeft deze pagina op de verkeerde manier bezocht!");
        }


        ?>

        <section class="admin-add-content">
            <form method="post" action="">
                <div class="admin-add">
                    <h3>Wilt u de volgende data toevoegen aan de database?</h3>
                    <label for="land">naam land:</label>
                    <input readonly value="<?php echo $_POST["land"] ?>" type="text" id="land" name="land" required />
                    <label for="continent">naam continent:</label>
                    <input type="text" readonly value="<?php echo $_POST["continent"] ?>" id="continent"
                        name="continent" required />
                    <label for="currency">Munteenheid afkorting (3 char):</label>
                    <input type="text" readonly value="<?php echo $_POST["currency"] ?>" id="currency" name="currency"
                        required />
                    <input class="submit-admin" type="submit" name="final-submit" id="final-submit" value="Confirm">
                </div>
            </form>
            <?php
            // function to filter the inputted variables in the Query
            function filterInput()
            {
                // checks if the string in the $_POST varibale is longer then 3 characters
                // if it is it will give you a error and send you back to the original database add page
                if (strlen($_POST["currency"]) > 3) {
                    header("Location: ./Databaseadd.php?message='U heeft te veel characters voor currency toegevoegd'");
                }
                // here it checks if the sessionID includes any HTML tags
                $_SESSION["filteredCountry"] = htmlspecialchars($_POST["land"]);
                $_SESSION["filteredContinent"] = htmlspecialchars($_POST["continent"]);
                $_SESSION["filteredCurrency"] = htmlspecialchars($_POST["currency"]);
                
                // if it does include any HTML tags it will return you to the Datavaseadd page and gives a error
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

            // this function adds the information to the database
            function addToDB($db)
            {
                // first it prepares and try's the Query's
                try {
                    $fullQuery = $db->prepare("INSERT INTO country (`name`, `continent`, `currency`) VALUES (:name, :continent, :currency)");
                } catch (PDOException $e) {
                      // if the Quary cant run succesfull it will give a error message
                    die("Fout bij verbinden met database: " . $e->getMessage());
                }
                // executes the Query's
                $fullQuery->execute([
                    // // :name, :continent and :currency will save session id's into the Query
                    ":name" => $_SESSION["filteredCountry"],
                    ":continent" => $_SESSION["filteredContinent"],
                    ":currency" => $_SESSION["filteredCurrency"]
                ]);
                // variable to store the msg that will get send once its submitted correctly
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