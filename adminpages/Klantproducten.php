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
            <?php
            try {
                $query = $db->prepare("
                        SELECT customers.customerid, customers.firstname AS firstname, customers.lastname AS lastname
                        FROM customers
                        ORDER BY lastname;
                        ");
                $query->execute();
            } catch (PDOException $e) {
                exit($e->getMessage());
            }

            $results = $query->fetchAll();

            foreach ($results as $result) {
                $customerid = $result["customerid"];

                try {
                    $query2 = $db->prepare("
                        SELECT products.name, products.flavor, orderrules.quantity AS amount
                        FROM products
                        INNER JOIN orderrules ON orderrules.productid = products.productid
                        INNER JOIN orders ON orders.orderid = orderrules.orderid
                        INNER JOIN customers ON customers.customerid = orders.customerid
                        WHERE customers.customerid = :customerid;
                        ");
                    $query2->execute([":customerid" => $customerid]);
                } catch (PDOException $e) {
                    exit($e->getMessage());
                }

                $products = $query2->fetchAll();
                $productsamount = $query2->rowCount();


                echo '<table class="spread-style smaller-margin">';

                echo "<thead><th> Voornaam klant: " . $result["firstname"] . "</th>";
                echo "<th> Achternaam klant: " . $result["lastname"] . "</th>";
                echo "<th> KlantID: " . $result["customerid"] . "</th>";
                echo "</thead>";
                echo "<th> Naam product  </th>";
                echo "<th>Type Product </th>";
                echo "<th> Hoeveelheid Product </th>";
                echo "</thead>";
                echo "<tbody>";
                echo "<tr>";

                foreach ($products as $product) {
                    echo "<tr>";
                    echo "<td>" . $product["name"] . "</td>";
                    echo "<td> " . $product["flavor"] . "</td>";
                    echo "<td>" . $product["amount"] . "</td>";
                    echo "</tr>";
                }
                if ($productsamount <= 0) {
                    echo "<tr>
                    <td>N.V.T.</td>
                    <td>N.V.T.</td>
                    <td>N.V.T.</td>
                    </tr>";
                }

                echo "</tbody>";
                echo "</table>";

            }
            ?>
            </table>

        </section>
    </main>

    <?php include '../includes/footer.html' ?>
</body>

</html>