<?php
session_start();
require_once "../../Classes/db.php";
require_once "../../Classes/Tag.php";

$db = DB::connect();
$tagObj = new Tag($db);
$tags = $tagObj->getTags();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Tags | Admin</title>
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
            <div class="flex justify-between items-center mb-8">
                <h3 class="text-gray-700 text-3xl font-black uppercase">Tags</h3>
                <div class="flex gap-3">
                    <button onclick="openModal('addModal')" class="bg-locar-orange hover:bg-black text-white font-bold py-2 px-4 rounded shadow transition">
                        <i class="fa-solid fa-plus mr-2"></i> Ajouter
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden max-w-3xl">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400 font-bold tracking-wider">
                            <th class="p-4">ID</th>
                            <th class="p-4">Nom du tag</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php if($tags): ?>
                            <?php foreach($tags as $t): ?>
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-4 font-bold text-gray-500">#<?= $t['tagId'] ?></td>
                                <td class="p-4 font-bold"><?= $t['name'] ?></td>
                                <td class="p-4 text-right space-x-2 flex justify-end">
                                    <form action="actions/tag_action.php" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                        <input type="hidden" name="tag_id" value="<?= $t['tagId'] ?>">
                                        <button type="submit" name="delete_tag" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3" class="p-4 text-center">Aucun tag trouvé.</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>

    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/80 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white w-full max-w-lg rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-black text-xl uppercase">Ajouter un tag</h3>
                <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-black">✕</button>
            </div>
            <form action="actions/tag_action.php" class="space-y-4" method="POST">
                <div>
                    <input type="text" name="tag_name" placeholder="Nom du tag" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none" required>
                </div>
                <button type="submit" name="add_tag" class="w-full bg-locar-orange text-white font-bold py-3 rounded hover:bg-black transition">ENREGISTRER</button>
            </form>
        </div>
    </div>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
        // Fermer le modal si on clique en dehors
        window.onclick = function(event) {
            const modal = document.getElementById('addModal');
            if (event.target == modal) {
                closeModal('addModal');
            }
        }
    </script>
</body>
</html>