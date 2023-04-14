<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="../">
    <link rel="stylesheet" href="style.css">
    <title>Categorien inzien - Brouwerskazen</title>
</head>

<body>
    <header class="main-head">
        <!-- nav bar -->
        <?php
        include '../includes/nav.html';
        require '../includes/connDatabase.php'
            ?>
    </header>


    <main class="bg">
        <div class="about-mk">
            <div class="about-mk-title">
                <h1>Admin categorien inzien</h1>
                <p> Op deze pagina kunt u de categorien inzien van onze kazen!</p>

            </div>
            <img class="about-mk-pic" src="./img/mederwerker.png" alt="">
        </div>

        <section class="country-stuff small-margin">
            <form class="see-form" method="POST" action="">
                <div>
                    <input placeholder="Filteren op naam van categorie" type="text" name="categoryname" id="name">
                </div>
                <!-- <input class="submitbtn" type="submit" value="Filter Gegevens"> -->
            </form>
            <table>
                <caption>Categorien</caption>
                <tr>
                    <th>CategoryID</th>
                    <th>Categorie Naam</th>
                    <th>Aantal Producten</th>
                </tr>
                <?php
                // it checks if the cat name has been set or not
                if (!isset($_POST["categoryname"]) || $_POST["categoryname"] === "*") {
                    // try's to define a Query
                    try {
                        $query = $db->prepare("
                        SELECT category.*, COUNT(products.categoryid) AS amount 
                        FROM category 
                        LEFT JOIN products ON category.categoryid = products.categoryid
                        GROUP BY category.categoryid
                        ");
                        $query->execute();
                        // if the Query can't be defined it will activate the catch with the error msg
                    } catch (PDOException $e) {
                        exit($e->getMessage());
                    }
                    // if it has't been set it will activate the filter by showing everything
                } else {
                    $categoryname = $_POST["categoryname"];
                    // try's to define a Query
                    try {
                        $query = $db->prepare("
                        SELECT category.*, COUNT(products.categoryid) AS amount 
                        FROM category 
                        INNER JOIN products ON category.categoryid = products.categoryid
                        WHERE category.name LIKE :categoryname
                        ");
                        $query->execute([":categoryname" => '%' . $categoryname . '%']);
                        // if the Query can't be defined it will activate the catch with the error msg
                    } catch (PDOException $e) {
                        exit($e->getMessage());
                    }
                }
                //  fetches all results into categories
                $categories = $query->fetchAll();
                // for each catorgory it echo's all the information
                foreach ($categories as $category) {
                    echo '<tr>';
                    echo '<td>' . $category["categoryid"] . '</td>';
                    echo '<td>' . $category["name"] . '</td>';
                    echo '<td>' . $category["amount"] . '</td>';
                    // echo '<td>' . $category["currency"] . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>

        </section>
    </main>

    <?php include '../includes/footer.html' ?>
</body>

</html>