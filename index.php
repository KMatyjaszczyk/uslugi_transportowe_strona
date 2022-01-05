<?php
include_once 'classes/LoggedInUserService.php';
include_once 'classes/UserService.php';
include_once 'classes/UserManager.php';

$loggedInUserService = new LoggedInUserService();
$userService = new UserService();
$userManager = new UserManager();

$sessionId = $userManager->retrieveSessionId();
$isUserLoggedIn = $userManager->isUserLoggedIn($sessionId);
$user = null;
if ($isUserLoggedIn) {
    $user = $userService->getById(
        $loggedInUserService->getBySessionId($sessionId)->getUserId()
    );
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="Usługi transportowe" />
    <meta name="author" content="Krzysztof Matyjaszczyk" />
    <title>Usługi Transportowe</title>
    <!-- Favicon-->
    <link rel="icon" type="image/x-icon" href="assets/logo.png" />
    <!-- Core theme CSS (includes Bootstrap)-->
    <link href="css/styles.css" rel="stylesheet" />
</head>

<body>

<?php
// For test purposes
echo '<div style="display: none;">';
echo 'sessionId: ';
var_dump($sessionId);
echo "<br>";
echo 'isUserLoggedIn: ';
var_dump($isUserLoggedIn);
echo "<br>";
echo 'user: ';
var_dump($user);
echo "</div>";
?>

    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#!"><img class="img-fluid" src="img/logo-male.png"> Usługi Transportowe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">O nas</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeria.php">Galeria</a></li>
                    <!-- Put proper options in nav bar -->
                    <?php
                        if (!$isUserLoggedIn) { // User is not  logged in
                            echo '<li class="nav-item"><a class="nav-link text-info" href="login.php">Zaloguj</a></li>';
                        } else {
                            if ($user->getIsAdmin() == true) { // User is Admin
                                echo '<li class="nav-item"><a class="nav-link" href="panel_zamowien.php">Panel zamówień</a></li>';
                            } else { // User is standard user
                                echo '<li class="nav-item"><a class="nav-link" href="rezerwacja.php">Rezerwacja</a></li>';
                                echo '<li class="nav-item"><a class="nav-link" href="twoje_rezerwacje.php">Twoje rezerwacje</a></li>';
                            }
                            echo '<li class="nav-item"><a class="nav-link text-info" href="processLogin.php?process=logout">Wyloguj</a></li>';
                        }
                    ?>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Header - set the background image for the header in the line below-->
    <header class="py-5 bg-image-full" style="background-image: url('img/baner.jpg'); height: 25rem;">
        <div class="text-center my-5 py-3">
            <!--<img class="img-fluid rounded-circle mb-4" src="img/logo.png" alt="logo" />-->
            <h1 class="text-white fs-2 fw-bolder">Marek Matyjaszczyk</h1>
            <p class="text-white-50 fs-4 mb-0">Wycieczki</p>
            <p class="text-white-50 fs-4 mb-0">Wesela</p>
            <p class="text-white-50 fs-4 mb-0">Wyjazdy okolicznościowe</p>
        </div>
    </header>
    <!-- Main content of the document-->
    <div id="tresc">
        <!-- Content section-->
        <section class="py-5">
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h2>Kompleksowe usługi transportowe</h2>
                        <p class="lead">Oferujemy usługi w zakresie przewozów pasażerskich na terenie
                            Polski.</p>
                        <p class="my-1">Z nami skutecznie zaplanujesz organizację wesela lub niezapomnianą wycieczkę w
                            dowolne miejsce w kraju. Dzięki nam wyjazd integracyjny lub wycieczka szkolna nie będzie
                            stanowiła trudnego wyzwania. Wesprzemy dojazd osób na pogrzeb bliskiej Ci osoby.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Image element - set the background image for the header in the line below-->
        <div class="py-5 bg-image-full" style="background-image: url('img/sekcja1.jpg')">
            <!-- Put anything you want here! The spacer below with inline CSS is just for demo purposes!-->
            <div style="height: 20rem"></div>
        </div>
        <!-- Content section-->
        <section class="py-5">
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h2>30 lat doświadczenia</h2>
                        <p class="lead">Nasze usługi dają zadowolenie klientom od blisko trzech dekad.</p>
                        <p class="my-1">Działalność zaczęliśmy w roku 1991. Poczynając od zapewnienia połączeń
                            kominikacyjnych na terenie gminy Niedźwiada i miasta Lubartów, sukcesywnie przenosiliśmy naszą
                            działalność na większy teren. W miarę rozwoju firmy poszerzaliśmy naszą ofertę o nowe
                            usługi.</p>
                        <p class="my-1">Dzisiaj działamy w wielu sektorach transportu osobowego. Oferujemy zarówno
                            zapewnianie regularnych linii komunikacyjnych, jak i zamówienia indywidualne oraz współpracę
                            z przedsiębiorstwami.</p>
                        <p class="my-1">Zaufała nam między innymi spółka SuperDrob S.A., z którą współpracujemy od ponad
                            5 lat zapewniając transport pracowników do zakładu produkcyjnego.</p>
                    </div>
                </div>
            </div>
        </section>
        <!-- Image element - set the background image for the header in the line below-->
        <div class="py-5 bg-image-full" style="background-image: url('img/sekcja2.jpg')">
            <!-- Put anything you want here! The spacer below with inline CSS is just for demo purposes!-->
            <div style="height: 20rem"></div>
        </div>
        <!-- Content section-->
        <section class="py-5">
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h2>Profesjonalizm</h2>
                        <p class="lead">Doświadczeni pracownicy to podstawa.</p>
                        <p class="my-1">Nasi pracownicy to wysoce wykwalifikowani kierowcy z wieloletnim doświadczeniem
                            w branży transportowej.</p>
                        <p class="my-1">Cechuje nas wysoki poziom kultury osobistej, zapewnienie miłej i profesjonalnej
                            atmosfery podczas podróży.</p>
                        <p class="my-1">W naszej firmie wszyscy wyznajemy zasadę, że zadowolony klient jest naszą
                            najlepszą reklamą.</p>

                    </div>
                </div>
            </div>
        </section>
        <!-- Image element - set the background image for the header in the line below-->
        <div class="py-5 bg-image-full" style="background-image: url('img/sekcja3.jpg')">
            <!-- Put anything you want here! The spacer below with inline CSS is just for demo purposes!-->
            <div style="height: 20rem"></div>
        </div>
        <!-- Content section-->
        <section class="py-5">
            <div class="container my-5">
                <div class="row justify-content-center">
                    <div class="col-lg-6">
                        <h2>Oferta</h2>
                        <p class="lead">Flota pojazdów dostosowana do Twoich potrzeb.</p>
                        <p class="my-1">Posiadamy szeroki wybór pojazdów, w zależności od liczby osób i indywidualnych
                            preferencji klienta</p>
                        <ul class="list-group my-2">
                            <li class="list-group-item">NEOPLAN Euroliner 51+1</li>
                            <li class="list-group-item">RENAULT Carrier 35+25</li>
                            <li class="list-group-item">VOLKSWAGEN LT 19+5</li>
                            <li class="list-group-item">MERCEDES Sprinter 19+5</li>
                            <li class="list-group-item">MERCEDES Sprinter 19+4</li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <!-- Footer-->
    <footer class="py-5 bg-dark">
        <div class="container">
            <p class="m-0 text-center text-white">Copyright &copy; KM 2021</p>
        </div>
    </footer>
    <!-- Bootstrap core JS-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Core theme JS-->
    <script src="js/scripts.js"></script>
</body>

</html>