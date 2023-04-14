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
        if (isset($_POST["submit-p"])) {
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
                    <h3>Voeg product toe</h3>
                    <label for="product">Naam product:</label>
                    <input readonly value=<?php echo $_POST["product-naam"] ?> type="text" id="product"
                        name="product-naam" required />
                    <label for="product">Leeftijd product:</label>
                    <input readonly value=<?php echo $_POST["product-age"] ?> type="number" id="product"
                        name="product-age" required />
                    <label for="product">Soort product:</label>
                    <input readonly value=<?php echo $_POST["product-type"] ?> type="text" id="product"
                        name="product-type" required />
                    <label for="product">Smaak product:</label>
                    <input readonly value=<?php echo $_POST["product-flav"] ?> type="text" id="product"
                        name="product-flav" required />
                    <label for="product">Prijs product:</label>
                    <input readonly value=<?php echo $_POST["product-price"] ?> type="number" id="product"
                        name="product-price" required />
                    <label for="product">Texture product:</label>
                    <input readonly value=<?php echo $_POST["product-texture"] ?> type="text" id="product"
                        name="product-texture" required />
                    <label for="product">Cat product:</label>
                    <select readonly required />
                    <option value="">
                        <?php echo $_POST["productcat"] ?>
                    </option>
                    </select>
                    <label for="product">SupplierID:</label>
                    <input readonly value="<?php echo $_POST["suppid"] ?>" type="number" id="product" name="suppid"
                        required />
                    <input class="submit-admin" type="submit" name="final-submit" value="submit">
                    <?php
                    // this function adds the information to the database
                    function addToDB($db)
                    {
                        if ($_POST["product-age"] > 0) {
                            $_POST["filteredproductage"] = $_POST["product-age"];
                            try {
                                $addprod = $db->prepare("INSERT INTO products (`name`, age, `type`, flavor, price, texture, categoryid, supplierid) 
                                                      VALUES (:name, :age, :type, :flavor, :price, :texture, :categoryid, :supplierid)");
                                $retrievecatid = $db->prepare("SELECT categoryid FROM category WHERE `name` = :name");
                            } catch (PDOException $e) {
                                die("FOUT IN SQL QUERY " . $e->getMessage());
                            }

                            $retrievecatid->execute([":name" => $_SESSION["filteredcat"]]);
                            $catid = $retrievecatid->fetch();

                            $addprod->execute([
                                ":name" => $_SESSION["filteredproductname"],
                                ":age" => $_SESSION["filteredproductage"],
                                ":type" => $_SESSION["filteredproducttype"],
                                ":flavor" => $_SESSION["filteredproductflav"],
                                ":price" => $_SESSION["filteredproductprice"],
                                ":texture" => $_SESSION["filteredproducttexture"],
                                ":categoryid" => $catid[0],
                                ":supplierid" => $_SESSION["filteredsupplier"]
                            ]);
                        } else {
                            try {
                                $addprod = $db->prepare("INSERT INTO products (`name`, age, `type`, flavor, price, texture, categoryid, supplierid) 
                                                      VALUES (:name, :age, :type, :flavor, :price, :texture, :categoryid, :supplierid)");
                                $retrievecatid = $db->prepare("SELECT categoryid FROM category WHERE `name` = :name");
                            } catch (PDOException $e) {
                                die("FOUT IN SQL QUERY " . $e->getMessage());
                            }

                            $retrievecatid->execute([":name" => $_SESSION["filteredcat"]]);
                            $catid = $retrievecatid->fetch();

                            $addprod->execute([
                                ":name" => $_SESSION["filteredproductname"],
                                ":age" => null,
                                ":type" => $_SESSION["filteredproducttype"],
                                ":flavor" => $_SESSION["filteredproductflav"],
                                ":price" => $_SESSION["filteredproductprice"],
                                ":texture" => $_SESSION["filteredproducttexture"],
                                ":categoryid" => $catid[0],
                                ":supplierid" => $_SESSION["filteredsupplier"]
                            ]);
                        }
                        ;

                        $message = "Lever: " . $_SESSION["filteredsuppliername"] . " is toegevoegd aan de database";

                        session_abort();
                        header("Location: ../adminpages/Databaseadd.php?message=" . urlencode($message));
                    }


                    // function to filter the inputted variables in the Query
                    function filterInput()
                    {
                        // here it checks if the sessionID includes any HTML tags
                        $_SESSION["filteredproductname"] = htmlspecialchars($_POST["product-naam"]);
                        $_SESSION["filteredproductage"] = htmlspecialchars($_POST["product-age"]);
                        $_SESSION["filteredproducttype"] = htmlspecialchars($_POST["product-type"]);
                        $_SESSION["filteredproductflav"] = htmlspecialchars($_POST["product-flav"]);
                        $_SESSION["filteredproductprice"] = htmlspecialchars($_POST["product-price"]);
                        $_SESSION["filteredproducttexture"] = htmlspecialchars($_POST["product-texture"]);
                        $_SESSION["filteredproductcat"] = htmlspecialchars($_POST["productcat"]);
                        $_SESSION["filteredsupplier"] = htmlspecialchars($_POST["suppid"]);

                        // if it does include any HTML tags it will return you to the Datavaseadd page and gives a error
                        if (!$_SESSION["filteredproductname"]) {
                            header("Location: ../adminpages/Databaseadd.php?message='Product naam is incorrect!'");
                            exit();
                        }
                        if (!$_SESSION["filteredproductage"]) {
                            header("Location: ../adminpages//Databaseadd.php?message='Product leeftijd is incorrect!'");
                            exit();
                        }
                        if (!$_SESSION["filteredproducttype"]) {
                            header("Location: ../adminpages/Databaseadd.php?message='Product type is incorrect!'");
                            exit();
                        }
                        if (!$_SESSION["filteredproductflav"]) {
                            header("Location: ../adminpages/Databaseadd.php?message='Product smaak is incorrect!'");
                            exit();
                        }
                        if (!$_SESSION["filteredproductprice"]) {
                            header("Location: ../adminpages/Databaseadd.php?message='Product prijs is incorrect!'");
                            exit();
                        }
                        if (!$_SESSION["filteredproducttexture"]) {
                            header("Location: ../adminpages/Databaseadd.php?message='Product texture is incorrect!'");
                            exit();
                        }
                        if (!$_SESSION["filteredproductcat"]) {
                            header("Location: ../adminpages/Databaseadd.php?message='Product catogorie is incorrect!'");
                            exit();
                        }
                        if (!$_SESSION["filteredsupplier"]) {
                            header("Location: ../adminpages/Databaseadd.php?message='supplier is incorrect!'");
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