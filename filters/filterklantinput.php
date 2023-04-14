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
        if (isset($_POST["submit-cu"])) {
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
            <form method="post" action="filters/filterklantinput.php">
                <div class="admin-add">
                    <h3>Voeg Klant toe</h3>
                    <label for="customername">Voornaam Klant:</label>
                    <input readonly value=<?php echo $_POST["customername"] ?> type="text" id="customername"
                        name="customername" required />
                    <label for="customerlastname">Achternaam Klant:</label>
                    <input readonly value=<?php echo $_POST["customerlastname"] ?> type="text" id="customerlastname"
                        name="customerlastname" required />
                    <label for="customeremail">Email klant:</label>
                    <input readonly value=<?php echo $_POST["customeremail"] ?> type="text" id="customeremail"
                        name="customeremail" required />
                    <label for="customercountry">Land v.d. klant:</label>
                    <input readonly value=<?php echo $_POST["customercountry"] ?> type="text" id="customercountry"
                        name="customercountry" required />
                    <label for="customerprovince">Provincie v.d. klant:</label>
                    <input readonly value=<?php echo $_POST["customerprovince"] ?> type="text" id="customerprovince"
                        name="customerprovince" required />
                    <label for="customercity">Stad v.d. klant:</label>
                    <input readonly value=<?php echo $_POST["customercity"] ?> type="text" id="customercity"
                        name="customercity" required />
                    <label for="customeradress">Adress v.d. klant:</label>
                    <input readonly value=<?php echo $_POST["customeradress"] ?> type="text" id="customeradress"
                        name="customeradress" required />
                    <label for="customerzip">Postcode v.d. klant:</label>
                    <input readonly value=<?php echo $_POST["customerzip"] ?> type="text" id="customerzip"
                        name="customerzip" required />
                    <label for="customerphone">Telefoon Nr. v.d. klant:</label>
                    <input readonly value=<?php echo $_POST["customerphone"] ?> type="text" id="customerphone"
                        name="customerphone" required />
                    <label for="customerdob">Geboortedatum v.d. klant:</label>
                    <input readonly value=<?php echo $_POST["customerdob"] ?> type="date" id="customerdob"
                        name="customerdob" required />
                    <input class="submit- admin" type="submit" name="final-submit" value="submit">
                </div>

                <?php
                // this function adds the information to the database
                function addToDB($db)
                {
                    // first it prepares and try's the Query's
                    try {
                        $fullQuery = $db->prepare("INSERT INTO customers 
                        (`firstname`, `lastname`, email, country, province, city, adress, zipcode, phonenumber, birthday)
                         VALUES
                        (:firstname, :lastname, :email, :country, :province, :city, :adress, :zipcode, :phonenumber, :birthday)");
                    } catch (PDOException $e) {
                        // if the Quary cant run succesfull it will give a error message
                        die("Fout bij verbinden met database: " . $e->getMessage());
                    }
                    // executes the Queries
                
                    // Inserts the values inti the queries
                    $fullQuery->execute([
                        ":firstname" => $_SESSION["filteredcustomername"],
                        ":lastname" => $_SESSION["filteredcustomerlastname"],
                        ":email" => $_SESSION["filteredcustomeremail"],
                        ":country" => $_SESSION["filteredcustomercountry"],
                        ":province" => $_SESSION["filteredcustomerprovince"],
                        ":city" => $_SESSION["filteredcustomercity"],
                        ":adress" => $_SESSION["filteredcustomeradress"],
                        ":zipcode" => $_SESSION["filteredcustomerzip"],
                        ":phonenumber" => $_SESSION["filteredcustomerphone"],
                        ":birthday" => $_SESSION["filteredcustomerdob"],
                    ]);

                    $message = "Klant: " . $_SESSION["filteredcustomername"] . " is toegevoegd aan de database";

                    session_abort();
                    header("Location: ../adminpages/Databaseadd.php?message=" . urlencode($message));
                }


                // function to filter the inputted variables in the Query
                function filterInput()
                {
                    // here it checks if the sessionID includes any HTML tags
                    $_SESSION["filteredcustomername"] = htmlspecialchars($_POST["customername"]);
                    $_SESSION["filteredcustomerlastname"] = htmlspecialchars($_POST["customerlastname"]);
                    $_SESSION["filteredcustomeremail"] = htmlspecialchars($_POST["customeremail"]);
                    $_SESSION["filteredcustomercountry"] = htmlspecialchars($_POST["customercountry"]);
                    $_SESSION["filteredcustomerprovince"] = htmlspecialchars($_POST["customerprovince"]);
                    $_SESSION["filteredcustomercity"] = htmlspecialchars($_POST["customercity"]);
                    $_SESSION["filteredcustomeradress"] = htmlspecialchars($_POST["customeradress"]);
                    $_SESSION["filteredcustomerzip"] = htmlspecialchars($_POST["customerzip"]);
                    $_SESSION["filteredcustomerphone"] = htmlspecialchars($_POST["customerphone"]);
                    $_SESSION["filteredcustomerdob"] = htmlspecialchars($_POST["customerdob"]);

                    // if it does include any HTML tags it will return you to the Datavaseadd page and gives a error
                    if (!$_SESSION["filteredcustomername"]) {
                        header("Location: ../adminpages/Databaseadd.php?message='Voornaam is incorrect!'");
                        exit();
                    }
                    if (!$_SESSION["filteredcustomerlastname"]) {
                        header("Location: ../adminpages//Databaseadd.php?message='Achternaam is incorrect!'");
                        exit();
                    }
                    if (!$_SESSION["filteredcustomeremail"]) {
                        header("Location: ../adminpages/Databaseadd.php?message='Email is incorrect!'");
                        exit();
                    }
                    if (!$_SESSION["filteredcustomercountry"]) {
                        header("Location: ../adminpages/Databaseadd.php?message='Land is incorrect!'");
                        exit();
                    }
                    if (!$_SESSION["filteredcustomerprovince"]) {
                        header("Location: ../adminpages/Databaseadd.php?message='Provincie is incorrect!'");
                        exit();
                    }
                    if (!$_SESSION["filteredcustomercity"]) {
                        header("Location: ../adminpages/Databaseadd.php?message='Stad is incorrect!'");
                        exit();
                    }
                    if (!$_SESSION["filteredcustomeradress"]) {
                        header("Location: ../adminpages/Databaseadd.php?message='Adress is incorrect!'");
                        exit();
                    }
                    if (!$_SESSION["filteredcustomerzip"]) {
                        header("Location: ../adminpages/Databaseadd.php?message='Postcode is incorrect!'");
                        exit();
                    }
                    if (!$_SESSION["filteredcustomerphone"]) {
                        header("Location: ../adminpages/Databaseadd.php?message='Telefoon nummer is incorrect!'");
                        exit();
                    }
                    if (!$_SESSION["filteredcustomerdob"]) {
                        header("Location: ../adminpages/Databaseadd.php?message='Geboortedatum is incorrect!'");
                        exit();
                    }
                }
                ?>
            </form>


        </section>

    </main>
    <?php

    include "../includes/footer.html";
    ?>

</body>

</html>