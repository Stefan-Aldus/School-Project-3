<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <base href="../">
    <link rel="stylesheet" href="style.css">
    <title>Landen inzien - Brouwerskazen</title>
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
                <h1>Admin Klant Producten inzien</h1>
                <p> Op deze pagina kunt u de Hoeveelheid producten per klant inzien</p>

            </div>
            <img class="about-mk-pic" src="./img/mederwerker.png" alt="">
        </div>

        <section class="country-stuff small-margin">
            <table>
                <caption>Spreiding Producten</caption>
                <tr>
                    <th>KlantID</th>
                    <th>Klant Voornaam</th>
                    <th>Klant Achternaam</th>
                    <th>Product Naam</th>
                    <th>Hoeveelheid van het product</th>
                </tr>
                <?php
                try {
                    $query = $db->prepare("
                        SELECT customers.customerid, customers.firstname AS firstname, customers.lastname AS lastname, products.name AS productname, orderrules.quantity AS amount
                        FROM customers
                        INNER JOIN orders ON orders.customerid = customers.customerid
                        INNER JOIN orderrules ON orderrules.orderid = orders.orderid
                        INNER JOIN products ON products.productid = orderrules.productid
                        ORDER BY lastname;
                        ");
                    $query->execute();
                } catch (PDOException $e) {
                    exit($e->getMessage());
                }

                $results = $query->fetchAll();
                foreach ($results as $result) {
                    echo '<tr>';
                    echo '<td>' . $result["customerid"] . '</td>';
                    echo '<td>' . $result["firstname"] . '</td>';
                    echo '<td>' . $result["lastname"] . '</td>';
                    echo '<td>' . $result["productname"] . '</td>';
                    echo '<td>' . $result["amount"] . "</td>";
                    echo '</tr>';
                }
                ?>
            </table>

        </section>
    </main>

    <?php include '../includes/footer.html' ?>
</body>

</html>