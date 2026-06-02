# Cabinet Médical - Gestion des Rendez-vous

Application web de gestion des rendez-vous d'un cabinet médical, développée avec Laravel 12.

## Cadre du projet

Ce projet est réalisé dans le cadre du Contrôle Continu 2.

| Élément | Information |
|---|---|
| Établissement | Office de la Formation Professionnelle et de la Promotion du Travail |
| Module | Développer en back end |
| Type d'évaluation | Contrôle Continu 2 |
| Sujet | Application web de gestion des rendez-vous d'un cabinet médical |

## Technologies utilisées

| Technologie | Version utilisée |
|---|---|
| Laravel | 12.57.0 |
| PHP | 8.4.19 |
| Laravel Sanctum | 4.3.1 |
| MySQL | 8.0+ |
| Bootstrap | 4.5.2 |
| jQuery | 3.5.1 |
| Axios | 1.15.2 |
| Vite | 7.3.2 |
| Laravel Vite Plugin | 2.1.0 |
| Tailwind CSS | 4.2.4 |
| Node.js | 25.2.1 |
| npm | 11.12.1 |
| Pest | 3.8.6 |
| Mailtrap | SMTP |

## Fonctionnalités

- Authentification personnalisée : connexion, inscription et déconnexion
- Gestion des rôles : admin, médecin et patient
- Tableau de bord selon le rôle de l'utilisateur
- Gestion complète des rendez-vous : ajout, modification, suppression et liste
- Recherche dynamique avec Axios
- Gestion des médecins par l'administrateur
- Gestion des patients et historique des rendez-vous
- Confirmation de rendez-vous par email
- Internationalisation FR/EN
- API REST pour les rendez-vous

## Prérequis

- PHP >= 8.2
- Composer
- Node.js et npm
- MySQL

## Installation

1. Cloner le projet

```bash
git clone https://github.com/reda3031/cabinet.git
cd cabinet
```

2. Installer les dépendances PHP et JavaScript

```bash
composer install
npm install
```

3. Copier le fichier d'environnement

```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de données dans `.env`

```env
DB_CONNECTION=mysql
DB_DATABASE=cabinet_medical
DB_USERNAME=root
DB_PASSWORD=
```

5. Lancer les migrations et les seeders

```bash
php artisan migrate --seed
```

6. Compiler les assets

```bash
npm run build
```

## Lancement du projet

Lancer le serveur Laravel :

```bash
php artisan serve
```

Pour travailler en mode développement avec Vite :

```bash
npm run dev
```

Le projet sera accessible par défaut sur :

```text
http://127.0.0.1:8000
```

## Identifiants par défaut

| Rôle | Email | Mot de passe |
|---|---|---|
| Admin | admin@cabinet.com | password |
| Médecin | généré par seeder | password |
| Patient | généré par seeder | password |

## Routes web principales

| URL | Description |
|---|---|
| `/login` | Page de connexion |
| `/registration` | Page d'inscription |
| `/dashboard` | Tableau de bord |
| `/appointments` | Liste des rendez-vous |
| `/appointments/create` | Création d'un rendez-vous |
| `/admin/doctors` | Gestion des médecins |
| `/admin/patients` | Gestion des patients |
| `/lang/fr` | Changer la langue en français |
| `/lang/en` | Changer la langue en anglais |

## Endpoints API REST

Les routes API utilisent le préfixe `/api`.

| Méthode | URL | Description |
|---|---|---|
| GET | `/api/appointments` | Liste tous les rendez-vous |
| GET | `/api/appointments/{id}` | Détail d'un rendez-vous |
| POST | `/api/appointments` | Créer un rendez-vous |
| PUT/PATCH | `/api/appointments/{id}` | Modifier un rendez-vous |
| DELETE | `/api/appointments/{id}` | Supprimer un rendez-vous |

## Configuration email avec Mailtrap

Dans le fichier `.env` :

```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=cabinet@medical.com
MAIL_FROM_NAME="Cabinet Médical"
```

## Structure du projet

| Dossier / fichier | Rôle |
|---|---|
| `app/Http/Controllers/` | Contrôleurs web et API |
| `app/Models/` | Modèles Eloquent |
| `app/Mail/` | Emails de l'application |
| `database/migrations/` | Structure de la base de données |
| `database/seeders/` | Données de test |
| `resources/views/` | Pages Blade |
| `resources/lang/` | Traductions FR/EN |
| `routes/web.php` | Routes web |
| `routes/api.php` | Routes API |

## Commandes utiles

Vider le cache Laravel :

```bash
php artisan optimize:clear
```

Afficher les routes :

```bash
php artisan route:list
```

Lancer les tests :

```bash
php artisan test
```

Formater le code PHP avec Pint :

```bash
./vendor/bin/pint
```

## Remarques importantes

- Ne pas commiter le fichier `.env`.
- Ne pas commiter les dossiers `vendor/` et `node_modules/`.
- Les routes API sont nommées avec le préfixe `api.appointments.*` pour éviter le conflit avec les routes web `appointments.*`.
- Après une modification de vue ou de configuration, utiliser `php artisan optimize:clear` si l'ancien affichage reste visible.

## Auteur

Hamza Mechaal - OFPPT Tétouan, Développement Digital
