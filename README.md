# startSAW21
Progetto di SAW 2021/22

## Componenti:
- Miggiano Davide
- Manini Filippo

## Update Note:

### 2.1.0
- Rimosso link a "Forgot Password"
- Rimosso commento in Footer.php
- Piccole modifiche di UI in crowdfunding.php
- Aggiunto messaggio per ricerca senza successo in searchPage.php

### 2.1.1
- Rimossa session_unset() perché deprecata da logout.php

### 2.1.2
- Rimossa funzione redirectDelay() da common.php 
- Rimosso controllo superamento soglia massima di donazione update_donation.php
- Arrotondamento barra di donazione crowdfunding.php
- Rimosso script non funzionante di "delete" shopping_cart.php

### 2.1.3
- Aggiunta espressione regolare per controllo formato numero di telefono in show_profile.php
- Aggiunto messaggio di errore in caso si inserisse una mail già esistente in show_profile.php
- Aggiunto controllo lunghezza e caratteri della password durante la registrazione registration.php, style.css, password.js

### 2.1.4
- Modifica allo stile di #message {display:none; ...} in style.css

### 2.1.5
- Aggiunto controllo su operazione bind() in checkEmail.php , registration.php , update_donation.php , update_profile.php
- Modificata icona sito
- Aggiunte Store Procedure in index.php, searchPage.php e shopping_cart.php