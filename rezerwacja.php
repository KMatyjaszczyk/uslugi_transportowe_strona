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

if (!$isUserLoggedIn || $user->getIsAdmin() == true) {
    header('Location: index.php?status=reservationForbidden');
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
            <a class="navbar-brand" href="index.php"><img class="img-fluid" src="img/logo-male.png"> Usługi
                Transportowe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">O nas</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeria.php">Galeria</a></li>
                    <li class="nav-item"><a class="nav-link active" href="rezerwacja.php">Rezerwacja</a></li>
                    <li class="nav-item"><a class="nav-link" href="twoje_rezerwacje.php">Twoje rezerwacje</a></li>
                    <li class="nav-item"><a class="nav-link text-info" href="processLogin.php?process=logout">Wyloguj</a></li>
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
        <div class="mx-xl-5 px-xl-5">
            <div class="mx-xl-5 px-xl-5">
                <!-- Content section-->
                <section class="py-5">
                    <div class="mt-5">
                        <div class="container">
                            <h2>Zarezerwuj autobus</h2>
                        </div>
                    </div>
                </section>
                <!-- Form-->
                <div class="mx-5 mb-5">
                    <form action="processReservation.php" method="post">
                        <!-- Client name-->
                        <label for="clientName" class="form-label mb-2">Imię i nazwisko lub nazwa firmy</label>
                        <input type="text" class="form-control mb-3" id="clientName" name="clientName" placeholder="Imię i nazwisko (nazwa firmy)">
                        <!-- Client email-->
                        <label for="clientEmail" class="form-label mb-2">Adres email</label>
                        <input type="clientEmail" class="form-control mb-3" id="clientEmail" name="clientEmail" placeholder="Email">
                        <!-- Date time-->
                        <div class="row">
                            <div class="col">
                                <label for="departureDateDate" class="form-label mb-2">Data wyjazdu</label>
                                <input type="date" class="form-control mb-3" id="departureDateDate"  name="departureDateDate">
                            </div>
                            <div class="col">
                                <label for="departureDateTime" class="form-label mb-2">Godzina</label>
                                <input type="time" class="form-control mb-3" id="departureDateTime" name="departureDateTime">
                            </div>
                        </div>
                        <!-- Destination-->
                        <label for="destination" class="form-label mb-2">Cel podróży</label>
                        <input type="text" class="form-control mb-3" id="destination" name="destination" placeholder="Miejscowość">
                        <!-- Journey form-->
                        <div class="row">
                            <span class="form-label mb-2">Forma podróży</span>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="journeyForm" id="form1" value="wedding">
                            <label for="form1" class="form-check-label">Wesele</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="journeyForm" id="form2" value="funeral">
                            <label for="form2" class="form-check-label">Pogrzeb</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="journeyForm" id="form3" value="trip">
                            <label for="form3" class="form-check-label">Wycieczka</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="journeyForm" id="form4" value="pilgrimage">
                            <label for="form4" class="form-check-label">Pielgrzymka</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="radio" class="form-check-input" name="journeyForm" id="form5" value="other">
                            <label for="form5" class="form-check-label">Inna</label>
                        </div>
                        <!-- Vehicle-->
                        <div class="row mt-3">
                            <label for="autobus" class="form-label">Autobus</label>
                        </div>
                        <select class="form-control form-select mb-3" id="vehicle" name="vehicle">
                            <option value="neoplan">NEOPLAN Euroliner 51+1</option>
                            <option value="renault">RENAULT Carrier 35+25</option>
                            <option value="volkswagen">VOLKSWAGEN LT 19+5</option>
                            <option value="mercedesI">MERCEDES Sprinter 19+5</option>
                            <option value="mercedesII">MERCEDES Sprinter 19+4</option>
                        </select>
                        <!-- Additional services-->
                        <div class="row">
                            <span class="form-label mb-2">Dodatkowe usługi</span>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="additionalServices[]" id="service1" value="buffet">
                            <label for="service1" class="form-check-label">Bufet</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="additionalServices[]" id="service2" value="drivers">
                            <label for="service2" class="form-check-label">Dwóch kierowców</label>
                        </div>
                        <div class="form-check form-check-inline">
                            <input type="checkbox" class="form-check-input" name="additionalServices[]" id="service3" value="soundSystem">
                            <label for="service3" class="form-check-label">Zestaw nagłaśniający</label>
                        </div>
                        <!-- Rezerwacja-->
                        <div class="row"></div>
                        <input type="submit" class="btn btn-primary mt-3" id="reservation" value="Rezerwuj">
                        <input type="reset" class="btn btn-secondary mt-3" id="clean" value="Resetuj">
                    </form>
                </div>
            </div>
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
        <!-- <script src="js/scripts.js"></script> -->
</body>

</html>