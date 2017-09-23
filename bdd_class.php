<?php

class articles
{
    /** @var string */
    private $serveur;
    /** @var string */
    private $user;
    /** @var string */
    private $pass;
    /** @var mysqli */
    private $bdd;
    /** @var mysqli */
    private $connect;

    /**
     * @return string
     */
    public function getServeur()
    {
        return $this->serveur;
    }

    /**
     * @return string
     */
    public function getUser()
    {
        return $this->user;
    }

    /**
     * @return string
     */
    public function getPass()
    {
        return $this->pass;
    }

    /**
     * @return mysqli
     */
    public function getBdd()
    {
        return $this->bdd;
    }

    /**
     * articles constructor.
     * @param string $serveur
     * @param string $user
     * @param string $pass
     * @param mysqli $bdd
     */

    public function __construct($serveur, $user, $pass, $bdd)
    {

        $this->serveur = $serveur;
        $this->user = $user;
        $this->pass = $pass;
        $this->bdd = $bdd;

        try {
            $this->connect = new mysqli($this->serveur, $this->user, $this->pass, $this->bdd);
        } catch (Exception $e) {
            throw new mysqli_sql_exception("Error connexion " . $e->getMessage() . "\n");
        }
    }

    /**
     * @param string $titre
     * @param string $contenue
     * @param string $auteur
     */
    public function insertArticle($titre, $contenue, $auteur)
    {
        $sql = "INSERT INTO article VALUES (NULL,'$titre', '$contenue', '$auteur')";
        if ($this->connect->query($sql) === TRUE) {
            return "Nouvel article $titre crée";
        } else {
            return "Error: " . $sql . "<br>" . $this->connect->error;
        }

    }

    /**
     * @param int $id
     * @param string $titre
     * @param string $contenue
     * @param string $auteur
     */
    public function updatetArticle($id, $titre, $contenue, $auteur)
    {
        $sql = "UPDATE article  SET titre='$titre', contenue='$contenue', auteur='$auteur' WHERE id=$id";
        if ($this->connect->query($sql) === TRUE) {
            return "Modification de l'article : $titre";
        } else {
            return "Error: " . $sql . "<br>" . $this->connect->error;
        }

    }

    /**
     * @param int $id
     */
    public function deletetArticle($id)
    {
        $sql = "DELETE FROM article WHERE id=$id";
        if ($this->connect->query($sql) === TRUE) {
            return "Suppression de l'article";
        } else {
            return "Error: " . $sql . "<br>" . $this->connect->error;
        }

    }

    /**
     * @return array|string
     */
    public function listingtArticle()
    {
        $results = "";
        $sql = "SELECT * FROM article";
        $result = $this->connect->query($sql);

        while ($row = $result->fetch_array()) {
            $results[] = $row;
        }

        return $results;

    }

    /**
     * @param int $id
     * @return array|string
     */
    public function oneArticle($id)
    {
        $results = "";
        $sql = "SELECT * FROM article WHERE id=$id";
        $result = $this->connect->query($sql);

        return $result->fetch_array(MYSQLI_ASSOC);


    }


}

