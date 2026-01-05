<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inscription | MaBagnole</title>

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
                    }
                }
            }
        }
    </script>
</head>

<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4 relative overflow-x-hidden">

<!-- Background -->
<div class="absolute top-0 left-0 w-2/3 h-full bg-gradient-to-r from-gray-200 to-transparent -z-10"></div>
<div class="absolute -top-24 -right-24 w-96 h-96 bg-locar-orange rounded-full blur-[150px] opacity-10 -z-10"></div>

<div class="bg-white w-full max-w-6xl rounded-2xl overflow-hidden shadow-2xl flex flex-col md:flex-row">

    <!-- Left -->
    <div class="w-full md:w-1/3 bg-locar-dark text-white p-10 flex flex-col justify-center items-center text-center relative">
        <h3 class="font-black text-3xl mb-4 uppercase">Déjà membre ?</h3>
        <p class="text-gray-400 mb-8">
            Connectez-vous pour gérer vos réservations facilement.
        </p>
        <a href="login.php"
           class="bg-white text-black hover:bg-locar-orange hover:text-white font-black py-4 px-10 rounded-full transition">
            SE CONNECTER
        </a>
    </div>

    <!-- Right -->
    <div class="w-full md:w-2/3 p-10 md:p-16">
        <h2 class="font-black text-4xl uppercase mb-2">Créer un compte</h2>
        <p class="text-gray-500 mb-8">Commencez en quelques secondes.</p>

        <form id="registerForm" method="POST" action="../includes/register.php" class="space-y-6">
                <input type="text" name="register" hidden>
            <div>
                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Nom complet</label>
                <input type="text" name="full_name" required
                       class="w-full px-4 py-3 bg-gray-50 rounded-lg border focus:border-locar-orange outline-none font-bold"
                       placeholder="Votre nom complet">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Email</label>
                <input type="email" name="email" required
                       class="w-full px-4 py-3 bg-gray-50 rounded-lg border focus:border-locar-orange outline-none font-bold"
                       placeholder="votre@email.com">
            </div>

            <div>
                <label class="block text-xs font-bold text-gray-400 mb-2 uppercase">Mot de passe</label>
                <input type="password" id="password" name="password" required
                       class="w-full px-4 py-3 bg-gray-50 rounded-lg border focus:border-locar-orange outline-none font-bold"
                       placeholder="••••••••">
                <p id="passwordError" class="text-red-500 text-sm mt-2 hidden"></p>
            </div>

            <button type="submit"
                    class="w-full bg-locar-orange hover:bg-black text-white font-bold py-4 rounded-lg transition">
                S'INSCRIRE
            </button>

        </form>
    </div>
</div>

</body>
</html>
