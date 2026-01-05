<?php
session_start();
require_once "../../Classes/db.php";
require_once "../../Classes/Reservation.php";

$db = DB::connect();
$reservationObj = new Reservation($db);
$reservations = $reservationObj->getAllReservations();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Réservations | Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Nunito Sans', 'sans-serif'] },
                    colors: { 'locar-orange': '#FF3B00', 'locar-black': '#1a1a1a' }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 text-gray-800 antialiased flex h-screen overflow-hidden">

    <?php include 'sidebar.php'; ?>

    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
        <div class="container mx-auto px-6 py-8">
            <h3 class="text-gray-700 text-3xl font-black uppercase mb-8">Réservations</h3>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400 font-bold tracking-wider">
                            <th class="p-4">ID</th>
                            <th class="p-4">Client</th>
                            <th class="p-4">Véhicule</th>
                            <th class="p-4">Dates</th>
                            <th class="p-4">Statut</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($reservations)): ?>
                            <tr><td colspan="6" class="p-4 text-center text-gray-500">Aucune réservation.</td></tr>
                        <?php else: ?>
                            <?php foreach($reservations as $r): 
                                $statusClass = 'bg-yellow-100 text-yellow-600';
                                $statusLabel = 'En attente';
                                $isFinished = false;

                                if ($r['reservation_status'] === 'confirmed') {
                                    if (strtotime($r['end_date']) < time()) {
                                        $statusClass = 'bg-gray-100 text-gray-500';
                                        $statusLabel = 'Terminée';
                                        $isFinished = true;
                                    } else {
                                        $statusClass = 'bg-green-100 text-green-600';
                                        $statusLabel = 'Confirmée';
                                    }
                                } elseif ($r['reservation_status'] === 'cancelled') {
                                    $statusClass = 'bg-red-100 text-red-600';
                                    $statusLabel = 'Annulée';
                                } elseif ($r['reservation_status'] === 'completed') {
                                    $statusClass = 'bg-gray-100 text-gray-500';
                                    $statusLabel = 'Terminée';
                                }
                            ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-500">#<?= $r['reservation_id'] ?></td>
                                <td class="p-4">
                                    <p class="font-bold"><?= htmlspecialchars($r['full_name']) ?></p>
                                    <p class="text-xs text-gray-400"><?= htmlspecialchars($r['email']) ?></p>
                                </td>
                                <td class="p-4 text-sm font-bold"><?= htmlspecialchars($r['brand'] . ' ' . $r['model']) ?></td>
                                <td class="p-4 text-sm text-gray-500"><?= date('d/m/Y', strtotime($r['start_date'])) ?>  <br> <?= date('d/m/Y', strtotime($r['end_date'])) ?></td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase <?= $statusClass ?>"><?= $statusLabel ?></span>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <?php if (!$isFinished && $r['reservation_status'] !== 'cancelled'): ?>
                                    <form action="actions/reservation_action.php" method="POST" class="inline">
                                        <input type="hidden" name="reservation_id" value="<?= $r['reservation_id'] ?>">
                                        <button type="submit" name="confirm_reservation" class="text-green-500 hover:text-green-700" title="Confirmer"><i class="fa-solid fa-check"></i></button>
                                    </form>
                                    <form action="actions/reservation_action.php" method="POST" class="inline">
                                        <input type="hidden" name="reservation_id" value="<?= $r['reservation_id'] ?>">
                                        <button type="submit" name="cancel_reservation" class="text-red-500 hover:text-red-700" title="Annuler"><i class="fa-solid fa-xmark"></i></button>
                                    </form>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</body>
</html>
