<?php


class DbConfig
{

    private static $configLink = "config.json";
    protected static $data;
    protected static $pdo;


    private static function getConfig()
    {
        if ( self::$data == null) {
            $fichier = file_get_contents( __DIR__ . '/' . self::$configLink);
            $fichier = json_decode($fichier);

            self::$data['sgbd'] = $fichier->sgbd;
            self::$data['serveur'] = $fichier->serveur;
            self::$data['login'] = $fichier->login;
            self::$data['pass'] = $fichier->pass;
            self::$data['base'] = $fichier->base;
        }
    }


    public static function getData($data = null)
    {
        self::getConfig();

        if ($data == null) {
            return self::$data;
        } elseif (isset(self::$data[$data])) {
            return self::$data[$data];
        } else {
            return null;
        }
    }


    private static function getDns()
    {
        return self::getData('sgbd') . ":host=" . self::getData('serveur') . ";dbname=" . self::getData('base');
    }


    public static function getLink()
    {
        return self::$configLink;
    }


    public static function setLink( $path)
    {
        self::$configLink = $path;
        self::close();
    }


    public static function getPdo()
    {
        if (self::$pdo == null) {
            try {
                self::$pdo = new PDO(self::getDns(), self::getData('login'), self::getData('pass'));
                self::$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                return self::$pdo;
            } catch (PDOException $e) {
                // echo "Erreur connexion à la base de donnée -> " . $e->getMessage();
                return null;
            }
        } else {
            return self::$pdo;
        }
        
    }


    public static function close()
    {
        self::$pdo = null; 
    }
}
