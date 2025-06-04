<?php

const HOUR = 3600;
/**
 * Manages the interactions between PHP and the database.
 * It updates, adds, removes data into the database accordingly to the instructions given by the other PHP files.
 */
class DataBaseHelper
{
    private $db;

    public function __construct($servername, $username, $password, $dbname, $port)
    {
        $this->db = new mysqli($servername, $username, $password, $dbname, $port);
        if ($this->db->connect_error) {
            die("Connessione fallita al db");
        }
    }

    /**
     * Adds a new user (that is not a seller).
     * @param mixed $username
     * @param mixed $email
     * @param mixed $password
     * @return void
     */
    public function addUser($username, $email, $password)
    {
        $stmt = $this->db->prepare("INSERT INTO UTENTI (username, email, password, venditore) VALUES (?, ?, ?, 0)");
        $stmt->bind_param('sss', $username, $email, $password);
        $stmt->execute();
    }

    /**
     * Gets the given email, when present in the database.
     * @param mixed $email
     * @return array
     */
    public function getEmail($email)
    {
        $stmt=$this->db->prepare("SELECT email FROM UTENTI WHERE email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Checks whether the given user is a seller or not
     * @param mixed $user_id the ID of the user
     * @return bool true if the user is a seller, false otherwise
     */
    public function isSeller($user_id) {
        $stmt = $this->db->prepare(
            "SELECT venditore
            FROM utenti
            WHERE codUtente = ?"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return $result[0]["venditore"];
    }

    /**
     * Gets the given username, when present in the database.
     * @param mixed $username
     * @return array
     */
    public function getUsername($username)
    {
        $stmt=$this->db->prepare("SELECT username FROM UTENTI WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Gets the given username by email, when present in the database.
     * @param mixed $email
     * @return array
     */
    public function getUsernameByEmail($email)
    {
        $stmt=$this->db->prepare("SELECT username FROM UTENTI WHERE email=?");
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns the ID of the user which has the given username.
     * @param string $username
     * @return int the corresponding user ID
     */
    public function getUserID($username) {
        $stmt=$this->db->prepare("SELECT codUtente AS id FROM UTENTI WHERE username=?");
        $stmt->bind_param('s', $username);
        $stmt->execute();
        $result=$stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Sets the new password for the given user.
     * For security reasons, it actually saves a hash of the password, not the password itself.
     * @param mixed $userId
     * @param mixed $hash
     * @return void
     */
    public function setPassword($userId, $hash)
    {
        $stmt = $this->db->prepare("UPDATE `UTENTI` SET password=? WHERE codUtente=?");
        $stmt->bind_param('si', $hash, $userId);
        $stmt->execute();
    }

    /**
     * Returns the userID and the password belonging to the given username and email.
     * The returned array is empty when the combination of username and email is absent.
     * @param mixed $username
     * @param mixed $email
     * @return array
     */
    public function checkLogin($username, $email)
    {
        $stmt = $this->db->prepare("SELECT codUtente, password FROM UTENTI WHERE username=? AND email=?");
        $stmt->bind_param('ss', $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Puts the failed login attempt into the database.
     * @param mixed $id ID of the PHP session that called the function.
     * @param mixed $now Current time.
     * @return void
     */
    public function registerFailedAttempt($id, $now)
    {
        $stmt = $this->db->prepare("INSERT INTO failedloginattempts (PHPSESSID, logtime) VALUES (?, ?)");
        $stmt->bind_param('ss', $id, $now);
        $stmt->execute();
    }

    /**
     * Returns the list of the failed login attempts done in the given session.
     * @param mixed $id ID of the PHP session that called the function.
     * @param mixed $now Current time.
     * @return array
     */
    public function getFailedLoginAttempts($id, $now)
    {
        $attempts = $now - HOUR;
        $stmt = $this->db->prepare("SELECT logtime FROM failedloginattempts WHERE PHPSESSID=? AND logtime>?");
        $stmt->bind_param('ss', $id, $attempts);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Checks if a product with the specified ID exists in the database.
     * @param int $id The ID of the product
     * @return bool true if the product exists, false otherwise
     */
    public function productExists($id) {
        $stmt = $this->db->prepare(
            "SELECT codProdotto
            FROM prodotti
            WHERE codProdotto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        return count($result) != 0;
    }

    /**
     * Retrieves detailed informations about a single product, specified by its ID.
     * @param int $id the product's ID
     * @return array
     */
    public function getProductByID($id) {
        $stmt = $this->db->prepare(
            "SELECT P.codProdotto AS id, nome, immagine, descrizione, prezzo, quantita_disponibile, categoria, opera_di_appartenenza, altezza, larghezza, profondita, punteggio_medio,
            (SELECT COUNT(DISTINCT(codCliente)) FROM recensioni R WHERE R.codProdotto = P.codProdotto) AS num_recensioni, GROUP_CONCAT(genere SEPARATOR ', ') AS generi
            FROM prodotti P LEFT JOIN appartenenze_generi AG ON (P.codProdotto = AG.codProdotto)
            WHERE P.codProdotto = ?
            GROUP BY P.codProdotto, nome, immagine, descrizione, prezzo, quantita_disponibile, categoria, opera_di_appartenenza, altezza, larghezza, profondita, punteggio_medio");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns the name of the specified product.
     * @param int $id the ID of the product
     * @return array The array containing the product searched
     */
    public function getProductNameByID($id) {
        $stmt = $this->db->prepare(
            "SELECT codProdotto, nome
            FROM prodotti
            WHERE codProdotto = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns the available quantity of the specified product
     * @param int $product_id the ID of the product
     * @return array
     */
    public function getAvailableQuantityByProduct($product_id) {
        $stmt = $this->db->prepare(
            "SELECT codProdotto as id, quantita_disponibile
            FROM prodotti
            WHERE codProdotto = ?");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns the array containing the reviews of a specified product.
     * Doesn't retrieve reviews that don't have a description.
     * @param int $id the product's ID
     * @return array
     */
    public function getReviewsByProductID($product_id) {
        $stmt = $this->db->prepare(
            "SELECT punteggio, descrizione, data, username
            FROM recensioni R, utenti U
            WHERE R.codProdotto = ?
            AND R.codCliente = U.codUtente
            AND descrizione IS NOT NULL");
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns informations about the review written by the specified user for the specified product.
     * @param string $username the username of the user
     * @param string $product_id the ID of the product
     * @return array
     */
    public function getReviewByUsernameAndProductID($username, $product_id) {
        $stmt = $this->db->prepare(
            "SELECT punteggio, descrizione, data, username
            FROM recensioni R, utenti U
            WHERE R.codProdotto = ?
            AND U.username = ?
            AND R.codCliente = U.codUtente");
        $stmt->bind_param("is", $product_id, $username);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Adds a review by the specified user for a specific product.
     * @param string $user_id the ID of the user
     * @param int $product_id the ID of the product
     * @param int $rating the rating of the review
     * @param int $description the description of the review
     * @param int $data the date in which the review was written
     * @return bool True if the review was added, false otherwise
     */
    public function addReview($user_id, $product_id, $rating, $description, $date) {
        $stmt = $this->db->prepare(
            "INSERT INTO recensioni(codCliente, codProdotto, punteggio, descrizione, data)
            VALUES(?, ?, ?, ?, ?)");
        $stmt->bind_param("iiiss", $user_id, $product_id, $rating, $description, $date);
        return $stmt->execute();
    }

    /**
     * Modifies the review by the specified user for a specific product.
     * @param string $user_id the ID of the user
     * @param int $product_id the ID of the product
     * @param int $rating the new rating of the review
     * @param int $description the new description of the review
     * @param int $data the date in which the review was updated
     * @return bool True if the review was modified, false otherwise
     */
    public function modifyReview($user_id, $product_id, $rating, $description, $date) {
        $stmt = $this->db->prepare(
            "UPDATE recensioni
            SET punteggio = ?, descrizione = ?, data = ?
            WHERE codCliente = ?
            AND codProdotto = ?");
        $stmt->bind_param("issii", $rating, $description, $date, $user_id, $product_id);
        return $stmt->execute();
    }

    /**
     * Updates the medium rating of the given product.
     * @param int $product_id the ID of the product
     * @return bool True if the operation was successful, false otherwise
     */
    public function updateMediumRating($product_id) {
        $stmt = $this->db->prepare(
            "UPDATE prodotti
            SET punteggio_medio = (SELECT AVG(punteggio)
                                    FROM recensioni R
                                    WHERE R.codProdotto = ?)
            WHERE codProdotto = ?");
        $stmt->bind_param("ii", $product_id, $product_id);
        return $stmt->execute();
    }

    /**
     * Returns an array containing the previews of the most sold products in the database.
     * @param int $num Number of products to retrieve from the database. The default is 20.
     * @return array
     */
    public function getMostSoldProducts($num = 20)
    {
        $stmt = $this->db->prepare(
            "SELECT C.codProdotto AS id, nome, immagine, prezzo, categoria, SUM(C.quantita) AS numVendite
            FROM composizioni C, prodotti P
            WHERE C.codProdotto = P.codProdotto
            AND quantita_disponibile > 0
            GROUP BY C.codProdotto, nome, immagine, prezzo, categoria
            ORDER BY numVendite DESC
            LIMIT ?");
        $stmt->bind_param("i", $num);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns an array containing the previews of the most recently added products.
     * @param int $num Number of products to retrieve from the database. The default is 20.
     * @return array
     */
    public function getMostRecentProducts($num = 20) {
        $stmt = $this->db->prepare(
            "SELECT codProdotto AS id, nome, immagine, prezzo, categoria
            FROM prodotti
            WHERE quantita_disponibile > 0
            ORDER BY data_inserimento DESC
            LIMIT ?");
        $stmt->bind_param("i", $num);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns an array containing the previews of the most popular products.
     * "most popular" refers to the products which have the highest rating and the highest number
     * of reviews.
     * 
     * NOTE: this function doesn't do exactly that. Instead it sorts the products based on the ratings and, on equal ratings,
     * sorts based on the number of reviews.
     * @param int $num Number of products to retrieve from the database. The default is 20.
     * @return array
     */
    public function getMostPopularProducts($num = 20) {
        $stmt = $this->db->prepare(
            "SELECT P.codProdotto AS id, nome, immagine, prezzo, categoria, punteggio_medio, COUNT(*) as num_recensioni
            FROM prodotti P, recensioni R
            WHERE P.codProdotto = R.codProdotto
            AND quantita_disponibile > 0
            GROUP BY P.codProdotto, nome, immagine, prezzo, categoria, punteggio_medio
            ORDER BY punteggio_medio DESC, num_recensioni DESC
            LIMIT ?");
        $stmt->bind_param("i", $num);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns an array of all the categories stored in the database.
     * @return array
     */
    public function getCategories() {
        $stmt = $this->db->prepare(
            "SELECT nome
            FROM categorie"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns an array of all the genres stored in the database.
     * @return array
     */
    public function getGenres() {
        $stmt = $this->db->prepare(
            "SELECT nome
            FROM generi"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Inserts the given genre in the database.
     * @param string $genre the genre to be added
     * @return bool True if the operation was successful, false otherwise
     */
    public function addGenre($genre) {
        $stmt = $this->db->prepare(
            "INSERT INTO Generi (nome)
            VALUES (?)"
        );
        $stmt->bind_param("s", $genre);
        try {
            return $stmt->execute();
        } catch (\Throwable $th) {
            return false;
        }
    }

    /**
     * Returns all the products contained inside the shopping cart of a specific user.
     * @param int the id of the user of interest.
     * @return array
     */
    public function getProductInTheCart($user_id) {
        $stmt = $this->db->prepare(
            "SELECT P.codProdotto, P.nome, P.immagine, P.prezzo, P.quantita_disponibile, Cr.quantita
            FROM utenti C, prodotti P, carrello Cr
            WHERE C.codUtente = ?
            AND Cr.codCliente = C.codUtente
            AND Cr.codProdotto = P.codProdotto"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns if the product is contained inside the shopping cart of a specific user.
     * If the product exists, also returns the quantity specified in the cart.
     * @param int the id of the user.
     * @param int the id of the product.
     * @return array
     */
    public function isProductInTheCart($user_id, $product_id) {
        $stmt = $this->db->prepare(
            "SELECT codProdotto, quantita
            FROM carrello
            WHERE codCliente = ?
            AND codProdotto = ?"
        );
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns all the genres of a product.
     * @param int the id of the product of interest.
     * @return array
     */
    public function getGenresByProductID($product_id) {
        $stmt = $this->db->prepare(
            "SELECT genere
            FROM appartenenze_generi
            WHERE codProdotto = ?"
        );
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Add a new product in the shopping cart of a user.
     * @param int $user_id
     * @param int $product_id
     * @param int $quantita 
     */
    public function insertNewProductInTheCart($user_id, $product_id, $quantita) {
        $stmt = $this->db->prepare(
            "INSERT INTO Carrello  (codProdotto, codCliente, quantita)
            VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iii", $product_id, $user_id, $quantita);
        $stmt->execute();
    }

    /**
     * Update quantity of a product in a user's shopping cart.
     * @param int $user_id
     * @param int $product_id
     * @param int $quantita 
     */
    public function updateQuantityProductInTheCart($user_id, $product_id, $quantita) {
        $stmt = $this->db->prepare(
            "UPDATE Carrello 
            SET quantita = ? 
            WHERE codProdotto = ?
            AND codCliente = ?"
        );
        $stmt->bind_param("iii", $quantita, $product_id, $user_id);
        $stmt->execute();
    }

    /**
     * Delete a product from the shopping cart of a user.
     * @param int $user_id
     * @param int $product_id
     */
    public function deleteProductFromShoppingCart($user_id, $product_id) {
        $stmt = $this->db->prepare(
            "DELETE FROM Carrello
            WHERE codProdotto = ?
            AND codCliente = ?"
        );
        $stmt->bind_param("ii", $product_id, $user_id);
        $stmt->execute();
    }

    /**
     * Removes every item from the given user's shopping cart.
     * @param int $user_id the ID of the user
     */
    public function emptyShoppingCart($user_id) {
        $stmt = $this->db->prepare(
            "DELETE FROM Carrello
            WHERE codCliente = ?"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
    }

    /**
     * Returns the ID of every user who has the given product in the cart.
     * @param int $product_id the ID of the product
     * @return array
     */
    public function getUsersByProductInCart($product_id) {
        $stmt = $this->db->prepare(
            "SELECT codCliente
            FROM carrello
            WHERE codProdotto = ?"
        );
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Modifies the available quantity of a product in the database
     * @param int $product_id the ID of the product
     * @param int $new_quantity the new quantity of the product
     * @return bool True if the operation was successful, false otherwise
     */
    public function modifyQuantityProduct($product_id, $new_quantity) {
        $stmt = $this->db->prepare(
            "UPDATE prodotti
            SET quantita_disponibile = ?
            WHERE codProdotto = ?"
        );
        $stmt->bind_param("ii", $new_quantity, $product_id);
        return $stmt->execute();
    }

    /**
     * Get all the products in the database by category
     * @param varchar $category_id 
     * @return array
     */
    public function getProductsByCategory($category_id) {
        $stmt = $this->db->prepare(
            "SELECT codProdotto AS id, nome, immagine, prezzo, quantita_disponibile, categoria, punteggio_medio
            FROM prodotti
            WHERE categoria = ?"
        );
        $stmt->bind_param("s", $category_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get all the products in the database by genre
     * @param varchar $genre_id 
     * @return array
     */
    public function getProductsByGenre($genre_id) {
        $stmt = $this->db->prepare(
            "SELECT P.codProdotto AS id, nome, immagine, prezzo, quantita_disponibile, categoria, punteggio_medio
            FROM appartenenze_generi as A, prodotti as P
            WHERE genere = ?
            AND A.codProdotto = P.codProdotto"
        );
        $stmt->bind_param("s", $genre_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get all the products in the database by a input string
     * @param string $input_text 
     * @return array
     */
    public function getSearchProducts($text) {
        $search_text = "%$text%";
        $stmt = $this->db->prepare(
            "SELECT codProdotto AS id, nome, immagine, prezzo, quantita_disponibile, categoria, punteggio_medio
            FROM prodotti
            WHERE LOWER(nome) LIKE ?"
        );
        $stmt->bind_param("s", $search_text);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Adds a new order for the specified user.
     * Doesn't add the references to the products. This must be done using
     * the appropriate DataBaseHelper function AFTER calling this function.
     * @param int $user_id the ID of the user
     * @param string $date the date in which the order was created
     * @param string $shipping_address the shipping address of the order
     * @param float $total_price the total price of the items in the order
     * @param string $shipping_status the shipping status of the order
     * @return int the ID of the newly added order, 0 if the operation was unsuccessful
     */
    public function addOrder($user_id, $date, $shipping_address, $total_price, $shipping_status) {
        $stmt = $this->db->prepare(
            "INSERT INTO ordini (codCliente, data, indirizzo_di_spedizione, prezzo_totale, stato_spedizione)
            VALUES (?, ?, ?, ?, ?)"
        );
        $stmt->bind_param("issds", $user_id, $date, $shipping_address, $total_price, $shipping_status);
        $stmt->execute();
        return $stmt->insert_id;
    }

    /**
     * Adds a new item to the specified order.
     * @param int $product_id the ID of the product that must be added to the order
     * @param int $order_id the ID of the order
     * @param int $quantity the number of copies of the item in the order
     * @return bool True if the operation was successful, false otherwise
     */
    public function addOrderItem($product_id, $order_id, $quantity) {
        $stmt = $this->db->prepare(
            "INSERT INTO composizioni (codOrdine, codProdotto, quantita)
            VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iii", $order_id, $product_id, $quantity);
        return $stmt->execute();
    }

    /**
     * Updates the state of the specified order.
     * @param int $order_id the ID of the order
     * @param string $new_state the new state of the order
     * @return bool True if the operation was successful, false otherwise
     */
    public function updateOrderState($order_id, $new_state) {
        $stmt = $this->db->prepare(
            "UPDATE ordini
            SET stato_spedizione = ?
            WHERE codOrdine = ?"
        );
        $stmt->bind_param("si", $new_state, $order_id);
        return $stmt->execute();
    }

    /**
     * Returns an array containing every order done by a specific user.
     * The orders are ordered by descending date.
     * @param int $user_id the ID of the user
     * @return array
     */
    public function getOrdersByUser($user_id) {
        $stmt = $this->db->prepare(
            "SELECT codOrdine, data, prezzo_totale, stato_spedizione 
            FROM ordini
            WHERE codCliente = ?
            ORDER BY data DESC, codOrdine DESC"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns an array containing every order received by the specified seller.
     * @param int $seller_id the seller's ID
     * @return array
     */
    public function getOrdersReceived($seller_id) {
        $stmt = $this->db->prepare(
            "SELECT DISTINCT O.codOrdine, O.data, O.prezzo_totale, O.stato_spedizione 
            FROM ordini O, composizioni C, prodotti P
            WHERE O.codOrdine = C.codOrdine
            AND C.codProdotto = P.codProdotto
            AND P.codVenditore = ?
            ORDER BY data DESC, codOrdine DESC"
        );
        $stmt->bind_param("i", $seller_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns an array containing informations about every item in a specific order.
     * @param int $order_id the ID of the order
     * @return array
     */
    public function getItemsByOrder($order_id) {
        $stmt = $this->db->prepare(
            "SELECT C.codProdotto, C.quantita, P.nome, P.immagine, P.prezzo
            FROM composizioni C, prodotti P
            WHERE C.codOrdine = ?
            AND C.codProdotto = P.codProdotto"
        );
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns the customer ID of the specified order
     * @param int $order_id the ID of the order
     * @return array
     */
    public function getCustomerIDByOrder($order_id) {
        $stmt = $this->db->prepare(
            "SELECT codOrdine, codCliente
            FROM ordini
            WHERE codOrdine = ?"
        );
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns an array containing the notifications of the user.
     * @param int $user_id
     * @return array
     */
    public function getNotification($user_id) {
        $stmt = $this->db->prepare(
            "SELECT codNotifica, messaggio, data, letta
            FROM notifiche
            WHERE codUtente = ?
            ORDER BY data DESC"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns an array containing the notifications read of the user.
     * @param int $user_id
     * @return array
     */
    public function getReadNotification($user_id) {
        $stmt = $this->db->prepare(
            "SELECT codNotifica, messaggio, data
            FROM notifiche
            WHERE codUtente = ?
            AND letta = 1
            ORDER BY data DESC"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Returns an array containing the notifications unread of the user.
     * @param int $user_id
     * @return array
     */
    public function getUnreadNotification($user_id) {
        $stmt = $this->db->prepare(
            "SELECT codNotifica, messaggio, data
            FROM notifiche
            WHERE codUtente = ?
            AND letta = 0
            ORDER BY data DESC"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Deletes a notification.
     * @param int $notify_id
     * @return array
     */
    public function deleteNotification($notify_id) {
        $stmt = $this->db->prepare(
            "DELETE FROM notifiche
            WHERE codNotifica = ?"
        );
        $stmt->bind_param("i", $notify_id);
        $stmt->execute();
    }

    /**
     * Reads a notification.
     * @param int $notify_id
     * @return array
     */
    public function readNotification($notify_id) {
        $stmt = $this->db->prepare(
            "UPDATE notifiche
            SET letta = 1
            WHERE codNotifica = ?"
        );
        $stmt->bind_param("i", $notify_id);
        $stmt->execute();
    }

    /**
     * Sends a notification with the specified message to the given user.
     * @param int $user_id the ID of the user to which the notification will be sent
     * @param string $message the message of the notification
     * @param string $date the date in which the notification was sent
     * @return bool True if the notification was sent, false otherwise
     */
    public function sendNotification($user_id, $message, $date) {
        $stmt = $this->db->prepare(
            "INSERT INTO notifiche (codUtente, messaggio, data) 
            VALUES (?, ?, ?)"
        );
        $stmt->bind_param("iss", $user_id, $message, $date);
        return $stmt->execute();
    }

    /**
     * Returns an array containing the favorite products of the user.
     * @param int $user_id
     * @return array
     */
    public function getFavorite($user_id) {
        $stmt = $this->db->prepare(
            "SELECT codProdotto
            FROM preferiti
            WHERE codCliente = ?"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Checks if a product is in the Favourite section.
     * @param int $user_id
     * @param int $product_id
     * @return array
     */
    public function isFavourite($user_id, $product_id) {
        $stmt = $this->db->prepare(
            "SELECT codProdotto
            FROM preferiti
            WHERE codCliente = ?
            AND codProdotto = ?"
        );
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Deletes a product from the favourites.
     * @param int $user_id
     * @param int $product_id
     * @return array
     */
    public function deleteFavourite($user_id, $product_id) {
        $stmt = $this->db->prepare(
            "DELETE FROM preferiti
            WHERE codCliente = ?
            AND codProdotto = ?"
        );
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    /**
     * Inserts a product from the favourites.
     * @param int $user_id
     * @param int $product_id
     * @return array
     */
    public function insertFavourite($user_id, $product_id) {
        $stmt = $this->db->prepare(
            "INSERT INTO preferiti (codCliente, codProdotto)
            VALUES (?, ?)"
        );
        $stmt->bind_param("ii", $user_id, $product_id);
        $stmt->execute();
    }

    /**
     * Returns the ID of every user who has the given product in their favourites.
     * @param int $product_id the ID of the product
     * @return array
     */
    public function getUsersByProductInFavourites($product_id) {
        $stmt = $this->db->prepare(
            "SELECT codCliente
            FROM preferiti
            WHERE codProdotto = ?"
        );
        $stmt->bind_param("i", $product_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Adds a new product in the database.
     * @param string $nome product's name
     * @param float $prezzo 
     * @param int $quantita 
     * @param string $immagine
     * @param string $categoria
     * @param string $descrizione
     * @param float $altezza
     * @param float $larghezza
     * @param float $profondita
     * @return int the ID of the added product, 0 if the operation was unsuccessful
     */
    public function addProduct($nome, $prezzo, $quantita, $immagine, $descrizione, $opera_appartenenza, $altezza, $larghezza, $profondita, $categoria, $generi) {
        $stmt = $this->db->prepare(
            "INSERT INTO prodotti (nome, immagine, descrizione, opera_di_appartenenza, prezzo, quantita_disponibile, altezza, larghezza, profondita, data_inserimento, codVenditore, categoria)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), 1, ?)"
        );
        $stmt->bind_param("ssssdiddds", $nome, $immagine, $descrizione, $opera_appartenenza, $prezzo, $quantita, $altezza, $larghezza, $profondita, $categoria);
        $success = $stmt->execute();

        if($success) {
            $product_id = mysqli_insert_id($this->db);

            foreach($generi as $genere) {
                $stmt = $this->db->prepare(
                    "INSERT INTO appartenenze_generi(codProdotto, genere)
                    VALUES (?, ?)"
                );
                $stmt->bind_param("is", $product_id, $genere);
                $stmt->execute();
            }
        } else {
            $product_id = 0;
        }

        return $product_id;
    }

    /**
     * Gets all the products in the database.
     * @return array
     */
    public function getProducts() {
        $stmt = $this->db->prepare(
            "SELECT *
            FROM prodotti"
        );
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Updates the information of a product.
     * @param int $id
     * @param string $nome product's name
     * @param float $prezzo 
     * @param int $quantita 
     * @param string $immagine
     * @param string $categoria
     * @param string $descrizione
     * @param float $altezza
     * @param float $larghezza
     * @param float $profondita
     * @param array $generi the array of strings specifiying every genre associated with the product
     * @return bool True if the operation was successful, false otherwise
     */
    public function modifyProduct($id, $nome, $prezzo, $quantita, $immagine, $categoria, $descrizione, $opera_appartenenza, $altezza, $larghezza, $profondita, $generi) {
        $stmt = $this->db->prepare(
            "UPDATE prodotti 
            SET nome = ?,
                immagine = ?,
                descrizione = ?,
                opera_di_appartenenza = ?,
                prezzo = ?,
                quantita_disponibile = ?,
                altezza = ?,
                larghezza = ?,
                profondita = ?,
                codVenditore = 1,
                categoria = ?
            WHERE codProdotto = ?"
        );
        $stmt->bind_param("ssssdidddsi", $nome, $immagine, $descrizione, $opera_appartenenza, $prezzo, $quantita, $altezza, $larghezza, $profondita, $categoria, $id);
        $success = $stmt->execute();

        $stmt = $this->db->prepare(
            "DELETE FROM appartenenze_generi
            WHERE codProdotto = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();

        foreach($generi as $genere) {
            $stmt = $this->db->prepare(
                "INSERT INTO appartenenze_generi (codProdotto, genere)
                VALUES (?, ?)"
            );
            $stmt->bind_param("is", $id, $genere);
            $stmt->execute();
        }
        
        return $success;
    }

    /**
     * Modifies the username of a user.
     * @param int $id
     * @param string $username new username
     */
    public function modifyUsername($id, $username) {
        $stmt = $this->db->prepare(
            "UPDATE utenti
            SET username = ?
            WHERE codUtente = ?"
        );
        $stmt->bind_param("si", $username, $id);
        $stmt->execute();
    }

    /**
     * Returns the password of the user.
     * @param int $id
     * @return array
     */
    public function getPassword($id) {
        $stmt = $this->db->prepare(
            "SELECT password
            FROM utenti
            WHERE codUtente = ?"
        );
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Modifies the username of a user.
     * @param int $id
     * @param string $password new password
     */
    public function modifyPassword($id, $password) {
        $stmt = $this->db->prepare(
            "UPDATE utenti
            SET password = ?
            WHERE codUtente = ?"
        );
        $stmt->bind_param("si", $password, $id);
        $stmt->execute();
    }

    /**
     * Gets the user's email by its id
     * @param int $user_id
     * @return array
     */
    public function getEmailById($user_id) {
        $stmt = $this->db->prepare(
            "SELECT email
            FROM utenti
            WHERE codUtente = ?"
        );
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        return $result->fetch_all(MYSQLI_ASSOC);
    }
}