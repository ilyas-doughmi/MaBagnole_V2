<?php
session_start();
require_once "../../Classes/db.php";
require_once "../../Classes/Review.php";

$db = DB::connect();
$reviewObj = new Review($db);
$reviews = $reviewObj->getAllReviews();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Avis | Admin</title>
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
            <h3 class="text-gray-700 text-3xl font-black uppercase mb-8">Modération Avis</h3>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400 font-bold tracking-wider">
                            <th class="p-4">Client</th>
                            <th class="p-4">Véhicule</th>
                            <th class="p-4">Note</th>
                            <th class="p-4">Commentaire</th>
                            <th class="p-4">Statut</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if (empty($reviews)): ?>
                            <tr><td colspan="6" class="p-4 text-center text-gray-500">Aucun avis.</td></tr>
                        <?php else: ?>
                            <?php foreach($reviews as $r): 
                                $isDeleted = !empty($r['deleted_at']);
                            ?>
                            <tr class="hover:bg-gray-50 transition <?= $isDeleted ? 'opacity-50' : '' ?>">
                                <td class="p-4">
                                    <p class="font-bold"><?= htmlspecialchars($r['full_name']) ?></p>
                                    <p class="text-xs text-gray-400"><?= htmlspecialchars($r['email']) ?></p>
                                </td>
                                <td class="p-4 text-sm text-gray-500"><?= htmlspecialchars($r['brand'] . ' ' . $r['model']) ?></td>
                                <td class="p-4 text-yellow-500 text-sm">
                                    <?php for($i=0; $i<$r['rating']; $i++) echo '<i class="fa-solid fa-star"></i>'; ?>
                                </td>
                                <td class="p-4 text-sm italic text-gray-600 max-w-xs truncate">"<?= htmlspecialchars($r['comment']) ?>"</td>
                                <td class="p-4">
                                    <?php if ($isDeleted): ?>
                                        <span class="px-2 py-1 rounded text-xs font-bold uppercase bg-red-100 text-red-600">Supprimé</span>
                                    <?php else: ?>
                                        <span class="px-2 py-1 rounded text-xs font-bold uppercase bg-green-100 text-green-600">Publié</span>
                                    <?php endif; ?>
                                </td>
                                <td class="p-4 text-right space-x-2">
                                    <?php if ($isDeleted): ?>
                                        <form action="actions/review_action.php" method="POST" class="inline">
                                            <input type="hidden" name="review_id" value="<?= $r['review_id'] ?>">
                                            <button type="submit" name="restore_review" class="text-green-500 hover:text-green-700" title="Restaurer"><i class="fa-solid fa-rotate-left"></i></button>
                                        </form>
                                    <?php else: ?>
                                        <form action="actions/review_action.php" method="POST" class="inline">
                                            <input type="hidden" name="review_id" value="<?= $r['review_id'] ?>">
                                            <button type="submit" name="delete_review" class="text-red-500 hover:text-red-700" title="Supprimer"><i class="fa-solid fa-trash"></i></button>
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
