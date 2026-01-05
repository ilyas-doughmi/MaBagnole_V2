<?php
session_start();
require_once '../../Classes/db.php';
require_once '../../Classes/vehicle.php';
require_once '../../Classes/Reservation.php';
require_once '../../Classes/Review.php';

$db = DB::connect();
$vehicleObj = new vehicle($db);
$reservationObj = new Reservation($db);
$reviewObj = new Review($db);

$stats = [
    'cars' => $vehicleObj->getTotalVehicles(),
    'reservations' => $reservationObj->getTotalReservations(),
    'earnings' => number_format($reservationObj->calculateEarnings(), 2),
    'reviews' => $reviewObj->getTotalReviews()
];
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard | MaBagnole</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Nunito Sans', 'sans-serif'] },
                    colors: { 'locar-orange': '#FF5F00', 'locar-black': '#1a1a1a' }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex h-screen overflow-hidden">

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
        <div class="container mx-auto px-6 py-8">
            <h3 class="text-gray-700 text-3xl font-black uppercase mb-8">Dashboard</h3>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
                <!-- Card 1 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-orange-100 text-locar-orange mr-4">
                        <i class="fa-solid fa-car text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase">Total Véhicules</p>
                        <p class="text-2xl font-black text-gray-800"><?= $stats['cars'] ?></p>
                    </div>
                </div>
                <!-- Card 2 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-blue-100 text-blue-500 mr-4">
                        <i class="fa-solid fa-calendar-check text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase">Réservations</p>
                        <p class="text-2xl font-black text-gray-800"><?= $stats['reservations'] ?></p>
                    </div>
                </div>
                <!-- Card 3 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-green-100 text-green-500 mr-4">
                        <i class="fa-solid fa-wallet text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase">Revenus</p>
                        <p class="text-2xl font-black text-gray-800"><?= $stats['earnings'] ?>$</p>
                    </div>
                </div>
                <!-- Card 4 -->
                <div class="bg-white rounded-xl p-6 shadow-sm border border-gray-100 flex items-center">
                    <div class="p-3 rounded-full bg-yellow-100 text-yellow-500 mr-4">
                        <i class="fa-solid fa-star text-2xl"></i>
                    </div>
                    <div>
                        <p class="text-gray-500 text-xs font-bold uppercase">Avis Clients</p>
                        <p class="text-2xl font-black text-gray-800"><?= $stats['reviews'] ?></p>
                    </div>
                </div>
            </div>

            <!-- Recent Activity / Charts Placeholder -->
            <div class="bg-white rounded-xl shadow-sm border border-gray-100 p-8">
                <h4 class="text-lg font-bold text-gray-700 mb-4">Activité Récente</h4>
                <div class="h-64 bg-gray-50 rounded flex items-center justify-center text-gray-400 font-bold">
                    Graphique des réservations (Placeholder)
                </div>
            </div>
        </div>
    </main>

</body>
</html>
