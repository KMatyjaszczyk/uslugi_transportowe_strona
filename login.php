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
            <a class="navbar-brand" href="#!"><img class="img-fluid" src="img/logo-male.png"> Usługi Transportowe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link active" aria-current="page" href="index.php">O nas</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeria.php">Galeria</a></li>
                    <li class="nav-item"><a class="nav-link" href="rezerwacja.php">Rezerwacja</a></li>
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
        <div class="mx-xl-5 mx-lg-5 px-xl-5 px-lg-5">
            <div class="mx-xl-5 mx-lg-5 px-xl-5 px-lg-5">
                <div class="mx-xl-5 mx-lg-5 px-xl-5 px-lg-5">
                    <!-- Header -->
                    <section class="py-5">
                        <div class="mt-5">
                            <div class="container">
                                <h2>Zaloguj się</h2>
                            </div>
                        </div>
                    </section>
                    <!-- Form -->
                    <div class="mx-5 mb-5">
                        <form action="processLogin.php" method="post">
                            <!-- Login -->
                            <label for="login" class="form-label mb-2">Login</label>
                            <input type="text" class="form-control mb-3" id="login" name="login" placeholder="Login">
                            <!-- password -->
                            <label for="password" class="form-label mb-2">Hasło</label>
                            <input type="text" class="form-control mb-3" id="password" name="password" placeholder="Hasło">
                            <!-- submit -->
                            <div class="row"></div>
                            <input type="submit" id="login" name="login" value="Zaloguj się" class="btn btn-primary mt-3">
                        </form>
                    </div>
                </div>
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
    <script src="js/scripts.js"></script>
</body>

</html>