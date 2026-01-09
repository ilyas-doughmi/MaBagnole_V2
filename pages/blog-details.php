<?php
require_once '../includes/guard.php';
require_once '../classes/db.php';
require_once "../Classes/Article.php";
require_once '../classes/ArticleTag.php';
require_once '../Classes/Comment.php';

require_once "../includes/guard.php";

require_login();


if (isset($_GET["article"]) && !empty($_GET["article"])) {
    $db = DB::connect();
    $articleObj = new Article($db);
    $commentObj = new Comment($db);
    $value = $_GET["article"];
    $articleObj->__set("name", $value);
    $post = $articleObj->getArticleDetails();
    $tags = ArticleTag::getArticleTags($db,$value);
    $comments = $commentObj->getCommentsByArticleId($value);
    
} else {    
    header("Location: blog.php");
    exit;
}

?>
<!DOCTYPE html>
<html lang="fr" class="scroll-smooth">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $post["title"] ?> | Blog MaBagnole</title>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@200;300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Outfit', 'sans-serif'],
                    },
                    colors: {
                        'brand-orange': '#FF3B00',
                        'brand-black': '#0a0a0a',
                        'brand-gray': '#121212',
                        'surface': '#ffffff',
                    },
                    typography: {
                        DEFAULT: {
                            css: {
                                color: '#333',
                                h3: {
                                    color: '#0a0a0a',
                                    fontWeight: '800',
                                    textTransform: 'uppercase',
                                    marginTop: '2em',
                                },
                                blockquote: {
                                    borderLeftColor: '#FF3B00',
                                    fontStyle: 'italic',
                                    fontWeight: '600',
                                    color: '#1a1a1a',
                                    backgroundColor: '#FFF5F0',
                                    padding: '1.5rem',
                                    borderRadius: '0 1rem 1rem 0',
                                }
                            }
                        }
                    }
                }
            }
        }
    </script>
    <style>
        /* Custom typography simulation since we might not have tailwind typography plugin */
        .prose p {
            margin-bottom: 1.5rem;
            line-height: 1.8;
        }

        .prose h3 {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0a0a0a;
            margin-top: 2.5rem;
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: -0.02em;
        }

        .prose blockquote {
            border-left: 4px solid #FF3B00;
            padding-left: 1.5rem;
            font-style: italic;
            color: #555;
            margin: 2rem 0;
        }
    </style>
</head>

