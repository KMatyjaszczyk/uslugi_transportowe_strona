// ZMIENNE GLOBALNE
// definicje elementów z formularza
const nazw = document.getElementById("nazw");
const email = document.getElementById("email");
const data = document.getElementById("data");
const godzina = document.getElementById("godzina");
const miejsce = document.getElementById("miejsce");
const forma = document.getElementsByName("forma");
const autobus = document.getElementById("autobus");
const uslugi = document.getElementsByName("uslugi");
// przyciski
const btnRezerwacja = document.getElementById("rezerwacja");
const btnCzyszczenie = document.getElementById("czyszczenie");
// lista rezerwacji
const btnWyswietlListe = document.getElementById("wyswietlListe");
const listaRezerwacji = document.getElementById("listaRezerwacji");
// edycja pozycji z listy rezerwacji
const btnPotwierdzEdycje = document.getElementById("potwierdzEdycje");

// definicje wyrażeń regularnych
const patternNazw = /^[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż][A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż \.\&\-]{2,}$/;
const patternEmail = /^([a-zA-Z0-9])+([.a-zA-Z0-9_-])*@([a-zA-Z0-9_-])+(.[a-zA-Z0-9_-]+)+/;
const patternMiejsce = /^[A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż][A-ZĄĆĘŁŃÓŚŹŻa-ząćęłńóśźż \.\-]{2,}$/;

// FUNKCJE
// funkcje do wizualnej walidacji elementów tekstowych
function sprawdzTekst(pole, regExp) {
    if (regExp.test(pole.value)) {
        pole.classList.remove("is-invalid");
        pole.classList.add("is-valid")
    } else {
        pole.classList.remove("is-valid");
        pole.classList.add("is-invalid");
    }
}
// funkcja do wizualnej walidacji daty (czy nie rezerwujemy z przeszłości)
function sprawdzDateWizualnie() {
    let dataZm = new Date(data.value);
    let dataDzisiaj = new Date();
    if (dataZm.getTime() <= dataDzisiaj.getTime()) {
        data.classList.remove("is-valid");
        data.classList.add("is-invalid");
    } else {
        data.classList.remove("is-invalid");
        data.classList.add("is-valid");
    }
}
// funkcja do czyszczenia danych w formularzu
function wyczyscFormularz() {
    // czyścimy wartości wszystkich pół
    nazw.value = "";
    email.value = "";
    data.value = "";
    godzina.value = "";
    miejsce.value = "";
    forma.forEach((radio) => radio.checked = false);
    autobus.value = "";
    uslugi.forEach((checkbox) => checkbox.checked = false);
    // zdejmujemy wizualną walidację elementów
    nazw.classList.remove("is-invalid");
    nazw.classList.remove("is-valid");
    email.classList.remove("is-invalid");
    email.classList.remove("is-valid");
    data.classList.remove("is-invalid");
    data.classList.remove("is-valid");
    godzina.classList.remove("is-valid");
    miejsce.classList.remove("is-invalid");
    miejsce.classList.remove("is-valid");
    autobus.classList.remove("is-valid");
}


// DZIAŁANIA NA LOCAL STORAGE - DO WYRZUCENIA, NALEŻY JEDYNIE NAPISAĆ FUNKCJĘ SPRAWDZAJĄCĄ, CZY WSZYSTKIE POLA SĄ W PORZĄDKU POD WZGLĘDEM WALIDACJI 

