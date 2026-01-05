<?php
session_start();
require_once "../../Classes/db.php";
require_once "../../Classes/client.php";

$db = DB::connect();
$clientObj = new client($db);
$clients = $clientObj->getAllClients();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion Clients | Admin</title>
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

    <!-- Sidebar -->
    <?php include 'sidebar.php'; ?>

    <!-- Main Content -->
    <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50">
        <div class="container mx-auto px-6 py-8">
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-gray-700 text-3xl font-black uppercase">Gestion des Clients</h3>
                <div class="relative">
                    <input type="text" placeholder="Rechercher un client..." class="pl-10 pr-4 py-2 border rounded-lg focus:outline-none focus:border-locar-orange">
                    <i class="fa-solid fa-search absolute left-3 top-3 text-gray-400"></i>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400 font-bold tracking-wider">
                            <th class="p-4">Nom Complet</th>
                            <th class="p-4">Email</th>
                            <th class="p-4">Date Inscription</th>
                            <th class="p-4">Statut</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($clients)): ?>
                            <tr>
                                <td colspan="5" class="p-4 text-center text-gray-500">Aucun client trouvé.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach($clients as $c): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold">
                                    <div class="flex items-center gap-3">
                                        <div class="w-8 h-8 rounded-full bg-gray-200 flex items-center justify-center text-gray-500 font-bold text-xs uppercase">
                                            <?= substr($c['full_name'], 0, 2) ?>
                                        </div>
                                        <?= htmlspecialchars($c['full_name']) ?>
                                    </div>
                                </td>
                                <td class="p-4 text-sm text-gray-500"><?= htmlspecialchars($c['email']) ?></td>
                                <td class="p-4 text-sm text-gray-500"><?= date('d M Y', strtotime($c['created_at'])) ?></td>
                                <td class="p-4">
                                    <span class="px-2 py-1 rounded text-xs font-bold uppercase 
                                        <?= $c['is_active'] ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' ?>">
                                        <?= $c['is_active'] ? 'Actif' : 'Inactif / Banni' ?>
                                    </span>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <form action="actions/client_action.php" method="POST" class="inline">
                                        <input type="hidden" name="user_id" value="<?= $c['id'] ?>">
                                        <?php if ($c['is_active']): ?>
                                            <button type="submit" name="ban_user" class="text-red-500 hover:text-red-700 font-bold text-xs border border-red-200 bg-red-50 px-3 py-1 rounded transition" onclick="return confirm('Bannir cet utilisateur ?')">
                                                <i class="fa-solid fa-ban mr-1"></i> BANNIR
                                            </button>
                                        <?php else: ?>
                                            <button type="submit" name="activate_user" class="text-green-500 hover:text-green-700 font-bold text-xs border border-green-200 bg-green-50 px-3 py-1 rounded transition">
                                                <i class="fa-solid fa-check mr-1"></i> ACTIVER
                                            </button>
                                        <?php endif; ?>
                                    </form>
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
