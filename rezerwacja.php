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
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" aria-current="page" href="index.php">O nas</a></li>
                    <li class="nav-item"><a class="nav-link" href="galeria.php">Galeria</a></li>
                    <li class="nav-item"><a class="nav-link active" href="rezerwacja.php">Rezerwacja</a></li>
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
                    <!-- Okno do błędów-->
                    <div class="alert alert-danger text-center fixed-top invisible" id="blad" role="alert">
                        <strong>Niepoprawne dane!</strong>
                    </div>
                    <!-- Okno do sukcesu po dodaniu rezerwacji-->
                    <div class="alert alert-success text-center fixed-top invisible" id="sukcesDodanie" role="alert">
                        <strong>Pomyślnie dokonano rezerwacji!</strong>
                    </div>
                    <!-- Okno do ostrzeżenia, że lista jest pusta przy wyświetlaniu-->
                    <div class="alert alert-warning text-center fixed-top invisible" id="ostrzezenieListaPusta"
                        role="alert">
                        <strong>Nie dokonano żadnych rezerwacji!</strong>
                    </div>
                    <!-- Okno do komunikatu o poprawnej edycji-->
                    <div class="alert alert-success text-center fixed-top invisible" id="sukcesEdycja" role="alert">
                        <strong>Pomyślnie edytowano rezerwację!</strong>
                    </div>
                    <!-- Imię i nazwisko-->
                    <label for="nazw" class="form-label mb-2">Imię i nazwisko lub nazwa firmy</label>
                    <input type="text" class="form-control mb-3" id="nazw" placeholder="Imię i nazwisko (nazwa firmy)">
                    <!-- Email-->
                    <label for="email" class="form-label mb-2">Adres email</label>
                    <input type="email" class="form-control mb-3" id="email" placeholder="Email">
                    <!-- Data i czas-->
                    <div class="row">
                        <div class="col">
                            <label for="data" class="form-label mb-2">Data wyjazdu</label>
                            <input type="date" class="form-control mb-3" id="data">
                        </div>
                        <div class="col">
                            <label for="godzina" class="form-label mb-2">Godzina</label>
                            <input type="time" class="form-control mb-3" id="godzina">
                        </div>
                    </div>
                    <!-- Miejscowość-->
                    <label for="miejsce" class="form-label mb-2">Cel podróży</label>
                    <input type="text" class="form-control mb-3" id="miejsce" placeholder="Miejscowość">
                    <!-- Forma-->
                    <div class="row">
                        <span class="form-label mb-2">Forma podróży</span>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="forma" id="forma1" value="wesele">
                        <label for="forma1" class="form-check-label">Wesele</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="forma" id="forma2" value="pogrzeb">
                        <label for="forma2" class="form-check-label">Pogrzeb</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="forma" id="forma3" value="wycieczka">
                        <label for="forma3" class="form-check-label">Wycieczka</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="forma" id="forma4" value="pielgrzymka">
                        <label for="forma4" class="form-check-label">Pielgrzymka</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="radio" class="form-check-input" name="forma" id="forma5" value="inna">
                        <label for="forma5" class="form-check-label">Inna</label>
                    </div>
                    <!-- Autobus-->
                    <div class="row mt-3">
                        <label for="autobus" class="form-label">Autobus</label>
                    </div>
                    <select class="form-control form-select mb-3" id="autobus">
                        <option value="neoplan">NEOPLAN Euroliner 51+1</option>
                        <option value="renault">RENAULT Carrier 35+25</option>
                        <option value="volkswagen">VOLKSWAGEN LT 19+5</option>
                        <option value="mercedesI">MERCEDES Sprinter 19+5</option>
                        <option value="mercedesII">MERCEDES Sprinter 19+4</option>
                    </select>
                    <!-- Dudatkowe usługi-->
                    <div class="row">
                        <span class="form-label mb-2">Dodatkowe usługi</span>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="uslugi" id="usluga1" value="bufet">
                        <label for="usluga1" class="form-check-label">Bufet</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="uslugi" id="usluga2" value="kierowcy">
                        <label for="usluga2" class="form-check-label">Dwóch kierowców</label>
                    </div>
                    <div class="form-check form-check-inline">
                        <input type="checkbox" class="form-check-input" name="uslugi" id="usluga3" value="naglosnienie">
                        <label for="usluga3" class="form-check-label">Zestaw nagłaśniający</label>
                    </div>
                    <!-- Rezerwacja-->
                    <div class="row"></div>
                    <button class="btn btn-primary mt-3" id="rezerwacja">Rezerwuj</button>
                    <button class="btn btn-secondary mt-3" id="czyszczenie">Wyczyść</button>
                    <button class="btn btn-secondary mt-3 invisible" id="potwierdzEdycje">Potwierdź edycję</button>
                    <!-- Przyciski do zarządzania rezerwacjami-->
                    <div class="row"></div>
                    <button class="btn btn-dark mt-3" id="wyswietlListe">Wyświetl rezerwacje</button>
                </div>
                <!-- Lista rezerwacji-->
                <div class="mx-5 mb-5" id="listaRezerwacji"></div>
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