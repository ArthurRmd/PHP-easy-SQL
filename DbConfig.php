<?php


class DbConfig
{

    private $configLink = "config.json";
    protected $data;

    function __construct()
    {
        $fichier = file_get_contents($configLink);
        $fichier = json_decode($fichier);

        $this->data['sgbd'] = $fichier->sgbd;
        $this->data['serveur'] = $fichier->serveur;
        $this->data['login'] = $fichier->login;
        $this->data['pass'] = $fichier->pass;
        $this->data['table'] = $fichier->table;
    }

    public function getData($data = null)
    {
        if ($data == null) {
            return $this->data;
        } elseif (isset($this->data[$data])) {
            return $this->data[$data];
        } else {
            return null;
        }
    }

    public function getDns()
    {
        return $this->getData('sgbd') . ":host=" . $this->getData('serveur') . ";dbname=" . $this->getData('table');
    }

    public function getPdo()
    {

        try {
            $this->pdo = new PDO($this->getDns(), $this->getData('login'), $this->getData('pass'));
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            return $this->pdo;
        } catch (PDOException $e) {
            // echo "Erreur connexion à la base de donnée -> " . $e->getMessage();
            return null;
        }
    }

}
