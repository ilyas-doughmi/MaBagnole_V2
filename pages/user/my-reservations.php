<?php
require_once '../../includes/guard.php';
require_once '../../Classes/db.php';
require_once '../../Classes/Reservation.php';

require_login();

$db = DB::connect();
$reservationObj = new Reservation($db);
$reservations = $reservationObj->getReservationsByUserId($_SESSION['id']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Réservations | MaBagnole</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Nunito Sans', 'sans-serif'],
                    },
                    colors: {
                        'locar-orange': '#FF5F00',
                        'locar-black': '#1a1a1a',
                        'locar-dark': '#0F0F0F',
                    },
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased">

    <?php 
    $root_path = '../../';
    include '../header.php'; 
    ?>

    <div class="pt-20 min-h-screen flex flex-col">
        
        <!-- Main Content -->
        <main class="flex-1 p-8 w-full">
            <div class="max-w-6xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-black uppercase text-gray-900">Mes Réservations</h1>
                        <p class="text-gray-500 font-medium mt-1">Consultez l'historique et l'état de vos locations.</p>
                    </div>
                </div>

                <!-- Reservations Table -->
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400 font-bold tracking-wider">
                                    <th class="p-6">Véhicule</th>
                                    <th class="p-6">Dates</th>
                                    <th class="p-6">Prix Total</th>
                                    <th class="p-6">Statut</th>
                                    <th class="p-6 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php foreach($reservations as $res): 
                                    $start = new DateTime($res['start_date']);
                                    $end = new DateTime($res['end_date']);
                                    $days = $start->diff($end)->days;
                                    if ($days < 1) $days = 1;
                                    $totalPrice = $days * ($res['price_per_day'] ?? 0);
                                    
                                    $statusClass = 'bg-yellow-100 text-yellow-600';
                                    $statusLabel = 'En attente';
                                    if ($res['reservation_status'] === 'confirmed') {
                                        if (strtotime($res['end_date']) < time()) {
                                            $statusClass = 'bg-gray-100 text-gray-500';
                                            $statusLabel = 'Terminée';
                                        } else {
                                            $statusClass = 'bg-green-100 text-green-600';
                                            $statusLabel = 'Confirmée';
                                        }
                                    } elseif ($res['reservation_status'] === 'cancelled') {
                                        $statusClass = 'bg-red-100 text-red-600';
                                        $statusLabel = 'Annulée';
                                    } elseif ($res['reservation_status'] === 'completed') {
                                        $statusClass = 'bg-gray-100 text-gray-500';
                                        $statusLabel = 'Terminée';
                                    }
                                ?>
                                <tr class="hover:bg-gray-50 transition group">
                                    <td class="p-6">
                                        <div class="flex items-center gap-4">
                                            <div class="w-16 h-12 bg-gray-100 rounded overflow-hidden flex-shrink-0">
                                                <img src="<?= htmlspecialchars($res['image'] ?? '') ?>" class="w-full h-full object-cover">
                                            </div>
                                            <div>
                                                <p class="font-black text-gray-800"><?= htmlspecialchars($res['brand'] . ' ' . $res['model']) ?></p>
                                                <p class="text-xs text-gray-400 font-bold">#<?= $res['reservation_id'] ?></p>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <div class="text-sm font-bold text-gray-600">
                                            <p><span class="text-gray-400 w-8 inline-block">Du:</span> <?= date('d/m/Y', strtotime($res['start_date'])) ?></p>
                                            <p><span class="text-gray-400 w-8 inline-block">Au:</span> <?= date('d/m/Y', strtotime($res['end_date'])) ?></p>
                                        </div>
                                    </td>
                                    <td class="p-6">
                                        <span class="font-black text-lg text-locar-orange"><?= number_format($totalPrice, 0) ?>$</span>
                                    </td>
                                    <td class="p-6">
                                        <span class="inline-block px-3 py-1 rounded-full text-xs font-black uppercase <?= $statusClass ?>">
                                            <?= $statusLabel ?>
                                        </span>
                                    </td>
                                    <td class="p-6 text-right">
                                        <a href="../vehicle-details.php?id=<?= $res['vehicle_id'] ?>" class="text-gray-400 hover:text-locar-orange transition">
                                            <i class="fa-solid fa-eye text-lg"></i>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if(empty($reservations)): ?>
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fa-solid fa-calendar-xmark text-2xl text-gray-400"></i>
                        </div>
                        <h3 class="font-bold text-gray-800 mb-2">Aucune réservation trouvée</h3>
                        <p class="text-gray-500 text-sm mb-6">Vous n'avez pas encore effectué de réservation.</p>
                        <a href="../vehicles.php" class="inline-block bg-black text-white font-bold py-3 px-6 rounded-lg hover:bg-locar-orange transition">
                            Réserver un véhicule
                        </a>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

</body>
</html>
