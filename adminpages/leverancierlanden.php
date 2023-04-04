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
                <h1>Admin Spreiding Leveranciers inzien</h1>
                <p> Op deze pagina kunt u de spreiding van de leveranciers inzien.</p>

            </div>
            <img class="about-mk-pic" src="./img/mederwerker.png" alt="">
        </div>

        <section class="country-stuff small-margin">
            <form class="see-form" method="POST" action="">
                <div>
                    <input placeholder="Filteren op naam van land" type="text" name="countryname" id="name">
                </div>
                <!-- <input class="submitbtn" type="submit" value="Filter Gegevens"> -->
            </form>
            <table>
                <caption>Landen</caption>
                <tr>
                    <th>LandID</th>
                    <th>Land Naam</th>
                    <th>Continent</th>
                    <th>Munteenheid</th>
                    <th>Hoeveelheid Leveranciers</th>
                </tr>
                <?php
                if (!isset($_POST["countryname"]) || $_POST["countryname"] === "*") {
                    try {
                        $query = $db->prepare("
                        SELECT country.*, COUNT(suppliers.supplierid) AS suppliercount
                        FROM country 
                        INNER JOIN suppliers ON suppliers.countryid = country.countryid
                        GROUP BY country.name;
                        ");
                        $query->execute();
                    } catch (PDOException $e) {
                        exit($e->getMessage());
                    }
                } else {
                    $countryname = $_POST["countryname"];
                    try {
                        $query = $db->prepare("
                        SELECT country.*, COUNT(suppliers.supplierid) AS suppliercount
                        FROM country 
                        INNER JOIN suppliers ON suppliers.countryid = country.countryid
                        WHERE country.name LIKE '%:name%'
                        GROUP BY country.name;");
                        $query->execute([":countryname" => '%' . $countryname . '%']);
                    } catch (PDOException $e) {
                        exit($e->getMessage());
                    }
                }

                $countries = $query->fetchAll();
                foreach ($countries as $country) {
                    echo '<tr>';
                    echo '<td>' . $country["countryid"] . '</td>';
                    echo '<td>' . $country["name"] . '</td>';
                    echo '<td>' . $country["continent"] . '</td>';
                    echo '<td>' . $country["currency"] . '</td>';
                    echo '<td>' . $country["suppliercount"] . "</td>";
                    echo '</tr>';
                }
                ?>
            </table>

        </section>
    </main>

    <?php include '../includes/footer.html' ?>
</body>

</html>