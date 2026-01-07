<?php
require_once '../../includes/guard.php';
require_once '../../Classes/db.php';
require_once '../../Classes/Theme.php';
require_once '../../Classes/Article.php';
require_once '../../Classes/Tag.php';

require_login();

$db = DB::connect();
$themeObj = new Theme($db);
$themes = $themeObj->getThemes();

$tagObj = new Tag($db);
$tags = $tagObj->getTags();

$error = '';
$success = '';

if (isset($_GET['status'])) {
    if ($_GET['status'] === 'success') {
        $success = "Votre article a été soumis avec succès et est en attente de validation.";
    } elseif ($_GET['status'] === 'error') {
        $error = "Une erreur est survenue lors de l'ajout de l'article.";
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Proposer un article | MaBagnole</title>
    
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
        
        <main class="flex-1 p-8 w-full">
            <div class="max-w-2xl mx-auto">
                <div class="mb-8">
                    <h1 class="text-3xl font-black mb-2">Proposer un article</h1>
                    <p class="text-gray-500">Partagez votre expérience avec la communauté MaBagnole.</p>
                </div>

                <?php if ($success): ?>
                    <div class="bg-green-100 border-l-4 border-green-500 text-green-700 p-4 mb-8" role="alert">
                        <p class="font-bold">Succès</p>
                        <p><?= $success ?></p>
                    </div>
                <?php endif; ?>

                <?php if ($error): ?>
                    <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-8" role="alert">
                        <p class="font-bold">Erreur</p>
                        <p><?= $error ?></p>
                    </div>
                <?php endif; ?>

                <form action="actions/user_article_action.php" method="POST" class="bg-white rounded-xl p-8 shadow-card border border-gray-100">
                    
                    <div class="mb-6">
                        <label for="title" class="block text-sm font-bold text-gray-700 mb-2">Titre de l'article</label>
                        <input type="text" id="title" name="title" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border-transparent focus:border-locar-orange focus:bg-white focus:ring-0 transition text-sm font-bold">
                    </div>

                    <div class="mb-6">
                        <label for="theme_id" class="block text-sm font-bold text-gray-700 mb-2">Thème</label>
                        <div class="relative">
                            <select id="theme_id" name="theme_id" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border-transparent focus:border-locar-orange focus:bg-white focus:ring-0 transition text-sm font-bold appearance-none">
                                <option value="" disabled selected>Sélectionnez un thème</option>
                                <?php if($themes): ?>
                                    <?php foreach($themes as $theme): ?>
                                        <option value="<?= $theme['id'] ?>"><?= $theme['name'] ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                            <div class="pointer-events-none absolute inset-y-0 right-0 flex items-center px-4 text-gray-700">
                                <i class="fa-solid fa-chevron-down text-xs"></i>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label for="image" class="block text-sm font-bold text-gray-700 mb-2">URL de l'image</label>
                        <input type="url" id="image" name="image" placeholder="https://..." required class="w-full px-4 py-3 rounded-lg bg-gray-50 border-transparent focus:border-locar-orange focus:bg-white focus:ring-0 transition text-sm font-bold">
                    </div>

                    <div class="mb-6">
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-bold text-gray-700">Tags</label>
                            <button type="button" id="selectAllTags" class="text-xs text-locar-orange font-bold hover:underline">Tout sélectionner</button>
                        </div>
                        <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                            <?php if($tags): ?>
                                <?php foreach($tags as $tag): ?>
                                    <label class="flex items-center space-x-3 p-3 border rounded-lg hover:bg-gray-50 cursor-pointer transition">
                                        <input type="checkbox" name="tags[]" value="<?= $tag['tagId'] ?>" class="form-checkbox h-5 w-5 text-locar-orange rounded border-gray-300 focus:ring-locar-orange tag-checkbox">
                                        <span class="text-sm font-medium text-gray-700"><?= $tag['name'] ?></span>
                                    </label>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </div>
                    </div>

                    <script>
                        document.getElementById('selectAllTags').addEventListener('click', function() {
                            const checkboxes = document.querySelectorAll('.tag-checkbox');
                            const allChecked = Array.from(checkboxes).every(c => c.checked);
                            checkboxes.forEach(c => c.checked = !allChecked);
                            this.textContent = allChecked ? 'Tout sélectionner' : 'Tout désélectionner';
                        });
                    </script>

                    <div class="mb-8">
                        <label for="description" class="block text-sm font-bold text-gray-700 mb-2">Contenu</label>
                        <textarea id="description" name="description" rows="6" required class="w-full px-4 py-3 rounded-lg bg-gray-50 border-transparent focus:border-locar-orange focus:bg-white focus:ring-0 transition text-sm font-bold"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-locar-black text-white font-black py-4 rounded-lg hover:bg-locar-orange transition uppercase tracking-widest text-sm shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Soumettre l'article
                    </button>

                </form>
            </div>
        </main>
    </div>
</body>
</html>
