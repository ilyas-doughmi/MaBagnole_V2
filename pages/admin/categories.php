<?php
session_start();
require_once "../../Classes/db.php";
require_once "../../Classes/Category.php";

$db = DB::connect();
$categoryObj = new Category($db);
$categories = $categoryObj->getCategories();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Catégories | Admin</title>
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
                <h3 class="text-gray-700 text-3xl font-black uppercase">Catégories</h3>
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
                            <th class="p-4">Nom de la catégorie</th>
                            <th class="p-4">Description</th>
                            <th class="p-4">Véhicules</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($categories as $c): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-bold text-gray-500">#<?= $c['category_id'] ?></td>
                            <td class="p-4 font-bold"><?= $c['category_name'] ?></td>
                            <td class="p-4 text-sm text-gray-600"><?= $c['category_description'] ?></td>
                            <td class="p-4 text-sm text-gray-500"><?= $c['count'] ?> véhicules</td>
                            <td class="p-4 text-right space-x-2 flex justify-end">
                                <a href="?edit=<?= $c['category_id'] ?>" class="text-blue-500 hover:text-blue-700"><i class="fa-solid fa-pen"></i></a>
                                <form action="actions/category_action.php" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    <input type="hidden" name="category_id" value="<?= $c['category_id'] ?>">
                                    <button type="submit" name="delete_category" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </main>


    <!-- Add Modal -->
    <div id="addModal" class="fixed inset-0 z-50 hidden bg-black/80 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white w-full max-w-lg rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-black text-xl uppercase">Ajouter une catégorie</h3>
                <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-black">✕</button>
            </div>
            <form action="actions/category_action.php" class="space-y-4" method="POST">
                <div>
                    <input type="text" name="category_name" placeholder="Nom de la catégorie" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none" required>
                </div>
                <div>
                    <textarea name="category_description" placeholder="Description" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none h-32"></textarea>
                </div>
                <button type="submit" name="add_category" class="w-full bg-locar-orange text-white font-bold py-3 rounded hover:bg-black transition">ENREGISTRER</button>
            </form>
        </div>
    </div>
     <!-- Edit Modal -->
   <?php if (isset($_GET['edit']) && $edit_category = $categoryObj->getCategoryById($_GET['edit'])): ?>
    <div id="editModal" class="fixed inset-0 z-50 flex items-center justify-center p-4 backdrop-blur-sm bg-black/60">
        <div class="bg-white w-full max-w-lg rounded-xl p-6 shadow-2xl relative">
            <button onclick="window.location.href='categories.php'" class="absolute top-4 right-4 text-gray-400 hover:text-black">✕</button>
            <h3 class="font-black text-xl uppercase mb-6">Modifier la catégorie</h3>
            
            <form action="actions/category_action.php" class="space-y-4" method="POST">
                <input type="hidden" name="category_id" value="<?= $edit_category['category_id'] ?>">
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nom</label>
                    <input type="text" name="category_name" value="<?= htmlspecialchars($edit_category['category_name']) ?>" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none focus:border-locar-orange transition" required>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Description</label>
                    <textarea name="category_description" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none h-32 focus:border-locar-orange transition"><?= htmlspecialchars($edit_category['category_description']) ?></textarea>
                </div>
                <button type="submit" name="update_category" class="w-full bg-locar-black text-white font-bold py-3 rounded hover:bg-locar-orange transition">METTRE À JOUR</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function openModal(id) { document.getElementById(id).classList.remove('hidden'); }
        function closeModal(id) { document.getElementById(id).classList.add('hidden'); }
    </script>
</body>
</html>
