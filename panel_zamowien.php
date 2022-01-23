<?php
include_once 'classes/LoggedInUserService.php';
include_once 'classes/UserService.php';
include_once 'classes/UserManager.php';
include_once 'classes/OrderService.php';
include_once 'classes/Order.php';

$loggedInUserService = new LoggedInUserService();
$userService = new UserService();
$userManager = new UserManager();
$orderService = new OrderService();

$sessionId = $userManager->retrieveSessionId();
$isUserLoggedIn = $userManager->isUserLoggedIn($sessionId);
$user = null;
if ($isUserLoggedIn) {
    $user = $userService->getById(
        $loggedInUserService->getBySessionId($sessionId)->getUserId()
    );
}

if (!$isUserLoggedIn || $user->getIsAdmin() === false) {
    header('Location: index.php?status=orderPanelForbidden');
}

$orders = null;
if (isset($_POST['submit']) && $_POST['submit'] === 'Szukaj') {
    $validationArguments = [
        'search' => FILTER_SANITIZE_ADD_SLASHES
    ];
    $filteredData = filter_input_array(INPUT_POST, $validationArguments);
    $errors = "";
    foreach ($filteredData as $key => $value) {
        if ($value === false or $value === null) {
            $errors .= $key . " ";
        }
    }
    if ($errors === "") {
        $clientNameOrDestination = $filteredData['search'];
        $orders = $orderService->getByClientNameOrDestination($clientNameOrDestination);
    } else {
        $orders = $orderService->getAll();
    }   
} else {
    $orders = $orderService->getAll();
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
    <!-- Responsive navbar-->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="index.php"><img class="img-fluid" src="img/logo-male.png"> Usługi
                Transportowe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="index.php">O nas</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeria.php">Galeria</a></li>
                    <li class="nav-item"><a class="nav-link active" href="panel_zamowien.php">Panel zamówień</a></li>
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
                            <h2>Twoje rezerwacje</h2>
                        </div>
                    </div>
                </section>
                <?php
                if (isset($_GET['changeReservationStatusResult']) && $_GET['changeReservationStatusResult'] === 'success') {
                    echo '
                    <div class="mx-5 mb-3">
                        <span class="text-success">Zmieniono status zamówienia</span>
                    </div>
                    ';
                } 
                if (isset($_GET['deleteReservationResult']) && $_GET['deleteReservationResult'] === 'success') {
                    echo '
                    <div class="mx-5 mb-3">
                        <span class="text-success">Usunięto zamówienie</span>
                    </div>
                    ';
                }
                ?>
                <!-- Search panel -->
                <div class="mx-5 mb-3">
                    <div class="row">
                    <form action="panel_zamowien.php" method="post">
                        <input type="text" name="search" class="form-control mb-3"
                            placeholder="Wyszukaj po rezerwującym lub celu podróży">
                        <input type="submit" name="submit" value="Szukaj" class="btn btn-primary">
                        <a href="panel_zamowien.php" class="btn btn-secondary">Wszystkie</a>
                    </form>
                    </div>
                </div>
                <!-- Reservations display -->
                <div class="mx-5 mb-5">
                    <?php
                    if ($orders === null) {
                        echo '<div class="mt-2">Nie znaleziono rezerwacji</div>';
                    } else {
                        $table = '<div class="mt-2 table-responsive">';
                            $table .= '<table class="table table-hover">';
                                $table .= '
                                <thead> 
                                    <tr> 
                                        <th>ID</th> 
                                        <th>Rezerwujący</th> 
                                        <th>Email</th> 
                                        <th>Data wyjazdu</th>
                                        <th>Cel podróży</th>
                                        <th>Rodzaj</th>
                                        <th>Pojazd</th>
                                        <th>Dodatkowe usługi</th>
                                        <th>Status</th> 
                                        <th>Data utworzenia</th>
                                        <th>Data ost. aktualizacji</th>
                                        <th></th> 
                                    </tr> 
                                </thead>';
                                foreach ($orders as $orderKey => $order) {
                                    $table .= '<tr>';
                                        $table .= '<td>';
                                            $table .= $order->getId();
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getClientName();
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getClientEmail();
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getDepartureDate()->format('d-m-Y H:i');
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getDestination();
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getJourneyForm();
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getVehicle();
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= implode(", ", $order->getAdditionalServices());
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $orderService->mapStatusToText($order->getStatus());
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getCreationDate() !== null ? $order->getCreationDate()->format('d-m-Y H:i') : '';
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getLastUpdatedDate() !== null ? $order->getLastUpdatedDate()->format('d-m-Y H:i') : '';
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= '<a href="changeReservationStatus.php?status='. Order::$STATUS_CANCELLED .'&orderId='. $order->getId() .'" class="btn btn-secondary btn-sm">&nbsp;&nbsp;Anuluj&nbsp;&nbsp;</a>';
                                            $table .= '<a href="changeReservationStatus.php?status='. Order::$STATUS_ACCEPTED .'&orderId='. $order->getId() .'" class="btn btn-primary btn-sm">Akceptuj</a>';
                                            $table .= '<a href="changeReservationStatus.php?status='. Order::$STATUS_REALISED .'&orderId='. $order->getId() .'" class="btn btn-success btn-sm">Zakończ&nbsp;</a>';
                                            $table .= '<a href="deleteReservation.php?orderId='. $order->getId() .'" class="btn btn-danger btn-sm">&nbsp;&nbsp;&nbsp;Usuń&nbsp;&nbsp;&nbsp;</a>';
                                        $table .= '</td>';
                                    $table .= '</tr>';
                                }
                            $table .= '</table>';
                        $table .= '</div>';
                        echo $table;
                    }

                    ?>
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
</body>

</html>