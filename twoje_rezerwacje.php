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

if (!$isUserLoggedIn || $user->getIsAdmin() == true) {
    header('Location: index.php?status=reservationsDisplayForbidden');
}

// Retrieve user's orders
$orders = $orderService->getByUserId($user->getId());
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
    echo "<br>";
    echo 'orders: ';
    var_dump($orders);
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
                    <li class="nav-item"><a class="nav-link" href="rezerwacja.php">Rezerwacja</a></li>
                    <li class="nav-item"><a class="nav-link active" href="twoje_rezerwacje.php">Twoje rezerwacje</a></li>
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
                ?>
                <!-- Reservations display -->
                <div class="mx-5 mb-5">
                    <?php
                    if ($orders === null) {
                        echo '<div class="mt-2">Nie dokonano jeszcze żadnych rezerwacji</div>';
                    } else {
                        $table = '<div class="mt-2 table-responsive">';
                            $table .= '<table class="table">';
                                $table .= '<thead> <tr> <th>#</th> <th>Rezerwujący</th> <th>Cel podróży</th> <th>Data wyjazdu</th> <th>Status</th> <th></th> </tr> </thead>';
                                foreach ($orders as $orderKey => $order) {
                                    $table .= '<tr>';
                                        $table .= '<td>';
                                            $table .= $orderKey + 1;
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getClientName();
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getDestination();
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $order->getDepartureDate()->format('d-m-Y H:i');
                                        $table .= '</td>';
                                        $table .= '<td>';
                                            $table .= $orderService->mapStatusToText($order->getStatus());
                                        $table .= '</td>';
                                        $table .= '<td>';
                                        if ($order->getStatus() !== Order::$STATUS_CANCELLED && $order->getStatus() !== Order::$STATUS_REALISED) {
                                            $table .= '<a href="changeReservationStatus.php?status=2&orderId='. $order->getId() .'" class="btn btn-danger">Anuluj</a>';
                                        }
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