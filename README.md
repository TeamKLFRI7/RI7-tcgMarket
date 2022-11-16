## Première installation

Exécuter la commande : `composer install`

Lancer l'application via la commande : `symfony serve`

### Création de la base de donnée

Utilisé la commande : `php bin/console d:m:m` pour créer les tables
dans la base donnée

## Accéder au front



## Lancer les tests

Lancement des tests : `bin/tests run backend`

Exemples:
- lancer les tests User : `php bin/phpunit tests/Unit/UserTest.php --testdox`
- lancer uniquement le test UserIsValid dans User : `php bin/phpunit --filter userIsValid`
