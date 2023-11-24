# Evaluation

L'évaluation consiste à créer un projet avec toutes les différentes notions qui auront été vues durant la semaine. Ce projet sera rendu sous la forme d'un depôt git.

[Url avec les dépôts git](https://docs.google.com/spreadsheets/d/1FG3mYVUH5kBjLPXZZQVMIb7DD8_pxTwnOaADXVqViBk/edit#gid=0)

## Projet

Le projet à faire pour cette semaine sera un site de gestion d'événements, créés par les utilisateurs pour d'autres utilisateurs.

### Fonctionalités

* Inscription [OK]
* Connexion/Déconnexion [OK]
* Créer un événement [OK]
* Liste des événements [OK]
* Modifier un événement (si on en est l'auteur) [OK]
* Supprimer un événement (si on en est l'auteur) [OK]
* Créer un commentaire sur la page de l'événement [todo]
* Voir les informations de son compte (à part le mot de passe) [OK]
* Modifier le mot de passe [Bof :p]
* S'inscrire/se désinscrire à un événement [OK]

### Données [OK]

* User (email, name, password, createdAt, updatedAt)
* Event (title, description, address, city, postalCode, startAt, createdAt, updatedAt, category, user)
* Category (name)

### Pages

#### Accueil

Afficher les 5 derniers événements créés.

#### Inscription [OK]

Afficher un formulaire d'inscription avec l'email qui servira d'identifiant et un pseudo.

#### Connexion [OK] 

Afficher un formulaire de connexion qui permet à l'utilisateur de se connecter avec son email.

#### Liste des événements 

Afficher la liste de tous les événements avec un système de pagination. Chaque événement propose un lien qui envoie vers le détail de l'événement.

#### Détail de l'événement [OK]

Lorsque l'on va sur cette page, on veut afficher toutes les informations de l'événement, un lien pour s'inscrire à l'événement, les commentaires.

La liste des utilisateurs inscrits à l'événement est affichée. [OK]

Afficher le formulaire de création d'un commentaire.

#### Profil de l'utilisateur 

Permet de voir quelles sont les informations de l'utilisateur (email, pseudo) et la liste des événements créés par l'utilisateur.

Sur le profil l'utilisateur a possibilité de modifier son mot de passe.

#### Créer un événement

Afficher un formulaire de création d'événement et gérer la soumission. Lorsque l'événement a été créé on est redirigé vers la page "Liste des événements".

#### Modifier un événement

Permet de modifier un événement créé par l'utilisateur (sinon renvoyer erreur 403).

#### Supprimer un événement

Permet de supprimer un événement créé par l'utilisateur (sinon renvoyer erreur 403).

#### Inscription à un événement

L'utilisateur peut s'inscrire à un événement en cliquant sur le lien "S'inscrire à un événement" présent sur la page d'un événement.

[BONUS] Gérer différents cas : si l'utilisateur est inscrit à un événement au même moment, il ne peut pas s'inscrire à l'événement.

#### [BONUS++] Liste des événements proches de la position de l'utilisateur

Afficher la liste des événements proches de la position de l'utilisateur.

### Validation des données

Bien valider les données à chaque soumission de formulaire (champs obligatoires, taille de certains champs, l'email de l'utilisateur doit être unique, le mot de passe doit faire au-moins 8 caractères...).