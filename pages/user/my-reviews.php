<?php
require_once '../../includes/guard.php';
require_once '../../Classes/db.php';
require_once '../../Classes/Review.php';

require_login();

$db = DB::connect();
$reviewObj = new Review($db);
$reviews = $reviewObj->getReviewsByUserId($_SESSION['id']);

$editReview = null;
if (isset($_GET['edit'])) {
    $editReview = $reviewObj->getReviewById($_GET['edit']);
    if (!$editReview) {
        $editReview = null;
    }
}
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes Avis | MaBagnole</title>
    
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
<body class="bg-gray-50 text-gray-800 antialiased">

    <?php 
    $root_path = '../../';
    include '../header.php'; 
    ?>

    <div class="pt-20 min-h-screen flex flex-col">
        <main class="flex-1 p-8 w-full">
            <div class="max-w-5xl mx-auto">
                <div class="flex justify-between items-center mb-8">
                    <div>
                        <h1 class="text-3xl font-black uppercase text-gray-900">Mes Avis</h1>
                        <p class="text-gray-500 font-medium mt-1">Gérez vos avis et commentaires sur nos véhicules.</p>
                    </div>
                </div>

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 overflow-hidden">
                    <?php if (empty($reviews)): ?>
                        <div class="p-12 text-center">
                            <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-4">
                                <i class="fa-solid fa-star text-2xl text-gray-400"></i>
                            </div>
                            <h3 class="font-bold text-gray-800 mb-2">Aucun avis</h3>
                            <p class="text-gray-500 text-sm mb-6">Vous n'avez pas encore laissé d'avis.</p>
                            <a href="../vehicles.php" class="inline-block bg-black text-white font-bold py-3 px-6 rounded-lg hover:bg-locar-orange transition">
                                Découvrir nos véhicules
                            </a>
                        </div>
                    <?php else: ?>
                        <?php foreach($reviews as $review): ?>
                        <div class="p-6 border-b border-gray-100 last:border-0 hover:bg-gray-50 transition group">
                            <div class="flex flex-col md:flex-row gap-6">
                                <div class="flex-grow">
                                    <div class="flex justify-between items-start mb-2">
                                        <div>
                                            <h3 class="font-black text-lg uppercase"><?= htmlspecialchars($review['brand'] . ' ' . $review['model']) ?></h3>
                                            <p class="text-xs text-gray-400 font-bold"><?= date('d M Y', strtotime($review['review_date'])) ?></p>
                                        </div>
                                        <div class="text-yellow-400 text-sm">
                                            <?php for($i=0; $i<$review['rating']; $i++) echo '<i class="fa-solid fa-star"></i>'; ?>
                                        </div>
                                    </div>
                                    
                                    <p class="text-gray-600 text-sm leading-relaxed mb-4">
                                        "<?= htmlspecialchars($review['comment']) ?>"
                                    </p>

                                    <div class="flex gap-3 opacity-0 group-hover:opacity-100 transition-opacity duration-200">
                                        <a href="?edit=<?= $review['review_id'] ?>" class="text-xs font-bold bg-gray-100 hover:bg-black hover:text-white px-4 py-2 rounded transition">
                                            <i class="fa-solid fa-pen mr-1"></i> MODIFIER
                                        </a>
                                        <form action="actions/user_review_action.php" method="POST" class="inline" onsubmit="return confirm('Supprimer cet avis ?');">
                                            <input type="hidden" name="review_id" value="<?= $review['review_id'] ?>">
                                            <button type="submit" name="delete_review" class="text-xs font-bold bg-red-50 text-red-500 hover:bg-red-500 hover:text-white px-4 py-2 rounded transition">
                                                <i class="fa-solid fa-trash mr-1"></i> SUPPRIMER
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </main>
    </div>

    <?php if ($editReview): ?>
    <div id="editModal" class="fixed inset-0 z-50 bg-black/80 flex items-center justify-center p-4 backdrop-blur-sm">
        <div class="bg-white w-full max-w-lg rounded-2xl p-8 relative">
            <a href="my-reviews.php" class="absolute top-4 right-4 text-gray-400 hover:text-black">✕</a>
            
            <h3 class="font-black text-2xl uppercase mb-6">Modifier l'avis</h3>
            
            <form action="actions/user_review_action.php" method="POST" class="space-y-4">
                <input type="hidden" name="review_id" value="<?= $editReview['review_id'] ?>">
                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-2">NOTE</label>
                    <select name="rating" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none focus:border-locar-orange">
                        <option value="5" <?= $editReview['rating'] == 5 ? 'selected' : '' ?>>⭐⭐⭐⭐⭐</option>
                        <option value="4" <?= $editReview['rating'] == 4 ? 'selected' : '' ?>>⭐⭐⭐⭐</option>
                        <option value="3" <?= $editReview['rating'] == 3 ? 'selected' : '' ?>>⭐⭐⭐</option>
                        <option value="2" <?= $editReview['rating'] == 2 ? 'selected' : '' ?>>⭐⭐</option>
                        <option value="1" <?= $editReview['rating'] == 1 ? 'selected' : '' ?>>⭐</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-gray-400 mb-2">COMMENTAIRE</label>
                    <textarea name="comment" rows="4" class="w-full p-3 bg-gray-50 rounded border border-gray-200 font-bold outline-none focus:border-locar-orange"><?= htmlspecialchars($editReview['comment']) ?></textarea>
                </div>
                <div class="pt-4 flex gap-3">
                    <a href="my-reviews.php" class="flex-1 text-center bg-gray-100 hover:bg-gray-200 text-gray-800 font-bold py-3 rounded transition">ANNULER</a>
                    <button type="submit" name="update_review" class="flex-1 bg-locar-orange hover:bg-black text-white font-bold py-3 rounded transition">ENREGISTRER</button>
                </div>
            </form>
        </div>
    </div>
    <?php endif; ?>

</body>
</html>
