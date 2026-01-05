# 🚗 MaBagnole - Plateforme de Location de Véhicules

MaBagnole est une plateforme complète de gestion de location de voitures développée en **PHP POO** avec **MySQL**.

---

## Fonctionnalités

### Client
- ✅ Authentification (Connexion / Inscription)
- ✅ Explorer les catégories de véhicules
- ✅ Consulter les détails d'un véhicule
- ✅ Réserver un véhicule avec dates
- ✅ Rechercher par marque/modèle
- ✅ Filtrer par catégorie (sans rafraîchissement)
- ✅ Consulter ses réservations

### Administrateur
- ✅ Dashboard avec statistiques
- ✅ Gestion des véhicules (CRUD)
- ✅ Gestion des catégories (CRUD)
- ✅ Gestion des clients (Activer/Bannir)
- ✅ Gestion des réservations (Confirmer/Annuler)

---

## Structure du Projet

```
MaBagnole/
├── Classes/
│   ├── db.php              # Connexion PDO
│   ├── user.php            # Classe User
│   ├── client.php          # Classe Client (hérite de User)
│   ├── vehicle.php         # Classe Vehicle
│   ├── Category.php        # Classe Category
│   └── Reservation.php     # Classe Reservation
├── includes/
│   ├── guard.php           # Fonctions d'authentification
│   └── logout.php          # Déconnexion
├── pages/
│   ├── admin/
│   │   ├── dashboard.php   # Tableau de bord
│   │   ├── vehicles.php    # Gestion véhicules
│   │   ├── categories.php  # Gestion catégories
│   │   ├── clients.php     # Gestion clients
│   │   ├── reservations.php# Gestion réservations
│   │   └── actions/        # Handlers POST
│   ├── user/
│   │   └── my-reservations.php
│   ├── vehicles.php        # Liste véhicules (public)
│   ├── vehicle-details.php # Détails véhicule
│   ├── login.php           # Connexion
│   └── inscription.php     # Inscription
├── sql/
│   └── install.sql         # Script SQL
└── index.php               # Page d'accueil
```

---

## Base de Données

### Tables
| Table | Description |
|-------|-------------|
| `users` | Utilisateurs (clients et admins) |
| `category` | Catégories de véhicules |
| `vehicle` | Véhicules disponibles |
| `reservation` | Réservations |
| `review` | Avis clients |

### Installation
```sql
-- Exécuter le fichier sql/install.sql dans phpMyAdmin
SOURCE sql/install.sql;
```

---

## Installation

1. **Cloner le projet** dans `htdocs` (XAMPP)
```bash
git clone <repo> c:/xampp/htdocs/MaBagnole
```

2. **Importer la base de données**
   - Ouvrir phpMyAdmin
   - Importer `sql/install.sql`

3. **Configurer la connexion DB** dans `Classes/db.php`
```php
$host = "localhost";
$dbname = "mabagnole";
$user = "root";
$password = "";
```

4. **Accéder au site**
```
http://localhost/mabagnole/
```

---

## Comptes par défaut

| Email | Mot de passe | Rôle |
|-------|--------------|------|
| admin@gmail.com | admin123 | Admin |

---

## Technologies

- **Backend** : PHP 8+ (POO, PDO)
- **Base de données** : MySQL
- **Frontend** : HTML5, TailwindCSS, Font Awesome
- **Serveur** : XAMPP / WAMP

---

## Classes PHP

### Vehicle
```php
getVehicles()           // Liste tous les véhicules
searchVehicles($search) // Recherche par marque/modèle
getVehicleById($id)     // Détails d'un véhicule
addVehicle()            // Ajouter
updateVehicle($id)      // Modifier
deleteVehicle($id)      // Supprimer
```

### Reservation
```php
createReservation()             // Créer
getReservationsByUserId($id)    // Réservations d'un user
getAllReservations()            // Toutes (admin)
updateStatus($id, $status)      // Confirmer/Annuler
```

### Client
```php
getAllClients()     // Liste clients
activateUser($id)   // Activer compte
banUser($id)        // Bannir compte
```