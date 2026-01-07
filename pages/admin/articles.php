<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

require_once '../../Classes/db.php';
require_once '../../Classes/Article.php';

$db = DB::connect();
$articleObj = new Article($db);
$articles = $articleObj->getAllArticles();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Articles | Admin</title>
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
<body class="bg-gray-100 font-sans antialiased">
    <div class="flex h-screen overflow-hidden">
        <?php include 'sidebar.php'; ?>
        
        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="bg-white shadow-sm h-16 flex items-center justify-between px-6 z-10">
                <div class="flex items-center gap-4">
                    <button class="md:hidden text-gray-500 hover:text-gray-700">
                        <i class="fa-solid fa-bars text-xl"></i>
                    </button>
                    <h1 class="text-xl font-black text-gray-800 tracking-tight">ARTICLES</h1>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Pending Articles -->
                <div class="mb-8">
                    <h2 class="text-lg font-bold mb-4 text-gray-800">Articles en attente</h2>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                                    <tr>
                                        <th class="px-6 py-4">Article</th>
                                        <th class="px-6 py-4">Auteur</th>
                                        <th class="px-6 py-4">Date</th>
                                        <th class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php 
                                    $hasPending = false;
                                    if ($articles):
                                        foreach($articles as $article): 
                                            if ($article['isApproved'] == 0):
                                                $hasPending = true;
                                    ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <img src="<?= htmlspecialchars($article['media']) ?>" class="w-12 h-12 rounded object-cover" alt="">
                                                <div>
                                                    <div class="font-bold text-gray-800"><?= htmlspecialchars($article['name']) ?></div>
                                                    <div class="text-xs text-gray-500 font-bold"><?= htmlspecialchars($article['theme_name']) ?></div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-600">
                                            <?= htmlspecialchars($article['author_name']) ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-500">
                                            <?= htmlspecialchars($article['createdAt']) ?>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <form action="actions/article_action.php" method="POST">
                                                    <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                                    <button type="submit" name="check_approve" value="approve" class="w-8 h-8 rounded bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition" title="Approuver">
                                                        <i class="fa-solid fa-check"></i>
                                                    </button>
                                                </form>
                                                <form action="actions/article_action.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir rejeter (supprimer) cet article ?');">
                                                    <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                                    <button type="submit" name="check_reject" value="reject" class="w-8 h-8 rounded bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition" title="Rejeter">
                                                        <i class="fa-solid fa-xmark"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php 
                                            endif;
                                        endforeach; 
                                    endif;
                                    
                                    if (!$hasPending):
                                    ?>
                                    <tr>
                                        <td colspan="4" class="px-6 py-8 text-center text-sm font-bold text-gray-400">
                                            Aucun article en attente
                                        </td>
                                    </tr>
                                    <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- All Articles -->
                <div>
                    <h2 class="text-lg font-bold mb-4 text-gray-800">Historique des articles</h2>
                    <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                        <div class="overflow-x-auto">
                            <table class="w-full text-left">
                                <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                                    <tr>
                                        <th class="px-6 py-4">Article</th>
                                        <th class="px-6 py-4">Statut</th>
                                        <th class="px-6 py-4">Auteur</th>
                                        <th class="px-6 py-4 text-right">Actions</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-100">
                                    <?php 
                                    if ($articles):
                                        foreach($articles as $article): 
                                    ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4">
                                            <div class="flex items-center gap-4">
                                                <img src="<?= htmlspecialchars($article['media']) ?>" class="w-10 h-10 rounded object-cover grayscale opacity-50" alt="">
                                                <div class="font-bold text-gray-800"><?= htmlspecialchars($article['name']) ?></div>
                                            </div>
                                        </td>
                                        <td class="px-6 py-4">
                                            <?php if($article['isApproved']): ?>
                                                <span class="inline-block px-2 py-1 rounded bg-green-100 text-green-600 text-xs font-bold uppercase">Publié</span>
                                            <?php else: ?>
                                                <span class="inline-block px-2 py-1 rounded bg-yellow-100 text-yellow-600 text-xs font-bold uppercase">En attente</span>
                                            <?php endif; ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-600">
                                            <?= htmlspecialchars($article['author_name']) ?>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <form action="actions/article_action.php" method="POST" onsubmit="return confirm('Supprimer cet article ?');">
                                                <input type="hidden" name="article_id" value="<?= $article['id'] ?>">
                                                <button type="submit" name="check_reject" value="delete" class="text-gray-400 hover:text-red-500 transition">
                                                    <i class="fa-solid fa-trash"></i>
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php 
                                        endforeach; 
                                    endif;
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

            </main>
        </div>
    </div>
</body>
</html>
