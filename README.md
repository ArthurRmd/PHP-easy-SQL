# PHP EASY SQL

Petite bibliothèque permettant de faciliter les requêtes SQL en PHP

## Installation

1. Télécharger le dossier PHP-Easy-SQL 
2. Inclure le dossier PHP-Easy-SQL dans votre projet
```php
require __DIR__.'/lib/PHP-Easy-SQL/index.php';
```
3. Renommer le fichier config.example.json en config.json
4.  Configurer le fichier config.json
```json
{
	"sgbd"  :  "mysql",
	"serveur"  :  "localhost",
	"login"  :  "root",
	"pass"  :  "mot_de_passe",
	"base"  :  "nom_de_la_base"
}
```
Si vous souhaitez modifier la place du fichier config.json, il suffit d'indiquer le chemin du fichier dans la variable ``$configLink`` située dans le fichier ``PHP-Easy-SQL/index.php``.

```php
exemple : 

class  DbConfig
{
	private  $configLink  = "../../config.json";
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

### Class DbConfig

Les différentes méthodes de la classe DbConfig sont :
*	getData ( )
*	getLink ( )
*	setLink ( )
*	getPdo ( )
*	close ( )




#### getData ( )

La méthode `getData()` permet de récupérer facilement les informations qui se situent dans le fichier config.json.

```php
DbConfig::getData(); 
// renvoie un tableau avec toutes les informations contenue dans le fichier config.json
//['sgbd' => 'mysql', 'serveur' => 'localhost', 'login' => 'root', 'pass','mot_de_passe' 'base' => 'nom_de_la_base']
```
Vous pouvez également mettre le nom de la clef en paramètre afin de récupérer uniquement la valeur.
```php
DbConfig::getData('sgbd'); // renvoie 'mysql'
```


#### getLink ( )

La méthode `getLink()` permet de récupérer le chemin du fichier **config.json**.
```php
$link = DbConfig::getLink();
echo $link // renvoie la chaine "config.json"
```

#### setLink ( )

La méthode `setLink()` permet de changer le chemin du fichier **config.json**.
Attention si vous souhaitez l'utiliser, utilisé la méthode juste après l'inclusion du dossier, comme indiqué dans le guide d'installation.
```php
DbConfig::setLink('../../config.json');
``` 





#### getPdo ( ) 
La méthode `getPdo()` permet de renvoyer un objet PDO.

```php
$pdo = DbConfig::getPdo();
$pdo->query('select * from users');
```


#### close ( )

La méthode ``close()`` permet de fermer la connexion.
```php
DbConfig::close();
``` 






___
### Class Db

La classe ``Db`` hérite  de la classe ``DbConfig`` vous pouvez ainsi utiliser toutes les méthodes vu précédemment.

Les différentes méthodes de la classe DbConfig sont :

* select ( )
* query ( )
* selectAll ( )
* find ( )
* delete ( )
* insert ( )
* update ( )

  
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
Elle prend en paramètre le nom d'une table.

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
// est égale a la requête suivante
// select * from users where id = 5;
```
___
### Méthode delete / insert / update
Les méthodes `delete()`,  `insert()` et `update()` permettent d'effectuer rapidement une suppression, insertion et modification sur une base.
Les trois méthodes utilisent des requêtes préparées. 

Comme pour la méthode ``selectAll()`` les méthodes `insert()` et `update()` utilisent un tableau  en paramètre pour faire un where `` ['colonne', 'condition', 'valeur']`` ou ``['colonne','valeur']`` si la condition est un ``=``.

#### delete ( )
La métode `delete()` permet de supprimer rapidement des éléments d'une table.
Elle prend en paramètre `le nom d'une table` et `un tableau` permettent de faire un where.

```php
Db::delete('users', ['prenom', '!=', 'Arthur'] );
```

#### insert ( ) 
La méthode `insert()` permet d'insérer rapidement un tuple dans une table.
Elle prend en paramètre `le nom d'une table` et `un tableau` sous la forme ``['nom_de_la_colonne' => 'valeur', ...]``.

```php
Db::insert( 'users', ['prenom' => 'Arthur', 'age' => 20, 'pays' => 'france']);
```

#### update ( )

La méthode `update()` permet de mettre à jour rapidement un tuple ou plusieurs tuples dans une table.
Elle prend en paramètre `le nom d'une table` , `un tableau` sous la forme ``['nom_de_la_colonne' => 'valeur', ...]`` qui sont les valeurs à mettre a jour et `un tableau` permet de faire un where.

```php
Db::update( 'users', ['prenom' => 'Arthur'], ['id', 5] ); 
```

___

### Créer ses propes méthodes

Il est possible de créer facilement ses propres méthodes, cela peut être pratique si vous utilisez plusieurs fois la même requête.


1. Ouvrir le fichier Db.php
2. Créer une fonction statique avec les paramètres voulu ( vous n'êtes pas obligé de mettre de paramètre).
3. Faites votre traitement et retourné la valeur voulue. Vous pouvez réutiliser toutes les méthodes vu précédemment dans votre méthode, pour cela faite ``self::nom_de_la_méthode``.
```php
//exemple:
self::select( ...);
self::find( ...);
``` 
4. Vous pouvez maintenant l'appeler , depuis votre code  ``Db::nom_votre_méthode`` !


Exemple:
Nous souhaitons créer une méthode qui va nous permettre de lister tous les **users** ayant un age compris entre deux valeurs.


```php 
class Db extends DbQuery  {

	public static function ageBetween($ageMin,$ageMax)
	{
		return self::select('select * from users where age > :ageMin and age < :ageMax', ['ageMin' => $ageMin, 'ageMax' => $ageMax]);
	}

}
```
Vous pouvez maintenant faire 
```php
Db::ageBetween(18,25);
```


___

Licence : MIT