<body class="bg-white text-brand-black antialiased selection:bg-brand-orange selection:text-white">

    <?php $root_path = '../';
    include 'header.php'; ?>

    <div class="fixed top-20 left-0 h-1 bg-brand-orange z-50 transition-all duration-300" id="progressBar" style="width: 0%"></div>

    <article>
        <header class="pt-32 pb-12 px-6 bg-gray-50 border-b border-gray-100">
            <div class="container mx-auto max-w-4xl text-center">
                <div class="flex items-center justify-center gap-2 mb-6">
                    <span class="bg-brand-orange text-white text-[10px] font-bold px-3 py-1 rounded-full uppercase tracking-wider">
                        <?= $post['theme_name'] ?>
                    </span>
                    <span class="text-gray-400 text-xs font-bold uppercase tracking-wider">
                        <?= date('d F Y', strtotime($post['date'])) ?>
                    </span>
                </div>

                <h1 class="text-4xl md:text-6xl font-black uppercase mb-8 leading-tight text-brand-black">
                    <?= $post['title'] ?>
                </h1>

                <div class="flex items-center justify-center gap-4">
                    <div class="w-12 h-12 bg-gray-200 rounded-full flex items-center justify-center text-xl font-black text-gray-400">
                        <?= substr($post['author'], 0, 1) ?>
                    </div>
                    <div class="text-left">
                        <p class="text-xs font-bold text-gray-400 uppercase tracking-widest">Écrit par</p>
                        <p class="font-bold text-brand-black"><?= $post['author'] ?></p>
                    </div>
                </div>
            </div>
        </header>

        <div class="container mx-auto max-w-5xl px-6 -mt-8">
            <div class="aspect-video rounded-3xl overflow-hidden shadow-2xl shadow-brand-black/10">
                <img src="<?= $post['media'] ?>" class="w-full h-full object-cover">
            </div>
        </div>
        <div class="container mx-auto max-w-3xl px-6 py-16">
            <div class="prose prose-lg text-gray-600 mx-auto">
                <?= $post['description'] ?>
            </div>

            <div class="mt-16 pt-8 border-t border-gray-100">
                <p class="text-xs font-bold text-gray-400 uppercase tracking-widest mb-4">Thèmes associés</p>
                <div class="flex flex-wrap gap-2">
                    <?php foreach($tags as $tag): ?>
                        <a href="blog.php?tag=<?= $tag["name"] ?>" class="px-4 py-2 bg-gray-50 hover:bg-brand-black hover:text-white rounded-lg text-xs font-bold transition text-gray-600">#<?= $tag["name"] ?></a>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Comments Section -->
            <div class="mt-16 pt-12 border-t border-gray-100" id="comments">
                <h3 class="text-2xl font-black text-brand-black uppercase mb-8">Commentaires (<?= count($comments) ?>)</h3>
                
                <?php if(isset($_SESSION['id'])): ?>
                <form action="submit_comment.php" method="POST" class="mb-12 bg-gray-50 p-6 rounded-2xl">
                    <input type="hidden" name="article_id" value="<?= $value ?>">
                    <div class="mb-4">
                        <label for="content" class="block text-xs font-bold text-gray-400 uppercase tracking-widest mb-2">Votre commentaire</label>
                        <textarea name="content" id="content" rows="4" class="w-full bg-white border border-gray-200 rounded-xl p-4 focus:outline-none focus:border-brand-orange transition" placeholder="Partagez votre avis..." required></textarea>
                    </div>
                    <button type="submit" class="bg-brand-orange text-white font-bold py-3 px-8 rounded-xl hover:bg-red-600 transition shadow-lg shadow-brand-orange/20">
                        Publier
                    </button>
                </form>
                <?php else: ?>
                <div class="bg-gray-50 p-6 rounded-2xl mb-12 text-center">
                    <p class="text-gray-600 mb-4">Connectez-vous pour participer à la discussion.</p>
                    <a href="login.php" class="inline-block bg-brand-black text-white font-bold py-3 px-8 rounded-xl hover:bg-brand-orange transition">Se connecter</a>
                </div>
                <?php endif; ?>

                <div class="space-y-8">
                    <?php if(empty($comments)): ?>
                        <p class="text-gray-500 italic">Soyez le premier à commenter cet article !</p>
                    <?php else: ?>
                        <?php foreach($comments as $comment): ?>
                        <div class="flex gap-4" id="comment-<?= $comment['commentId'] ?>">
                            <div class="w-10 h-10 bg-gray-200 rounded-full flex-shrink-0 flex items-center justify-center font-bold text-gray-400">
                                <?= substr($comment['full_name'], 0, 1) ?>
                            </div>
                            <div class="flex-1">
                                <?php if(isset($_GET['edit_comment']) && $_GET['edit_comment'] == $comment['commentId'] && isset($_SESSION['id']) && $_SESSION['id'] == $comment['user_id']): ?>
                                    <!-- Edit Form -->
                                    <form action="update_comment.php" method="POST" class="bg-white border-2 border-brand-orange rounded-2xl p-6">
                                        <h4 class="font-bold text-brand-orange uppercase mb-4 text-xs tracking-widest">Modifier le commentaire</h4>
                                        <input type="hidden" name="article_id" value="<?= $value ?>">
                                        <input type="hidden" name="comment_id" value="<?= $comment['commentId'] ?>">
                                        <div class="mb-4">
                                            <textarea name="content" rows="4" class="w-full bg-gray-50 border border-gray-200 rounded-xl p-4 focus:outline-none focus:border-brand-orange transition" required><?= htmlspecialchars($comment['content']) ?></textarea>
                                        </div>
                                        <div class="flex justify-end gap-3">
                                            <a href="blog-details.php?article=<?= $value ?>#comment-<?= $comment['commentId'] ?>" class="px-4 py-2 text-sm font-bold text-gray-500 hover:text-gray-800 transition">Annuler</a>
                                            <button type="submit" class="bg-brand-orange text-white text-sm font-bold py-2 px-6 rounded-lg hover:bg-red-600 transition">
                                                Sauvegarder
                                            </button>
                                        </div>
                                    </form>
                                <?php else: ?>
                                    <!-- Display Comment -->
                                    <div class="bg-gray-50 rounded-2xl p-6 rounded-tl-none relative group">
                                        <div class="flex items-center justify-between mb-2">
                                            <h4 class="font-bold text-brand-black"><?= $comment['full_name'] ?></h4>
                                            <span class="text-xs font-bold text-gray-400"><?= date('d/m/Y', strtotime($comment['created_at'])) ?></span>
                                        </div>
                                        <p class="text-gray-600 leading-relaxed"><?= htmlspecialchars($comment['content']) ?></p>
                                        
                                        <?php if(isset($_SESSION['id']) && $_SESSION['id'] == $comment['user_id']): ?>
                                            <div class="absolute top-4 right-4 flex gap-3 opacity-0 group-hover:opacity-100 transition">
                                                <a href="?article=<?= $value ?>&edit_comment=<?= $comment['commentId'] ?>#comment-<?= $comment['commentId'] ?>" class="text-gray-400 hover:text-brand-orange transition" title="Modifier">
                                                    <i class="fa-solid fa-pen-to-square"></i>
                                                </a>
                                                <a href="delete_comment.php?id=<?= $comment['commentId'] ?>&article=<?= $value ?>" class="text-gray-400 hover:text-red-500 transition" title="Supprimer" onclick="return confirm('Voulez-vous vraiment supprimer ce commentaire ?')">
                                                    <i class="fa-solid fa-trash-can"></i>
                                                </a>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>

            <div class="mt-16 bg-brand-black rounded-3xl p-8 md:p-12 text-center relative overflow-hidden group">
                <div class="absolute inset-0 bg-brand-orange/20 transform scale-x-0 group-hover:scale-x-100 transition-transform origin-left duration-500"></div>
                <div class="relative z-10">
                    <h3 class="text-2xl font-black text-white uppercase mb-4">Envie de prendre la route ?</h3>
                    <p class="text-gray-400 mb-8 max-w-lg mx-auto">Réservez le véhicule idéal pour votre prochaine aventure dès aujourd'hui.</p>
                    <a href="vehicles.php" class="inline-block bg-white text-brand-black font-bold py-4 px-8 rounded-xl hover:bg-brand-orange hover:text-white transition shadow-lg">
                        Voir les véhicules disponibles
                    </a>
                </div>
            </div>
        </div>  
    </article>

    <footer class="bg-white border-t border-gray-100 py-12">
        <div class="container mx-auto px-6 text-center">
            <a href="blog.php" class="text-xs font-black text-gray-400 uppercase tracking-widest hover:text-brand-orange transition">
                <i class="fa-solid fa-arrow-left mr-2"></i> Retour au blog
            </a>
        </div>
    </footer>

    <script>
        // Reading Progress Bar
        window.onscroll = function() {
            let winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            let height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            let scrolled = (winScroll / height) * 100;
            document.getElementById("progressBar").style.width = scrolled + "%";
        };
    </script>
</body>

</html>