# 🎓 ENSAT - Système de Gestion des Étudiants

![Laravel](https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![Firebase](https://img.shields.io/badge/Firebase-FFCA28?style=for-the-badge&logo=firebase&logoColor=black)
![MySQL](https://img.shields.io/badge/MySQL-4479A1?style=for-the-badge&logo=mysql&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)

Application Laravel avec authentification Firebase pour la gestion des étudiants de l'ENSAT.

## 📋 Table des Matières
- [Architecture](#🏗️-architecture)
- [Fonctionnalités](#✨-fonctionnalités)
- [Installation](#🚀-installation)
- [Configuration](#⚙️-configuration)
- [Structure du Projet](#📁-structure-du-projet)
- [Sécurité](#🔒-sécurité)
- [Dépannage](#🐛-dépannage)
- [Contribution](#🤝-contribution)


## 🏗️ Architecture

Cette application utilise une architecture d'authentification hybride :

- **Frontend** : Firebase Authentication (Google OAuth)
- **Backend** : Laravel Session Authentication
- **Base de données** : MySQL/SQLite
- **Rôles** : Admin et Étudiant

### Technologies Utilisées
- **Laravel 12** - Framework PHP
- **Firebase Authentication** - Authentification Google OAuth
- **Kreait Firebase PHP SDK** - Vérification des tokens côté serveur
- **Laravel Breeze** - Scaffolding d'authentification
- **Tailwind CSS** - Framework CSS

## ✨ Fonctionnalités

### Pour les Administrateurs
- ✅ CRUD complet des étudiants (Créer, Lire, Modifier, Supprimer)
- ✅ Gestion des profils étudiants
- ✅ Accès à l'espace d'administration protégé
- ✅ Interface responsive avec Tailwind CSS

### Pour les Étudiants
- ✅ Connexion via Google (Firebase)
- ✅ Connexion classique (Email/Mot de passe)
- ✅ Visualisation du profil personnel
- ✅ Modification du mot de passe
- ✅ Réinitialisation du mot de passe oublié

## 🔐 Flux d'Authentification

### 1. Page de Connexion
Deux méthodes d'authentification disponibles :

**Méthode A : Connexion classique (Email/Password)**
```
Étudiant → Formulaire login → Laravel Auth → Validation → Session → Dashboard
```

**Méthode B : Connexion avec Google (Firebase)**
```
Étudiant → Bouton Google → Firebase SDK → Google OAuth → JWT Token → Laravel
```

### 2. Processus de Vérification Firebase
1. Frontend récupère le JWT de Firebase
2. JWT envoyé à `/google-login`
3. Laravel vérifie le token avec Firebase Admin SDK
4. Création/mise à jour de l'utilisateur en base de données
5. Ouverture de session Laravel
6. Redirection vers le dashboard selon le rôle

## 🚀 Installation

### Prérequis
- PHP 8.2+
- Composer
- Node.js & NPM
- MySQL ou SQLite
- Compte Firebase (projet configuré)

### Étapes d'Installation

1. **Cloner le repository**
```bash
git clone <votre-repo>
cd ensat-gestion-etudiants
```

2. **Installer les dépendances PHP**
```bash
composer install
```

3. **Installer les dépendances JavaScript**
```bash
npm install
```

4. **Configurer l'environnement**
```bash
cp .env.example .env
php artisan key:generate
```

5. **Configurer la base de données**
Éditer `.env` :
```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=ensat_gestion
DB_USERNAME=root
DB_PASSWORD=
```

6. **Exécuter les migrations**
```bash
php artisan migrate
```

7. **Compiler les assets**
```bash
npm run build
# Ou pour le développement : npm run dev
```

8. **Lancer le serveur**
```bash
php artisan serve
```

L'application sera accessible sur http://localhost:8000

## ⚙️ Configuration Firebase

### 1. Créer un Projet Firebase
1. Aller sur [Firebase Console](https://console.firebase.google.com/)
2. Créer un nouveau projet
3. Activer Authentication → Google Sign-In

### 2. Télécharger les Credentials
1. Aller dans Project Settings → Service Accounts
2. Cliquer sur "Generate new private key"
3. Télécharger le fichier JSON
4. Renommer en `ensat-gestion-etudiants-firebase-adminsdk.json`
5. Placer à la racine du projet

### 3. Configurer les Variables d'Environnement
Éditer `.env` :

```env
# Firebase Web Config (pour le frontend)
FIREBASE_API_KEY=your_api_key
FIREBASE_AUTH_DOMAIN=your_project.firebaseapp.com
FIREBASE_PROJECT_ID=your_project_id
FIREBASE_STORAGE_BUCKET=your_project.appspot.com
FIREBASE_MESSAGING_SENDER_ID=your_sender_id
FIREBASE_APP_ID=your_app_id

# Firebase Admin SDK (pour le backend)
FIREBASE_CREDENTIALS=ensat-gestion-etudiants-firebase-adminsdk.json
```

### 4. Ajouter les Domaines Autorisés
Firebase Console → Authentication → Settings  
Ajouter :
- `localhost`
- Votre domaine de production

## 📁 Structure du Projet

```
ensat-gestion-etudiants/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Auth/
│   │   │   │   ├── GoogleController.php    # Gestion connexion Google
│   │   │   │   └── AuthenticatedSessionController.php
│   │   │   ├── EtudiantController.php      # CRUD étudiants (admin)
│   │   │   └── ProfilController.php        # Profil étudiant
│   │   └── Middleware/
│   │       └── CheckRole.php               # Vérification des rôles
│   ├── Models/
│   │   └── User.php                        # Modèle utilisateur
│   └── Providers/
│       └── FirebaseServiceProvider.php     # Service Provider Firebase
├── config/
│   ├── firebase.php                        # Configuration Firebase Admin SDK
│   └── services.php                        # Configuration Firebase Web
├── database/
│   └── migrations/                         # Migrations de base de données
├── resources/
│   └── views/
│       ├── auth/
│       │   ├── login.blade.php             # Page de connexion
│       │   └── forgot-password.blade.php   # Mot de passe oublié
│       ├── admin/etudiants/                # Vues CRUD admin
│       └── etudiant/profil.blade.php       # Profil étudiant
├── routes/
│   ├── web.php                             # Routes principales
│   └── auth.php                            # Routes d'authentification
└── ensat-gestion-etudiants-firebase-adminsdk.json
```

## 🔒 Sécurité

### Points de Sécurité Implémentés
- ✅ Vérification cryptographique des tokens Firebase
- ✅ Middleware de contrôle d'accès basé sur les rôles
- ✅ Protection CSRF sur tous les formulaires
- ✅ Rate limiting (5 tentatives de connexion)
- ✅ Sessions régénérées après connexion
- ✅ Cookies sécurisés (httpOnly, secure en production)

### Configuration SSL/TLS (Production)
```php
// app/Providers/FirebaseServiceProvider.php
$httpClient = new Client([
    'verify' => true, // ⚠️ Activer la vérification SSL en production
]);
```

## 👥 Rôles et Permissions

### Admin
- Accès à `/etudiants` (CRUD complet)
- Peut créer, modifier, supprimer des étudiants
- Accès au dashboard admin

### Étudiant
- Accès à `/profil` (lecture seule)
- Peut modifier son mot de passe
- Accès au dashboard étudiant

## 🐛 Dépannage

### Erreur cURL 60 (SSL Certificate)
**Problème** : Laravel ne peut pas vérifier les certificats SSL de Google.

**Solution développement** :
```php
// app/Providers/FirebaseServiceProvider.php
'verify' => false,
```

**Solution production** :
- Installer les certificats CA sur le serveur
- Spécifier le chemin du fichier `cacert.pem` dans `php.ini`

### Token Firebase Invalide
**Vérifications** :
1. Le `projectId` dans `.env` correspond au projet Firebase
2. Le fichier JSON des credentials est présent
3. Les clés publiques Google sont accessibles
4. Le token n'est pas expiré (durée : 1 heure)

### Accès Refusé (403)
**Vérifications** :
1. L'utilisateur est bien connecté (session active)
2. Le rôle correspond à la route protégée
3. Vérifier la colonne `role` dans la table `users`

## 🤝 Contribution

1. Fork le projet
2. Créer une branche (`git checkout -b feature/AmazingFeature`)
3. Commit les changements (`git commit -m 'Add some AmazingFeature'`)
4. Push vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrir une Pull Request



## 📚 Ressources

- [Documentation Laravel](https://laravel.com/docs)
- [Documentation Firebase](https://firebase.google.com/docs)
- [Kreait Firebase PHP SDK](https://github.com/kreait/firebase-php)
- [Laravel Breeze](https://laravel.com/docs/starter-kits#laravel-breeze)

