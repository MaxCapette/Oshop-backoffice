<?php

namespace App\Models;

use App\Utils\Database;
use PDO;

class AppUser extends CoreModel
{

    
   
    private $email;
   
    private $password;
   
    private $firstname;
   
    private $lastname;
 
    private $role;
   
    private $status;
    


    public static function delete($id) 
    {
        // Récupération de l'objet PDO représentant la connexion à la DB
        $pdo = Database::getPDO();

        $sql = "
            DELETE FROM `app_user` WHERE `id` = :id;
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
        INSERT INTO `app_user` (`email`, `password`,`firstname`,`lastname`, `role`, `status`)
        VALUES (:email, :password, :firstname, :lastname, :role, :status);";

        // $preparedQuery est un objet PDOStatement
        $preparedQuery = $pdo->prepare($sql);


        // Execution de la requête d'insertion avec la méthode execute
        // On fournit un tableau qui contient les valeurs à remplacer dans la requête
        // il est possible de renseigner les valeurs avant de lancer execute 
        // en utilisant les méthodes qui commencent par bind*
        $queryIsSuccessful = $preparedQuery->execute([
            ':email' => $this->email,
            ':password' => $this->password,
            ':firstname' => $this->firstname,
            ':lastname' => $this->lastname,
            ':role' => $this->role,
            ':status' => $this->status,
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
            UPDATE `app_user` 
            SET 
                `email` = :email, 
                `password` = :password,
                `firstname` = :firstname,
                `lastname` = :lastname,
                `role` = :role,
                `status` = :status,
                `updated_at` = now()
            WHERE `id` = :id
        ";

   


        // $preparedQuery est un objet PDOStatement
        $preparedQuery = $pdo->prepare($sql);


        // Execution de la requête d'insertion avec la méthode execute
        // exemple avec bindValue
        $preparedQuery->bindValue(':id', $this->id);
        $preparedQuery->bindValue(':email', $this->email);
        $preparedQuery->bindValue(':password', $this->password);
        $preparedQuery->bindValue(':firstname', $this->firstname);
        $preparedQuery->bindValue(':lastname', $this->lastname);
        $preparedQuery->bindValue(':role', $this->role);
        $preparedQuery->bindValue(':status', $this->status);
    
        
        /*
            différence entre bindValue et bindParam

            Avec bindValue, le remplacement dans la requete se fait au moment du bind
            Avec bindParam, le remplacement dans la requete se fait au moment du execute
        */

        $queryIsSuccessful = $preparedQuery->execute();


        return $queryIsSuccessful;
    }
    
    public static function find(int $UserId)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT `id`, `email`, `password`,`firstname`,`lastname`, `role`, `status`,`created_at`, `updated_at` FROM `app_user` WHERE `id` =' . $UserId;

        // exécuter notre requête
        $pdoStatement = $pdo->query($sql);

        // un seul résultat => fetchObject
        $user = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $user;
    }

    /**
     * Méthode permettant de récupérer tous les enregistrements de la table appUser
     *
     * @return AppUser[]
     */
    public static function findAll()
    {
        $pdo = Database::getPDO();
        $sql = 'SELECT `id`, `email`, `password`,`firstname`,`lastname`, `role`, `status`,`created_at`, `updated_at` FROM `app_user`';
        $pdoStatement = $pdo->query($sql);
        $results = $pdoStatement->fetchAll(PDO::FETCH_CLASS, self::class);

        return $results;
    }

   /*
    password en clair : $password = Passw0rd!
    hash : $hasedPassword = 5994471abb01112afcc18159f6cc74b4f511b99806da59b3caf5a9c173cacfc5
    password_verify($password, $hashedPassword);
    */
    /**
     * findByEmail(string $email)
     *
     * @param string $email
     * @return AppUser
     */
    public static function findByEmail(string $email)
    {
        // se connecter à la BDD
        $pdo = Database::getPDO();

        // écrire notre requête
        $sql = 'SELECT `id`, `email`, `password`,`firstname`,`lastname`, `role`, `status`,`created_at`, `updated_at` FROM `app_user` WHERE `email` = :email';

        // préparer notre requête
        $pdoStatement = $pdo->prepare($sql);

        $pdoStatement->execute([
            ':email' => $email
        ]);

        // un seul résultat => fetchObject
        // __CLASS__ et self::class contiennent le FQCN de la classe actuelle;
        $appuser = $pdoStatement->fetchObject(self::class);

        // retourner le résultat
        return $appuser;
    }
    /**
     * Get the value of email
     *
     * @return  string
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set the value of email
     *
     * @param  string  $email
     *
     * @return  self
     */ 
    public function setEmail(string $email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get the value of password
     *
     * @return  string
     */ 
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set the value of password
     *
     * @param  string  $password
     *
     * @return  self
     */ 
    public function setPassword(string $password)
    {
        $this->password = $password;

        return $this;
    }

    

    /**
     * Get the value of firstname
     *
     * @return  string
     */ 
    public function getFirstName()
    {
        return $this->firstname;
    }

    /**
     * Set the value of firstname
     *
     * @param  string  $firstname
     *
     * @return  self
     */ 
    public function setFirstName(string $firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get the value of lastname
     *
     * @return  string
     */ 
    public function getLastName()
    {
        return $this->lastname;
    }

    /**
     * Set the value of lastname
     *
     * @param  string  $lastname
     *
     * @return  self
     */ 
    public function setLastName(string $lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }
 /**
     * Get the value of status
     *
     * @return  int
     */ 
    public function getRole()
    {
        return $this->role;
    }

    /**
     * Set the value of role
     *
     * @param  int  $role
     *
     * @return  self
     */ 
    public function setRole(int $role)
    {
        $this->role = $role;

        return $this;
    }
    /**
     * Get the value of status
     *
     * @return  int
     */ 
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set the value of status
     *
     * @param  int  $status
     *
     * @return  self
     */ 
    public function setStatus(int $status)
    {
        $this->status = $status;

        return $this;
    }
}
