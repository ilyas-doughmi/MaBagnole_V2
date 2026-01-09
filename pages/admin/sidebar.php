<?php
$current_page = basename($_SERVER['PHP_SELF']);
function isActiveAdmin($page, $current) {
    return $page === $current ? 'bg-locar-orange text-white font-bold border-l-4 border-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white transition font-bold';
}
?>
<aside class="w-64 bg-locar-black text-white flex-shrink-0 hidden md:flex flex-col">
    <div class="p-6 flex items-center gap-3 border-b border-gray-800">
        <div class="bg-locar-orange text-white w-8 h-8 flex items-center justify-center rounded font-bold">
            <i class="fa-solid fa-car"></i>
        </div>
        <span class="font-black text-xl tracking-tighter">ADMIN</span>
    </div>
    <nav class="flex-1 overflow-y-auto py-4 space-y-1">
        <a href="dashboard.php" class="block px-6 py-3 <?= isActiveAdmin('dashboard.php', $current_page) ?>">
            <i class="fa-solid fa-gauge w-6"></i> Dashboard
        </a>
        <a href="vehicles.php" class="block px-6 py-3 <?= isActiveAdmin('vehicles.php', $current_page) ?>">
            <i class="fa-solid fa-car-side w-6"></i> Véhicules
        </a>
        <a href="categories.php" class="block px-6 py-3 <?= isActiveAdmin('categories.php', $current_page) ?>">
            <i class="fa-solid fa-tags w-6"></i> Catégories
        </a>
        <a href="tags.php" class="block px-6 py-3 <?= isActiveAdmin('tags.php', $current_page) ?>">
            <i class="fa-solid fa-tag w-6"></i> Tags
        </a>
        <a href="themes.php" class="block px-6 py-3 <?= isActiveAdmin('themes.php', $current_page) ?>">
            <i class="fa-solid fa-layer-group w-6"></i> Thèmes
        </a>
        <a href="articles.php" class="block px-6 py-3 <?= isActiveAdmin('articles.php', $current_page) ?>">
            <i class="fa-solid fa-newspaper w-6"></i> Articles
        </a>
        <a href="comments.php" class="block px-6 py-3 <?= isActiveAdmin('comments.php', $current_page) ?>">
            <i class="fa-solid fa-comments w-6"></i> Commentaires
        </a>
        <a href="reservations.php" class="block px-6 py-3 <?= isActiveAdmin('reservations.php', $current_page) ?>">
            <i class="fa-solid fa-calendar-check w-6"></i> Réservations
        </a>
        <a href="reviews.php" class="block px-6 py-3 <?= isActiveAdmin('reviews.php', $current_page) ?>">
            <i class="fa-solid fa-star w-6"></i> Avis
        </a>
        <a href="clients.php" class="block px-6 py-3 <?= isActiveAdmin('clients.php', $current_page) ?>">
            <i class="fa-solid fa-users w-6"></i> Clients
        </a>
    </nav>
    <div class="p-4 border-t border-gray-800">
        <a href="../../index.php" class="block px-6 py-3 text-gray-400 hover:text-white transition font-bold">
            <i class="fa-solid fa-right-from-bracket w-6"></i> Déconnexion
        </a>
    </div>
</aside>