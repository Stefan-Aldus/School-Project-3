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

        if (isset($_POST["submit-c"])) {
            $_SESSION["category"] = $_POST["category"];
            filterInput();
        } elseif (isset($_POST["final-submit"])) {
            echo "<p>Categorie: " . $_SESSION["category"] . " is toegevoegd aan de database</p>";
            addToDB($db);
        } else {
            exit("U heeft deze pagina op de verkeerde manier bezocht!");
        }


        ?>

        <section class="admin-add-content">
            <form method="post" action="">
                <div class="admin-add">
                    <h3>Voeg category toe</h3>
                    <label for="category">naam category:</label>
                    <input readonly value="<?php echo $_POST["category"] ?>" type="text" id="category" name="category"
                        required />
                    <input class="submit-admin" type="submit" name="final-submit" id="final-submit" value="confirm">
                </div>
            </form>
            <?php
            function filterInput()
            {
                $_SESSION["filteredCategory"] = htmlspecialchars($_SESSION["category"]);

                if (!$_SESSION["filteredCategory"]) {
                    header("Location: ./Databaseadd.php?message='Categorie is incorrect!'");
                }
                ;

            }


            function addToDB($db)
            {
                try {
                    $fullQuery = $db->prepare("INSERT INTO category (`name`) VALUES (:name)");
                } catch (PDOException $e) {
                    die("Fout bij verbinden met database: " . $e->getMessage());
                }
                $fullQuery->execute([
                    ":name" => $_SESSION["filteredCategory"]
                ]);

                $message = "Categorie: " . $_SESSION["filteredCategory"] . " is toegevoegd aan de database";

                session_abort();
                header("Location: ../adminpages/Databaseadd.php?message=" . urlencode($message));
            }
            ?>
        </section>
    </main>
    <?php include "../includes/footer.html"; ?>
</body>

</html>