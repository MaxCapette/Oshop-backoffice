<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class Brand extends CoreModel
{
    // Les propriétés représentent les champs
    // Attention il faut que les propriétés aient le même nom (précisément) que les colonnes de la table

    /**
     * @var string
     */
    private $name;


    public static function delete($id) 
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        $sql = "
            DELETE FROM `brand` WHERE id = :id;
        ";

        // $preparedQuery est un objet PDOStatement
        $preparedQuery = $pdo->prepare($sql);

        $queryIsSuccessful = $preparedQuery->execute([
            ':id' => $id,
        ]);

        return $queryIsSuccessful;

    }



    /**
     * Méthode permettant de récupérer un enregistrement de la table Brand en fonction d'un id donné
     *
     * @param int $brandId ID de la marque
     * @return Brand
     */
    public static function find($brandId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT `id`, `name`,`created_at`, `updated_at` FROM `brand` WHERE `id` = ' . $brandId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $brand = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $brand;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table brand
     *
     * @return Brand[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT `id`, `name`,`created_at`, `updated_at` FROM `brand`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

/**
     * Méthode permettant d'ajouter un enregistrement dans la BDD
     * L'objet courant doit contenir toutes les données à ajouter : 1 propriété => 1 colonne dans la table
     *
     * @return bool
     */
    public function insert() :bool
    {

        $pdo = Database::getPDO();

        $sql = "
            INSERT INTO `brand` (name)
            VALUES (:name);
        ";

        $preparedQuery = $pdo->prepare($sql);

        $queryIsSuccessful = $preparedQuery->execute([
            ':name' => $this->name
        ]);

        if ($queryIsSuccessful) {
            $this->id = $pdo->lastInsertId();
            return true;   
        }
        return false;
    }


    public function update()
    {
    
        $pdo = Database::getPDO();
        
        $sql = "
        UPDATE `brand`
        SET
            name = :name,
            updated_at = NOW()
        WHERE id = :id
    ";

    $preparedQuery = $pdo->prepare($sql);

    $queryIsSuccessful = $preparedQuery->execute([
        ':name' => $this->getName(),
        ':id' => $this->getId(),
    ]);

            if ($queryIsSuccessful) {
                $this->id = $pdo->lastInsertId();
                return true;
            }
            return false;
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
}
