<?php
$current_page = basename($_SERVER['PHP_SELF']);
function isActiveUser($page, $current) {
    return $page === $current ? 'text-locar-orange font-black border-l-4 border-locar-orange bg-gray-50' : 'text-gray-500 hover:text-locar-orange transition font-bold';
}
?>
<aside class="w-64 bg-white border-r border-gray-100 hidden md:block fixed h-full">
    <div class="p-6">
        <p class="text-xs font-bold text-gray-400 uppercase mb-4 tracking-wider">Menu</p>
        <nav class="space-y-1">
            <a href="my-reservations.php" class="block px-4 py-3 <?= isActiveUser('my-reservations.php', $current_page) ?>">
                Mes Réservations
            </a>
            <a href="my-reviews.php" class="block px-4 py-3 <?= isActiveUser('my-reviews.php', $current_page) ?>">
                Mes Avis
            </a>
            <a href="favorites.php" class="block px-4 py-3 <?= isActiveUser('favorites.php', $current_page) ?>">
                Mes Favoris
            </a>
            <div class="pt-4 mt-4 border-t border-gray-100">
                <a href="../../index.php" class="block px-4 py-3 text-red-500 hover:text-red-600 transition font-bold">
                    Déconnexion
                </a>
            </div>
        </nav>
    </div>
</aside>