# My Quizz - Site de Quiz Culture Générale

## Introduction
My Quizz est un site de quiz en ligne qui permet aux utilisateurs de tester et d'améliorer leur culture générale. Les utilisateurs peuvent choisir parmi différentes catégories de quiz et répondre à une série de 10 ou 20 questions. Les résultats et les réponses sont affichés au fur et à mesure, question après question.

## Prérequis
Avant de commencer, assurez-vous d'avoir les outils suivants installés sur votre machine :
- PHP 7.4 ou plus récent
- Composer
- Symfony CLI
- MySQL ou un autre système de gestion de base de données compatible avec Symfony

## Installation
Suivez les étapes ci-dessous pour installer et lancer le projet My Quizz :

### 1. Cloner le Répertoire du Projet
```bash
git@github.com:Liilice/My-Quizz.git
cd quizmaster
```

### 2. Installer les Dépendances
Utilisez Composer pour installer les dépendances du projet.
```bash
composer install
```

### 3. Configurer la Base de Données
Allez dans le fichier `.env` à la racine du projet et configurez les informations de connexion à votre base de données.
```env
DATABASE_URL=mysql://db_user:db_password@127.0.0.1:3306/db_name
```

### 4. Créer la Base de Données
Utilisez les commandes Symfony pour créer la base de données et exécuter les migrations.
```bash
php bin/console doctrine:database:create
php bin/console doctrine:migrations:migrate
```

### 5. Lancer le Serveur de Développement Symfony
Démarrez le serveur Symfony en utilisant la commande suivante :
```bash
symfony server:start
```

Votre site de quiz devrait maintenant être accessible à l'adresse `http://127.0.0.1:8000` ou `localhost:8000`.

## Fonctionnalités Principales
- **Choix de Catégorie** : Les utilisateurs peuvent choisir parmi différentes catégories de quiz.
- **Séries de Questions** : Les utilisateurs peuvent choisir de répondre à une série de 10 ou 20 questions.
- **Profil Utilisateur** : Collecte d'informations sur les utilisateurs, leurs intérêts, habitudes et préférences pour personnaliser les quiz proposés.
