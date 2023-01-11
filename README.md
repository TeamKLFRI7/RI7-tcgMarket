# Installation Stack de développement

## macOS

Afin d'améliorer les performances sous macOS, vous pouvez activer VirtioFS depuis les paramètres de Docker Desktop
(section _Experimental features_).

Cette fonctionnalité demande MacOS 12.2.1 (Apple Silicon) ou 12.3 (Intel).


## Première installation (Installation des dépendances, création de la base de données...)

ATTENTION : Cette commande réinitialise la base de données.

Se mettre sur la branche develop `git checkout develop`

Afin d'effectuer la première installation, exécuter la commande `make install`

## Démarrage de la stack

Pour démarrer la stack, lancer la commande `make up`.

## Accéder au front

Le port utilisé est le 8000.
symfony app : https://127.0.0.1.com:8000
api app : https://127.0.0.1.com:8000/api

Le port utilisé par phpmyadmin est le 8080
vue phpmyadmin : https://127.0.0.1.com:8080

## Lancer les tests

Lancement des tests : `bin/tests run backend`

Exemples:
- lancer les tests User : `php bin/phpunit tests/Unit/UserTest.php --testdox`
- lancer uniquement le test UserIsValid dans User : `php bin/phpunit --filter userIsValid`
