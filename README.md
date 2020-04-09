# L'application web de l'A.E.E.S. et sa documentation
## Installation
### Composer
Installer les dépendances
```
composer install
```
### Build assets
Installer les dépendances
```
yarn install
```
Compiler les assets
```
yarn run encore production
```
Installer CKEditor
```
php bin/console ckeditor:install
```
Ajouter les assets de bundles dans public
```
php bin/console assets:install public
```
### Uploads
Permettre l'application d'ajouter des fichiers d'upload
```
chmod g+w -R public/upload/
```
### Base de données
Créer les tables dans la database
```
php bin/console doctrine:migrations:migrate
```