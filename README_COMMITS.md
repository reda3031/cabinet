# Decoupage du projet et commits proposes

Ce fichier sert a organiser le projet en petites parties afin de faire des commits propres et faciles a presenter.

## Avant de commencer

Ne pas ajouter les fichiers generes ou sensibles :

- `.env`
- `vendor/`
- `node_modules/`
- `storage/logs/`

Verifier l'etat du projet :

```bash
git status
```

## Ordre conseille des commits

Le projet est deja complet. Si un meme fichier apparait dans plusieurs parties, utiliser `git add -p chemin/du/fichier` pour choisir uniquement les lignes de la partie a commiter.

### 1. Initialisation du projet Laravel

**Elements du projet**

- Structure Laravel
- Configuration Composer et NPM
- Fichiers publics et configuration de base

**Fichiers principaux**

- `artisan`
- `composer.json`
- `composer.lock`
- `package.json`
- `package-lock.json`
- `bootstrap/`
- `config/`
- `public/`
- `routes/console.php`
- `vite.config.js`

**Commit**

```bash
git add artisan composer.json composer.lock package.json package-lock.json bootstrap config public routes/console.php vite.config.js .editorconfig .gitattributes .gitignore
git commit -m "Initialiser le projet Laravel"
```

### 2. Base de donnees et modeles

**Elements du projet**

- Modeles `User`, `Service`, `Appointment`
- Migrations de la base de donnees
- Factories et seeders

**Fichiers principaux**

- `app/Models/`
- `database/migrations/`
- `database/factories/`
- `database/seeders/`

**Commit**

```bash
git add app/Models database/migrations database/factories database/seeders
git commit -m "Ajouter les modeles et la base de donnees"
```

### 3. Authentification et roles

**Elements du projet**

- Connexion
- Inscription patient
- Deconnexion
- Gestion des roles `admin`, `medecin`, `patient`

**Fichiers principaux**

- `app/Http/Controllers/Auth/AuthController.php`
- `resources/views/auth/`
- `routes/web.php`

**Commit**

```bash
git add app/Http/Controllers/Auth/AuthController.php resources/views/auth routes/web.php
git commit -m "Ajouter l'authentification et les roles"
```

### 4. Gestion des rendez-vous

**Elements du projet**

- Creation de rendez-vous
- Liste des rendez-vous
- Modification
- Suppression / annulation
- Filtrage selon le role de l'utilisateur

**Fichiers principaux**

- `app/Http/Controllers/AppointmentController.php`
- `resources/views/appointments/`
- `resources/views/dashboard.blade.php`
- `routes/web.php`

**Commit**

```bash
git add app/Http/Controllers/AppointmentController.php resources/views/appointments resources/views/dashboard.blade.php routes/web.php
git commit -m "Ajouter la gestion des rendez-vous"
```

### 5. Administration des medecins et patients

**Elements du projet**

- Liste des medecins
- Ajout et suppression de medecins
- Liste des patients
- Historique des rendez-vous d'un patient

**Fichiers principaux**

- `app/Http/Controllers/AdminController.php`
- `resources/views/admin/`
- `routes/web.php`

**Commit**

```bash
git add app/Http/Controllers/AdminController.php resources/views/admin routes/web.php
git commit -m "Ajouter l'administration des medecins et patients"
```

### 6. Recherche dynamique avec Axios

**Elements du projet**

- Recherche des rendez-vous
- Recherche des medecins
- Recherche des patients
- Reponses JSON pour les vues dynamiques

**Fichiers principaux**

- `app/Http/Controllers/AppointmentController.php`
- `app/Http/Controllers/AdminController.php`
- `resources/js/`
- `resources/views/appointments/index.blade.php`
- `resources/views/admin/doctors.blade.php`
- `resources/views/admin/patients.blade.php`
- `routes/web.php`

**Commit**

```bash
git add app/Http/Controllers/AppointmentController.php app/Http/Controllers/AdminController.php resources/js resources/views/appointments/index.blade.php resources/views/admin/doctors.blade.php resources/views/admin/patients.blade.php routes/web.php
git commit -m "Ajouter la recherche dynamique avec Axios"
```

### 7. API REST des rendez-vous

**Elements du projet**

- Endpoints JSON pour les rendez-vous
- CRUD API
- Chargement des relations patient, medecin et service

**Fichiers principaux**

- `app/Http/Controllers/Api/AppointmentApiController.php`
- `routes/api.php`

**Commit**

```bash
git add app/Http/Controllers/Api/AppointmentApiController.php routes/api.php
git commit -m "Ajouter l'API REST des rendez-vous"
```

### 8. Emails de confirmation

**Elements du projet**

- Mail de confirmation apres creation d'un rendez-vous
- Vue Blade de l'email
- Configuration Mailtrap via `.env`

**Fichiers principaux**

- `app/Mail/AppointmentConfirmed.php`
- `resources/views/emails/appointment-confirmed.blade.php`
- `app/Http/Controllers/AppointmentController.php`
- `.env.example`

**Commit**

```bash
git add app/Mail/AppointmentConfirmed.php resources/views/emails/appointment-confirmed.blade.php app/Http/Controllers/AppointmentController.php .env.example
git commit -m "Ajouter les emails de confirmation"
```

### 9. Internationalisation FR/EN

**Elements du projet**

- Fichiers de traduction francais et anglais
- Middleware de langue
- Route de changement de langue

**Fichiers principaux**

- `app/Http/Middleware/SetLocale.php`
- `resources/lang/`
- `bootstrap/app.php`
- `routes/web.php`

**Commit**

```bash
git add app/Http/Middleware/SetLocale.php resources/lang bootstrap/app.php routes/web.php
git commit -m "Ajouter l'internationalisation FR EN"
```

### 10. Interfaces et mise en page

**Elements du projet**

- Layout principal
- Layout d'authentification
- Page d'accueil
- Styles et assets frontend

**Fichiers principaux**

- `resources/views/layouts/`
- `resources/views/welcome.blade.php`
- `resources/css/`
- `resources/js/`

**Commit**

```bash
git add resources/views/layouts resources/views/welcome.blade.php resources/css resources/js
git commit -m "Ajouter les interfaces utilisateur"
```

### 11. Tests et documentation

**Elements du projet**

- Configuration des tests
- README principal
- README de decoupage des commits

**Fichiers principaux**

- `tests/`
- `phpunit.xml`
- `README.md`
- `README_COMMITS.md`

**Commit**

```bash
git add tests phpunit.xml README.md README_COMMITS.md
git commit -m "Ajouter la documentation et les tests"
```

## Verification finale

Apres les commits :

```bash
git log --oneline
git status
```

Si un fichier a ete oublie :

```bash
git add chemin/du/fichier
git commit -m "Ajouter le fichier oublie"
```
