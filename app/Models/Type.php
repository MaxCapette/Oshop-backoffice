<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

/**
 * Un modèle représente une table (un entité) dans notre base
 *
 * Un objet issu de cette classe réprésente un enregistrement dans cette table
 */
class Type extends CoreModel
{
    // Les propriétés représentent les champs
    // Attention il faut que les propriétés aient le même nom (précisément) que les colonnes de la table

    /**
     * @var string
     */
    private $name;

    /**
     * Méthode permettant de récupérer un enregistrement de la table Type en fonction d'un id donné
     *
     * @param int $typeId ID du type
     * @return Type
     */
    public static function find($typeId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT `id`, `name`, `created_at`, `updated_at`  FROM `type` WHERE `id` =' . $typeId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $type = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $type;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table type
     *
     * @return Type[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT `id`, `name`, `created_at`, `updated_at`  FROM `type`';
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
            INSERT INTO `type` (`name`)
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
        UPDATE `type`
        SET
            `name` = :name,
            `updated_at` = NOW()
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