// WYŚWIETLENIE LISTY REZERWACJI Z LOCALSTORAGE
// jeżeli lista jest pusta, wyświetlamy stosowny komunikat
function wyswietl() {
    // pobranie listy z localStorage
    let lista = JSON.parse(localStorage.getItem("rezerwacje"));
    // sprawdzenie, czy lista jest pusta
    if (lista === null || lista.length === 0) {
        const ostrzezenie = document.getElementById("ostrzezenieListaPusta");
        ostrzezenie.classList.remove("invisible");
        setTimeout(() => {
            ostrzezenie.classList.add("invisible");
        }, 3000);
    } else { // jeżeli lista nie jest pusta, tworzymy tabelę z rezerwacjami
        // utworzenie tabeli i nagłówka
        let tabela = '<div class="mt-2"> <div class="container"> <h3>Lista rezerwacji</h3> </div> </div>';
        tabela += '<table class="table"> <thead> <tr> <th>#</th> <th>Rezerwujący</th> <th>Opis</th> <th></th> </tr> </thead>';
        // wyświetlanie danych w komórkach
        for (let i = 0; i < lista.length; i++) {
            tabela += '<tr>';
            tabela += '<td>' + (i + 1) + '</td>';
            tabela += '<td>' + lista[i].nazw + '</td>';
            tabela += '<td>' + lista[i].data + ', ' + lista[i].miejsce + ', ' + lista[i].forma + '</td>';
            tabela += '<td><button class="btn btn-dark btn-sm" onclick="usun(' + i + ')">&nbsp;Usuń&nbsp;</button> ';
            tabela += '<button class="btn btn-secondary btn-sm" onclick="edytuj(' + i + ')">Edytuj</button></td>';
            tabela += '</tr>';
        }
        tabela += '</table>';
        // umieszczenie tabeli na stronie
        listaRezerwacji.innerHTML = tabela;
    }
}
// WPROWADZENIE DANYCH DO LOCALSTORAGE
// sprwadzenie poprawności danych - jeżeli się nie uda wyświetlamy komunikat,
// jeżeli się uda, pakujemy obiekt rezerwacji do listy JSON
function dodajRezerwacje() {
    // zmienne wykorzystywane przy sprawdzaniu danych
    let formPoprawny = true; // główna zmienna sprawdzająca, czy formularz jest poprawny
    let dataFor = new Date(data.value);
    let dataDzis = new Date();
    // sprawdzamy wszystkie pola formularza pod względem poprawności
    if (!patternNazw.test(nazw.value) ||
        !patternEmail.test(email.value) ||
        dataFor.getTime() <= dataDzis.getTime() ||
        !patternMiejsce.test(miejsce.value) ||
        autobus.value === "") {
        formPoprawny = false;
    }
    // sprawdzamy, czy chociaż jedno pole radio zostało zatwierdzone
    let radioPoprawne = false;
    forma.forEach((radio) => {
        if (radio.checked) radioPoprawne = true;
    });
    // jeżeli formularz jest poprawny - tworzymy obiekt JSON i pakujemy go do listy
    // na localStorage
    if (formPoprawny && radioPoprawne) {
        // komunikat do poprawnego wprowadzenia danych
        const sukces = document.getElementById("sukcesDodanie");
        sukces.classList.remove("invisible");
        setTimeout(() => {
            sukces.classList.add("invisible");
        }, 3000);
        // utworzenie/pobranie listy
        let lista = JSON.parse(localStorage.getItem("rezerwacje"));
        if (lista === null) lista = [];
        // utworzenie obiektu rezerwacji
        let rezerwacja = {};
        rezerwacja.nazw = nazw.value;
        rezerwacja.email = email.value;
        rezerwacja.data = data.value;
        rezerwacja.godzina = godzina.value;
        rezerwacja.miejsce = miejsce.value;
        forma.forEach((radio) => { if (radio.checked) rezerwacja.forma = radio.value; });
        rezerwacja.autobus = autobus.value;
        if (uslugi[0].checked) rezerwacja.bufet = uslugi[0].value;
        else rezerwacja.bufet = null;
        if (uslugi[1].checked) rezerwacja.kierowcy = uslugi[1].value;
        else rezerwacja.kierowcy = null;
        if (uslugi[2].checked) rezerwacja.naglosnienie = uslugi[2].value;
        else rezerwacja.naglosnienie = null;
        // dodanie obiektu do listy rezerwacji
        lista.push(rezerwacja);
        localStorage.setItem("rezerwacje", JSON.stringify(lista));
        // wyczyszczenie formularza
        wyczyscFormularz();
    } else { // jeżeli formularz jest niepoprawny - wyświetlamy komunikat
        const blad = document.getElementById("blad");
        blad.classList.remove("invisible");
        setTimeout(() => {
            blad.classList.add("invisible");
        }, 3000);
    }
}
// USUNIĘCIE POJEDYNCZEGO ELEMENTU Z LISTY
function usun(pozycja) {
    // pobranie listy z local storage
    let lista = JSON.parse(localStorage.getItem("rezerwacje"));
    // usunięcie elementu, wrzucenie listy do localStorage
    if (confirm("Na pewno usunąć " + lista[pozycja].forma + "?")) lista.splice(pozycja, 1);
    localStorage.setItem("rezerwacje", JSON.stringify(lista));
    // zaktualizowanie widoku
    wyswietl();
}
// EDYCJA POJEDYNCZEGO ELEMENTU Z LISTY
function edytuj(pozycja) {
    // pobranie listy z local storage
    let lista = JSON.parse(localStorage.getItem("rezerwacje"));
    obiekt = lista[pozycja];
    // wrzucenie danych z listy do formularza
    nazw.value = obiekt.nazw;
    email.value = obiekt.email;
    data.value = obiekt.data;
    godzina.value = obiekt.godzina;
    miejsce.value = obiekt.miejsce;
    autobus.value = obiekt.autobus;
    forma.forEach((radio) => {
        if (radio.value === obiekt.forma) radio.checked = true;
    })
    if (obiekt.bufet !== null) uslugi[0].checked = true;
    else uslugi[0].checked = false;
    if (obiekt.kierowcy !== null) uslugi[1].checked = true;
    else uslugi[1].checked = false;
    if (obiekt.naglosnienie !== null) uslugi[2].checked = true;
    else uslugi[2].checked = false;
    // schowanie przycisków, wyciągnięcie do edycji
    btnRezerwacja.classList.remove("visible");
    btnRezerwacja.classList.add("invisible");
    btnCzyszczenie.classList.remove("visible");
    btnCzyszczenie.classList.add("invisible");
    btnWyswietlListe.classList.remove("visible");
    btnWyswietlListe.classList.add("invisible");
    btnPotwierdzEdycje.classList.remove("invisible");
    btnPotwierdzEdycje.classList.add("visible");
    // schowanie listy rezerwacji
    listaRezerwacji.innerHTML = "";
    // wizualne sprawdzenie pół
    sprawdzTekst(nazw, patternNazw);
    sprawdzTekst(email, patternEmail);
    sprawdzTekst(miejsce, patternMiejsce);
    sprawdzDateWizualnie();
    godzina.classList.add("is-valid");
    autobus.classList.add("is-valid");
    // wciśnięcie przycisku do edycji spowoduje walidację formularza
    // oraz zmianę danych w obiekcie JSON
    btnPotwierdzEdycje.onclick = function () {
        // zmienne wykorzystywane przy sprawdzaniu danych
        let formPoprawny = true; // główna zmienna sprawdzająca, czy formularz jest poprawny
        let dataFor = new Date(data.value);
        let dataDzis = new Date();
        // sprawdzamy wszystkie pola formularza pod względem poprawności
        if (!patternNazw.test(nazw.value) ||
            !patternEmail.test(email.value) ||
            dataFor.getTime() <= dataDzis.getTime() ||
            !patternMiejsce.test(miejsce.value) ||
            autobus.value === "") {
            formPoprawny = false;
        }
        // sprawdzamy, czy chociaż jedno pole radio zostało zatwierdzone
        let radioPoprawne = false;
        forma.forEach((radio) => {
            if (radio.checked) radioPoprawne = true;
        });
        // jeżeli wszystko jest poprawne, podmieniamy dane w obiekcie
        if (formPoprawny && radioPoprawne) {
            lista[pozycja].nazw = nazw.value;
            lista[pozycja].email = email.value;
            lista[pozycja].data = data.value;
            lista[pozycja].godzina = godzina.value;
            lista[pozycja].miejsce = miejsce.value;
            forma.forEach((radio) => { if (radio.checked) lista[pozycja].forma = radio.value; });
            lista[pozycja].autobus = autobus.value;
            if (uslugi[0].checked) lista[pozycja].bufet = uslugi[0].value;
            else lista[pozycja].bufet = null;
            if (uslugi[1].checked) lista[pozycja].kierowcy = uslugi[1].value;
            else lista[pozycja].kierowcy = null;
            if (uslugi[2].checked) lista[pozycja].naglosnienie = uslugi[2].value;
            else lista[pozycja].naglosnienie = null;
            // pakujemy listę do localStorage
            localStorage.setItem("rezerwacje", JSON.stringify(lista));
            // aktualizujemy widok
            wyswietl();
            // czyścimy formularz
            wyczyscFormularz();
            // wydajemy komunikat
            const sukces = document.getElementById("sukcesEdycja");
            sukces.classList.remove("invisible");
            setTimeout(() => {
                sukces.classList.add("invisible");
            }, 3000);
            // przywracamy poprzednie przyciski
            btnRezerwacja.classList.remove("invisible");
            btnRezerwacja.classList.add("visible");
            btnCzyszczenie.classList.remove("invisible");
            btnCzyszczenie.classList.add("visible");
            btnWyswietlListe.classList.remove("invisible");
            btnWyswietlListe.classList.add("visible");
            btnPotwierdzEdycje.classList.remove("visible");
            btnPotwierdzEdycje.classList.add("invisible");
        } else { // jeżeli dane się niepoprawne, wydajemy komunikat
            const blad = document.getElementById("blad");
            blad.classList.remove("invisible");
            setTimeout(() => {
                blad.classList.add("invisible");
            }, 3000);
        }
    }
}

// DODANIE LISTENERÓW
if (nazw !== null && email !== null && miejsce !== null && data !== null &&
    godzina !== null && autobus !== null && btnRezerwacja !== null &&
    btnCzyszczenie !== null && btnRezerwacja !== null) {
    nazw.addEventListener("input", () => sprawdzTekst(nazw, patternNazw));
    email.addEventListener("input", () => sprawdzTekst(email, patternEmail));
    miejsce.addEventListener("input", () => sprawdzTekst(miejsce, patternMiejsce));
    data.addEventListener("change", sprawdzDateWizualnie);
    godzina.addEventListener("change", () => godzina.classList.add("is-valid"));
    autobus.addEventListener("change", () => autobus.classList.add("is-valid"));
    btnRezerwacja.addEventListener("click", dodajRezerwacje);
    btnCzyszczenie.addEventListener("click", wyczyscFormularz);
    btnWyswietlListe.addEventListener("click", wyswietl);
}

