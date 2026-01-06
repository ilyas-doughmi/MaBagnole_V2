<?php
session_start();
require_once "../../Classes/db.php";
require_once "../../Classes/Theme.php";

$db = DB::connect();
$themeObj = new Theme($db);
$themes = $themeObj->getThemes();


$edit_theme = null;
if (isset($_GET['edit'])) {
    foreach ($themes as $theme) {
        if ($theme['id'] == $_GET['edit']) {
            $edit_theme = $theme;
            break;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gérer Thèmes | Admin</title>
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
                <h3 class="text-gray-700 text-3xl font-black uppercase">Thèmes</h3>
                <div class="flex gap-3">
                    <button onclick="openModal('addModal')" class="bg-locar-orange hover:bg-black text-white font-bold py-2 px-4 rounded shadow transition">
                        <i class="fa-solid fa-plus mr-2"></i> Ajouter
                    </button>
                </div>
            </div>

            <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-gray-50 border-b border-gray-100 text-xs uppercase text-gray-400 font-bold tracking-wider">
                            <th class="p-4">ID</th>
                            <th class="p-4">Image</th>
                            <th class="p-4">Titre</th>
                            <th class="p-4">Description</th>
                            <th class="p-4 text-right">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100">
                        <?php foreach($themes as $t): ?>
                        <tr class="hover:bg-gray-50 transition">
                            <td class="p-4 font-bold text-gray-500">#<?= $t['id'] ?></td>
                            <td class="p-4">
                                <img src="<?= $t['image'] ?>" alt="Theme" class="w-16 h-10 object-cover rounded">
                            </td>
                            <td class="p-4 font-bold"><?= $t['name'] ?></td>
                            <td class="p-4 text-sm text-gray-600 truncate max-w-xs"><?= $t['description'] ?></td>
                            <td class="p-4 text-right space-x-2 flex justify-end">
                                <a href="?edit= <?= $t['id'] ?> " class="text-blue-500 hover:text-blue-700"><i class="fa-solid fa-pen"></i></a>
                                <form action="actions/theme_action.php" method="POST" class="inline" onsubmit="return confirm('Êtes-vous sûr ?');">
                                    <input type="hidden" name="theme_id" value="<?= $t['id'] ?>">
                                    <input type="hidden" name="action" value="delete"> 
                                    <button type="submit" name="delete_theme" class="text-red-500 hover:text-red-700"><i class="fa-solid fa-trash"></i></button>
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
                <h3 class="font-black text-xl uppercase">Ajouter un thème</h3>
                <button onclick="closeModal('addModal')" class="text-gray-400 hover:text-black">✕</button>
            </div>
            <form action="actions/theme_action.php" class="space-y-4" method="POST" enctype="multipart/form-data">
                <input type="hidden" name="add" value="add">
                <div>
                    <input type="text" name="title" placeholder="Titre du thème" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none" required>
                </div>
                <div>
                    <input type="url" name="image" placeholder="URL de l'image" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none">
                </div>
                <div>
                    <textarea name="description" placeholder="Description" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none h-24"></textarea>
                </div>
                <button type="submit" name="add_theme" class="w-full bg-locar-orange text-white font-bold py-3 rounded hover:bg-black transition">ENREGISTRER</button>
            </form>
        </div>
    </div>

    <!-- Edit Modal (Shows if edit param is present) -->
    <?php if ($edit_theme): ?>
    <div id="editModal" class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white w-full max-w-lg rounded-xl p-6">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-black text-xl uppercase">Modifier le thème #<?= $edit_theme['id'] ?></h3>
                <a href="themes.php" class="text-gray-400 hover:text-black">✕</a>
            </div>
            <form action="actions/theme_action.php" class="space-y-4" method="POST">
                <input type="hidden" name="action" value="edit">
                <input type="hidden" name="theme_id" value="<?= $edit_theme['id'] ?>">
                <div>
                    <label class="text-xs uppercase font-bold text-gray-500">Titre</label>
                    <input type="text" name="title" value="<?= $edit_theme['name'] ?>" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none" required>
                </div>
                <div>
                    <label class="text-xs uppercase font-bold text-gray-500">Image URL</label>
                    <input type="url" name="image" value="<?= $edit_theme['image'] ?>" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none">
                </div>
                <div>
                    <label class="text-xs uppercase font-bold text-gray-500">Description</label>
                    <textarea name="description" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none h-24"><?= $edit_theme['description'] ?></textarea>
                </div>
                <button type="submit" name="edit_theme" class="w-full bg-locar-orange text-white font-bold py-3 rounded hover:bg-black transition">METTRE À JOUR</button>
            </form>
        </div>
    </div>
    <?php endif; ?>

    <script>
        function openModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }
        function closeModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }
    </script>
</body>
</html>
