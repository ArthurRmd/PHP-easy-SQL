# PHP EASY SQL

## Installation

1. Télécharger le dossier PHP-Easy-SQL 
1. Inclure le dossier PHP-Easy-SQL dans votre projet
```php
require __DIR__.'/lib/PHP-Easy-SQL/index.php';
```
2.  Configurer le fichier config.json
```json
{
	"sgbd"  :  "mysql",
	"serveur"  :  "localhost",
	"login"  :  "root",
	"pass"  :  "mot_de_passe",
	"table"  :  "nom_de_la_table"
}
```
Si vous souhaitez modifier la place du fichier config.json, il suffit d'indiquer le chemin du fichier dans la variable ``$configLink`` située dans le fichier ``PHP-Easy-SQL/index.php``.

```php
exemple : 

class  DbConfig
{
	private  $configLink  =  __DIR__."/../../config.json";
	...
}
```

Vous pouvez également modifier le chemin en utilisant la méthode ``setLink``.
Attention vous devez mettre le chemin depuis le fichier ``index.php`` du dossier ``PHP-Easy-SQL``
```php
require __DIR__.'/lib/PHP-Easy-SQL/index.php';
Db::setLink('../../config.json');
```

## Utilisation 

### Class BdConfig

#### getData ( )

La méthode `getData()` permet de récupérer facilement les informations qui se situent dans le fichier config.json.

```php
DbConfig::getData(); 
// renvoie un tableau avec toutes les informations
//['sgbd' => 'mysql', 'serveur' => 'localhost', 'login' => 'root', 'pass','mot_de_passe' 'table' => 'nom_de_la_table']
```
vous pouvez également mettre le nom de la clef en paramètre.
```php
DbConfig::getData('sgbd'); // renvoie 'mysql'
```

#### getPdo ( ) 
La méthode `getPdo()` permet de renvoyer un objet PDO.

```php
$pdo = DbConfig::getPdo();
$pdo->query('select * from users');
```


### Class Db

La classe ``Db`` hérite  de la classe ``DbConfig`` vous pouvez ainsi utiliser toutes les méthodes vu précédemment.
  
####  select ( ) et query ( )

Les méthodes `select()` et `query()` permettent d'effectuer des requêtes sql plus rapidement.

`select()` permet de récupérer un tableau avec le résultat de la requête sql, à utiliser si vous souhaitez faire un ``select ...``  ou un ``show ...`` .  

`query()`renvoie le nombre de changement effectué,  à utiliser si vous souhaitez faire un ``insert ...`` , un ``delete ...``, un ``update ...`` etc  ...


```php
Db::select('select * from users');
Db::select('select * from users where prenom like "Arthur"');

Db:query("insert into users values ('prenom') value ('Arthur') ");

```

Vous pouvez également faire une requête préparée en mettant en second paramètre un tableau.
 
```php
Db::select('select * from users where prenom like :prenom',['prenom' => 'Arthur'] );

$var = 'Arthur';
Db:query("insert into users values ('prenom') value (:prenom) ", ['prenom' => $var]);

```

#### selectAll ( )

La méthode ``selectAll()``  permet d'effectuer un `` select * from nom_de_la_table`` .

```php
Db::selectAll('users');
```

Vous pouvez également rajouter un ``where`` a votre requête.
Pour cela il suffit de rajouter un tableau sous cette forme en second paramètre `` ['colonne', 'condition', 'valeur']``. 
Si votre condition est un  ``=``  vous pouvez uniquement mettre la colonne et la valeur ``['colonne','valeur']``. 

```php
Db::selectAll('users', ['prenom', '=', 'Arthur']);
Db::selectAll('users', ['prenom','Arthur']);
// Les deux résulat seront identique


Db::selectAll('users', ['id', '>', '10']);

```

#### find ( )

La méthode ``find()`` permet de récupérer une ligne en fonction d'un ``id``.
Elle prend en paramètre le ``nom d'une table`` et  ``id`` a rechercher. Attention la méthode va rechercher une colonne se nommant ``id``

```php
Db::find('users', 5);
// et égale a la requête suivante
// select * from users where id = 5;
```

Licence : MIT






