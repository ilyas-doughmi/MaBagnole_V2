<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header('Location: ../../index.php');
    exit();
}

require_once '../../Classes/db.php';
require_once '../../Classes/Comment.php';

$db = DB::connect();
$commentObj = new Comment($db);
$comments = $commentObj->getAllComments();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gestion des Commentaires | Admin</title>
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
                    <h1 class="text-xl font-black text-gray-800 tracking-tight">COMMENTAIRES</h1>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <!-- Messages -->
                <?php if (isset($_SESSION['message'])): ?>
                <div class="mb-4 p-4 rounded-lg <?= $_SESSION['msg_type'] === 'success' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' ?>">
                    <?= $_SESSION['message'] ?>
                </div>
                <?php 
                    unset($_SESSION['message']);
                    unset($_SESSION['msg_type']);
                endif; 
                ?>

                <div class="bg-white rounded-xl shadow-sm border border-gray-100 overflow-hidden">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left">
                            <thead class="bg-gray-50 text-gray-600 text-xs uppercase font-bold">
                                <tr>
                                    <th class="px-6 py-4">Commentaire</th>
                                    <th class="px-6 py-4">Article</th>
                                    <th class="px-6 py-4">Utilisateur</th>
                                    <th class="px-6 py-4">Date</th>
                                    <th class="px-6 py-4 text-right">Actions</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-gray-100">
                                <?php if ($comments): ?>
                                    <?php foreach($comments as $comment): ?>
                                    <tr class="hover:bg-gray-50 transition">
                                        <td class="px-6 py-4 w-1/3">
                                            <div class="text-sm text-gray-800 break-words"><?= htmlspecialchars($comment['content']) ?></div>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-600">
                                            <?= htmlspecialchars($comment['article_title']) ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-600">
                                            <?= htmlspecialchars($comment['full_name']) ?>
                                        </td>
                                        <td class="px-6 py-4 text-sm font-bold text-gray-500">
                                            <?= htmlspecialchars($comment['created_at']) ?>
                                        </td>
                                        <td class="px-6 py-4 text-right">
                                            <div class="flex justify-end gap-2">
                                                <form action="actions/comment_action.php" method="POST" onsubmit="return confirm('Êtes-vous sûr de vouloir supprimer ce commentaire ?');">
                                                    <input type="hidden" name="comment_id" value="<?= $comment['commentId'] ?>">
                                                    <button type="submit" name="delete_comment" class="w-8 h-8 rounded bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition" title="Supprimer">
                                                        <i class="fa-solid fa-trash"></i>
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                <?php else: ?>
                                    <tr>
                                        <td colspan="5" class="px-6 py-8 text-center text-gray-500">
                                            <p>Aucun commentaire trouvé.</p>
                                        </td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </main>
        </div>
    </div>
</body>
</html>
