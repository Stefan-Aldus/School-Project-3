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
        <?php
        include '../includes/nav.html';
        require '../includes/connDatabase.php'
            ?>
    </header>


    <main class="bg">
        <div class="about-mk">
            <div class="about-mk-title">
                <h1>Admin orders inzien</h1>
                <p> Op deze pagina kunt u bestellingen inzien, en door middel van datums filteren om te kijken of er
                    fouten zijn!
                </p>

            </div>
            <img class="about-mk-pic" src="./img/mederwerker.png" alt="">
        </div>

        <section class="Admin-see-content">
            <div class="see-what">
                <form class="see-form" method="POST" action="">
                    <div>
                        <label for="fromdate">Bestellingen vanaf datum:</label>
                        <input type="date" name="fromdate" id="fromdate">
                    </div>
                    <div>
                        <label for="todate">Bestellingen tot-en-met datum:</label>
                        <input type="date" name="todate" id="todate">
                    </div>
                    <input class="submitbtn" type="submit" value="Filter Gegevens">
                </form>
            </div>
        </section>
        <section class="order-list small-margin">
            <table>
                <caption>Bestellingen</caption>
                <tr>
                    <th>OrderID</th>
                    <th>Customerid</th>
                    <th>Date</th>
                    <th>Price</th>
                </tr>
                <?php
                if (!isset($_POST["fromdate"])) {
                    try {
                        $query = $db->prepare("SELECT * FROM orders");
                        $query->execute();
                    } catch (PDOException $e) {
                        exit($e->getMessage());
                    }
                } else {
                    $toDate = $_POST["todate"];
                    $fromDate = $_POST["fromdate"];
                    $formattedToDate = date('Y-m-d', strtotime($toDate));
                    $formattedFromDate = date('Y-m-d', strtotime($fromDate));
                    try {
                        $query = $db->prepare("SELECT * FROM orders WHERE `date` BETWEEN :fromdate AND :todate");
                        $query->execute([":fromdate" => $formattedFromDate, ":todate" => $formattedToDate]);
                    } catch (PDOException $e) {
                        exit($e->getMessage());
                    }
                }

                $orders = $query->fetchAll();
                foreach ($orders as $order) {
                    echo '<tr>';
                    echo '<td>' . $order["orderid"] . '</td>';
                    echo '<td>' . $order["customerid"] . '</td>';
                    echo '<td>' . $order["date"] . '</td>';
                    echo '<td>' . $order["price"] . '</td>';
                    echo '</tr>';
                }
                ?>
            </table>

        </section>
    </main>

    <?php include '../includes/footer.html' ?>
</body>

</html>