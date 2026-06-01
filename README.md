# Cabinet Médical — Gestion des Rendez-vous

Application web de gestion de rendez-vous médicaux développée avec Laravel 12.

## Technologies utilisées

- Laravel 12
- MySQL
- Bootstrap 4
- Axios
- Mailtrap (emails)

## Installation

### Prérequis
- PHP >= 8.2
- Composer
- MySQL

### Étapes

1. Cloner le projet
```bash
git clone https://github.com/hamzamhl1/Cabinet_Medical.git
cd cabinet-medical
```

2. Installer les dépendances
```bash
composer install
npm install
npm run build
```

3. Copier le fichier d'environnement
```bash
cp .env.example .env
php artisan key:generate
```

4. Configurer la base de données dans `.env`
```env
DB_DATABASE=cabinet_medical
DB_USERNAME=root
DB_PASSWORD=
```

5. Lancer les migrations et seeders
```bash
php artisan migrate --seed
```

6. Lancer le serveur
```bash
php artisan serve
```

## Identifiants par défaut

| Rôle | Email | Mot de passe |
|---|---|---|
| Admin | admin@cabinet.com | password |
| Médecin | généré par seeder | password |
| Patient | généré par seeder | password |

## Fonctionnalités

- Authentification custom (login, register)
- Gestion des rendez-vous (CRUD complet)
- Recherche dynamique Axios
- Confirmation par email
- Internationalisation FR/EN
- API REST (endpoints JSON)
- Tableau de bord selon le rôle
- Gestion des médecins et patients par l'admin

## Endpoints API REST

| Méthode | URL | Description |
|---|---|---|
| GET | `/api/appointments` | Liste tous les RDV |
| GET | `/api/appointments/{id}` | Détail d'un RDV |
| POST | `/api/appointments` | Créer un RDV |
| PUT | `/api/appointments/{id}` | Modifier un RDV |
| DELETE | `/api/appointments/{id}` | Supprimer un RDV |

## Configuration Email (Mailtrap)

Dans `.env` :
```env
MAIL_MAILER=smtp
MAIL_HOST=sandbox.smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=your_username
MAIL_PASSWORD=your_password
MAIL_FROM_ADDRESS=cabinet@medical.com
MAIL_FROM_NAME="Cabinet Médical"
```

## Auteur

**Hamza Mechaal** — OFPPT Tétouan, Développement Digital
