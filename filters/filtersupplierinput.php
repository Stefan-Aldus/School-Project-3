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
        session_start();
        include '../includes/nav.html';
        require "../includes/connDatabase.php";


        if (isset($_GET['message'])) {
            echo "<script> alert('" . $_GET['message'] . "')</script>";
        }
        ?>
    </header>


    <main class="bg">
        <?php
        // Checks if the original form is submitted, and calls the filterinput function
        if (isset($_POST["submit-lz"])) {
            filterInput();
            // Else checks if the final submit form is submitted, and calls the addtodb function
        } elseif (isset($_POST["final-submit"])) {
            addToDB($db);
        } else {
            // Else exits the program
            exit("U heeft deze pagina op de verkeerde manier bezocht!");
        }

        ?>
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
                    <h3>Voeg Leverancier toe</h3>
                    <label for="suppliername">Naam leverancier:</label>
                    <input readonly value=<?php echo $_POST["suppliername"] ?> type="text" id="suppliername"
                        name="suppliername" required />
                    <label for="adress">Adres leverancier:</label>
                    <input readonly value=<?php echo $_POST["adress"] ?> type="text" id="adress" name="adress"
                        required />
                    <label for="country">Land:</label>
                    <select readonly name="country-lz" id="country" -lz name="country-lz">
                        <option value="">
                            <?php echo $_POST["country-lz"] ?>
                        </option>
                    </select>
                    <input class="submit-admin" type="submit" name="final-submit" value="submit">
                    <?php
                    // this function adds the information to the database
                    function addToDB($db)
                    {
                        // first it prepares and try's the Query's
                        try {
                            $fullQuery = $db->prepare("INSERT INTO suppliers (`name`, `adress`, countryid) VALUES (:name, :adress, :countryid)");
                            $findCountryId = $db->prepare("SELECT countryid FROM country WHERE `name` = :countryname");
                        } catch (PDOException $e) {
                            // if the Quary cant run succesfull it will give a error message
                            die("Fout bij verbinden met database: " . $e->getMessage());
                        }
                        // executes the Query's
                        $findCountryId->execute([':countryname' => $_SESSION["filteredcountry"]]);
                        $countryId = $findCountryId->fetch()['countryid'];

                        // :name, :adress and :countryid will save virable and session id's into the Query
                        $fullQuery->execute([
                            ":name" => $_SESSION["filteredsuppliername"],
                            ":adress" => $_SESSION["filteredadress"],
                            ":countryid" => $countryId
                        ]);

                        $message = "Leverancier: " . $_SESSION["filteredsuppliername"] . " is toegevoegd aan de database";

                        session_abort();
                        header("Location: ../adminpages/Databaseadd.php?message=" . urlencode($message));
                    }


                    // function to filter the inputted variables in the Query
                    function filterInput()
                    {
                        // here it checks if the sessionID includes any HTML tags
                        $_SESSION["filteredsuppliername"] = htmlspecialchars($_POST["suppliername"]);
                        $_SESSION["filteredadress"] = htmlspecialchars($_POST["adress"]);
                        $_SESSION["filteredcountry"] = htmlspecialchars($_POST["country-lz"]);

                        // if it does include any HTML tags it will return you to the Datavaseadd page and gives a error
                        if (!$_SESSION["filteredsuppliername"]) {
                            header("Location: ../adminpages/Databaseadd.php?message='Supplier naam is incorrect!'");
                            exit();
                        }
                        if (!$_SESSION["filteredadress"]) {
                            header("Location: ../adminpages//Databaseadd.php?message='Supplier Adress is incorrect!'");
                            exit();
                        }
                        if (!$_SESSION["filteredcountry"]) {
                            header("Location: ../adminpages/Databaseadd.php?message='Country is incorrect!'");
                            exit();
                        }

                    }
                    ?>
                </div>
            </form>


        </section>

    </main>
    <?php

    include "../includes/footer.html";
    ?>

</body>

</html>