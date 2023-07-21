<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class Category extends CoreModel
{

    /**
     * @var string
     */
    private $name;
    /**
     * @var string
     */
    private $subtitle;
    /**
     * @var string
     */
    private $picture;
    /**
     * @var int
     */
    private $home_order;


    public static function delete($id) 
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        $sql = "
            DELETE FROM `category` WHERE id = :id;
        ";

        // $preparedQuery est un objet PDOStatement
        $preparedQuery = $pdo->prepare($sql);

        $queryIsSuccessful = $preparedQuery->execute([
            ':id' => $id,
        ]);

        return $queryIsSuccessful;

    }

    

    /**
     * Méthode permettant d'ajouter un enregistrement dans la BDD
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert() :bool
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        // on prépare des emplacement pour les valeurs à remplacer dans la requête
        $sql = "
        INSERT INTO `category` (`name`, `subtitle`, `picture`)
        VALUES (:name, :subtitle, :emplacement_picture);";

        // $preparedQuery est un objet PDOStatement
        $preparedQuery = $pdo->prepare($sql);


        // Execution de la requête d'insertion avec la méthode execute
        // On fournit un tableau qui contient les valeurs à remplacer dans la requête
        // il est possible de renseigner les valeurs avant de lancer execute 
        // en utilisant les méthodes qui commencent par bind*
        $queryIsSuccessful = $preparedQuery->execute([
            ':name' => $this->name,
            ':subtitle' => $this->subtitle,
            ':emplacement_picture' => $this->picture,
        ]);

        // Si au moins une ligne ajoutée
        // if ($queryIsSuccessful === true) {
        if ($queryIsSuccessful) {
            // Alors on récupère l'id auto-incrémenté généré par MySQL
            $this->id = $pdo->lastInsertId();

            // On retourne VRAI car l'ajout a parfaitement fonctionné
            return true;
            // => l'interpréteur PHP sort de cette fonction car on a retourné une donnée
        }

        // Si on arrive ici, c'est que quelque chose n'a pas bien fonctionné => FAUX
        return false;
    }

    /**
     * Méthode permettant de récupérer un enregistrement de la table Category en fonction d'un id donné
     *
     * @param int $categoryId ID de la catégorie
     * @return Category
     */
    public static function find($categoryId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT `id`, `name`, `subtitle`, `picture`, `home_order`,`created_at`, `updated_at` FROM `category` WHERE `id` =' . $categoryId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $category = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $category;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table category
     *
     * @return Category[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT `id`, `name`, `subtitle`, `picture`, `home_order`,`created_at`, `updated_at` FROM `category`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

    /**
     * Mets à jour l'enregistrement en BDD
     *
     * @return void
     */
    public function update()
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        // Ecriture de la requête INSERT INTO
        // on prépare des emplacement pour les valeurs à remplacer dans la requête
        $sql = "
            UPDATE `category` 
            SET
                `name` = :name, 
                `subtitle` = :subtitle, 
                `picture` = :picture,
                `home_order` = :home_order,
                `updated_at` = now()
            WHERE `id` = :id
        ";

   


        // $preparedQuery est un objet PDOStatement
        $preparedQuery = $pdo->prepare($sql);


        // Execution de la requête d'insertion avec la méthode execute
        // exemple avec bindValue
        $preparedQuery->bindValue(':id', $this->id);
        $preparedQuery->bindValue(':name', $this->name);
        $preparedQuery->bindValue(':subtitle', $this->subtitle);
        $preparedQuery->bindValue(':picture', $this->picture);
        $preparedQuery->bindParam(':home_order', $this->home_order);
        
        /*
            différence entre bindValue et bindParam

            Avec bindValue, le remplacement dans la requete se fait au moment du bind
            Avec bindParam, le remplacement dans la requete se fait au moment du execute
        */

        $queryIsSuccessful = $preparedQuery->execute();


        return $queryIsSuccessful;
    }

    /**
     * Récupérer les 3 catégories à afficher sur la home du backoffice
     *
     * @return Category[]
     */
    public static function findLast3()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT `id`, `name`, `subtitle`, `picture`, `home_order`,`created_at`, `updated_at`
            FROM `category`
            ORDER BY updated_at DESC, created_at DESC
            LIMIT 3;
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $categories;
    }

    /**
     * Récupérer les 5 catégories mises en avant sur la home
     *
     * @return Category[]
     */
    public static function findAllHomepage()
    {
        $pdo = Database::getPDO();
        $sql = '
            SELECT `id`, `name`, `subtitle`, `picture`, `home_order`,`created_at`, `updated_at`
            FROM category
            WHERE home_order > 0
            ORDER BY home_order ASC
        ';
        $pdoStatement = $pdo->query($sql);
        $categories = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $categories;
    }

    /**
     * Get the value of name
     *
     * @return  string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set the value of name
     *
     * @param  string  $name
     */
    public function setName(string $name)
    {
        $this->name = $name;
    }

    /**
     * Get the value of subtitle
     */
    public function getSubtitle()
    {
        return $this->subtitle;
    }

    /**
     * Set the value of subtitle
     */
    public function setSubtitle($subtitle)
    {
        $this->subtitle = $subtitle;
    }

    /**
     * Get the value of picture
     */
    public function getPicture()
    {
        return $this->picture;
    }

    /**
     * Set the value of picture
     */
    public function setPicture($picture)
    {
        $this->picture = $picture;
    }

    /**
     * Get the value of home_order
     */
    public function getHomeOrder()
    {
        return $this->home_order;
    }

   
      
    /**
     * Set the value of home_order
     */
    public function setHomeOrder($home_order)
    {
        $this->home_order = $home_order;
    }
}
