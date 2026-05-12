<?php
$request = $_SERVER["REQUEST_URI"];
$request = parse_url($request, PHP_URL_PATH);

// base path (cartella del progetto)
$basePath = rtrim(dirname($_SERVER["SCRIPT_NAME"]), "/");

// rimuove la subfolder dall'URL
if ($basePath !== "" && $basePath !== "/") {
    if (str_starts_with($request, $basePath)) {
        $request = substr($request, strlen($basePath));
    }
}

// pulizia finale
$request = trim($request, "/");
?>

<html lang="en" class=" rggiqjmsp idc0_350" data-theme="dark">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Dummy X</title>
        <meta name="description" content="L'informatica a portata di tutti">
        <meta property="og:title" content="Dummy X">
        <meta property="og:description" content="L'informatica a portata di tutti">
        <meta property="og:type" content="website">
        <meta property="og:url" content="https://www.selectallfromdual.com/">
        <link href="https://fonts.bunny.net/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.bunny.net/css?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="<?= $basePath ?>/static/css/md3-tokens.css">
        <link rel="stylesheet" href="<?= $basePath ?>/static/css/md3-components.css">
        <link rel="stylesheet" href="<?= $basePath ?>/static/css/site.css">
        <script src="<?= $basePath ?>/static/js/theme-init.js"></script>
    </head>

    <body>
        <div class="site-wrapper">
            <header class="top-bar">
                <div class="top-bar-inner">
                    <a href="<?= $basePath ?>/" class="top-bar-title">
                        <span class="top-bar-logo">Dummy
                            <span class="primary-text">X</span>
                        </span>
                    </a>
                    <nav class="top-bar-nav">
                        <a href="<?= $basePath ?>/projects.php">
                            <span class="material-icons">apps</span>
                            <span>Projects</span>
                        </a>
                        <a href="<?= $basePath ?>/page.php?v=support">
                            <span class="material-icons">favorite</span>
                            <span>Support</span>
                        </a>
                        <a href="<?= $basePath ?>/page.php?v=about">
                            <span class="material-icons">person</span>
                            <span>About</span>
                        </a>
                        <button class="theme-toggle" id="theme-toggle" aria-label="Toggle theme">
                            <span class="material-icons icon-light">light_mode</span>
                            <span class="material-icons icon-dark">dark_mode</span>
                        </button>
                    </nav>
                </div>
            </header>
            <main class="site-content">
                <?php
                require_once 'lib/Parsedown.php'; // Carica la libreria

                $slug = $_GET['v'] ?? ''; 
                $filePath = __DIR__ . '/content/apps/' . $slug . '.md';

                if (!empty($slug) && file_exists($filePath)) {
                    $fileContent = file_get_contents($filePath);
                    
                    // Separiamo i metadati (YAML) dal corpo (Markdown)
                    // Usiamo una regex che divide il file in 3 parti: vuoto, front matter, body
                    $parts = preg_split('/^---[\s]*$/m', $fileContent, 3);
                    
                    if (count($parts) >= 3) {
                        $yamlData = trim($parts[1]);
                        $bodyMarkdown = trim($parts[2]);
                        $metadata = [];
                        
                        // Parsing manuale dello YAML
                        foreach (explode("\n", $yamlData) as $line) {
                            if (strpos($line, ':') !== false) {
                                list($key, $value) = explode(':', $line, 2);
                                $key = trim($key);
                                $value = trim($value, " \t\n\r\0\x0B\"'");
                                
                                if ($key === 'badges') {
                                    $value = trim($value, "[]");
                                    $metadata[$key] = array_map(fn($b) => trim($b, " \"'"), explode(',', $value));
                                } else {
                                    $metadata[$key] = $value;
                                }
                            }
                        }

                        // Conversione professionale del corpo Markdown (gestisce tabelle e liste)
                        $parsedown = new Parsedown();
                        $htmlContent = $parsedown->text($bodyMarkdown);

                        ?>
                        <article>
                            <div class="app-detail-header">
                                <img src="<?= $basePath ?>/static<?= htmlspecialchars($metadata['logo'] ?? '') ?>" alt="Logo" class="app-detail-logo">
                                <div>
                                    <h1><?= htmlspecialchars($metadata['title'] ?? '') ?></h1>
                                    <span class="app-detail-platform"><?= htmlspecialchars($metadata['platform'] ?? '') ?></span>
                                </div>
                            </div>

                            <div class="app-detail-badges">
                                <?php if (isset($metadata['badges'])): ?>
                                    <?php foreach ($metadata['badges'] as $badge): ?>
                                        <span class="badge info"><?= htmlspecialchars($badge) ?></span>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </div>

                            <div class="app-detail-actions">
                                <?php if (!empty($metadata['website'])): ?>
                                    <a href="<?= htmlspecialchars($metadata['website']) ?>" class="md3-button" target="_blank" rel="noopener">
                                        <span class="material-icons">language</span>
                                        <span>Website</span>
                                    </a>
                                <?php endif; ?>

                                <?php if (!empty($metadata['repo'])): ?>
                                    <a href="<?= htmlspecialchars($metadata['repo']) ?>" class="md3-button outlined" target="_blank" rel="noopener">
                                        <span class="material-icons">code</span>
                                        <span>Source code</span>
                                    </a>
                                <?php endif; ?>
                            </div>

                            <div class="page-content">
                                <?= $htmlContent // Adesso include tabelle, liste e grassetti corretti ?>
                            </div>

                            <div class="app-detail-back">
                                <a href="<?= $basePath ?>/apps/" class="md3-button text">
                                    <span class="material-icons">arrow_back</span>
                                    <span>All projects</span>
                                </a>
                            </div>
                        </article>
                        <?php
                    }
                } else {
                    http_response_code(404);
                    echo "<h1>404 - Progetto non trovato</h1>";
                }
                ?>
            </main>
            <footer class="site-footer">
                <div class="footer-inner">
                <div class="footer-column">
                <div class="footer-column-title">Navigate</div>
                    <a href="<?= $basePath ?>/projects.php" class="footer-link">
                        <span class="material-icons">apps</span>
                        <span>Projects</span>
                    </a>
                    <a href="<?= $basePath ?>/page.php?v=about" class="footer-link">
                        <span class="material-icons">person</span>
                        <span>About</span>
                    </a>
                </div>
                <div class="footer-column">
                    <div class="footer-column-title">Follow</div>
                        <a href="https://t.me/selectallfromdual" class="footer-link" rel="me noopener" target="_blank">
                            <span class="material-icons">telegram</span>
                            <span>Telegram</span>
                        </a>
                        <a href="https://feeds.feedburner.com/selectallfromdual" class="footer-link" rel="me noopener" target="_blank">
                            <span class="material-icons">rss_feed</span>
                            <span>FeedBurner</span>
                        </a>
                    </div>
                    <div class="footer-column">
                        <div class="footer-column-title">Links</div>
                        <a href="https://github.com/francescoceliento" class="footer-link" rel="noopener" target="_blank">
                            <span class="material-icons">code</span>
                            <span>GitHub</span>
                        </a>
                        <a href="<?= $basePath ?>/page.php?v=support" class="footer-link">
                            <span class="material-icons">favorite</span>
                            <span>Support</span>
                        </a>
                    </div>
                </div>
                <p class="footer-copy">© 2026 Dummy X · <a href="https://www.selectallfromdual.com" target="_blank" rel="noopener">MIT License</a></p>
                <div align="center">
                    <img src="https://api.thegreenwebfoundation.org/greencheckimage/www.selectallfromdual.com?nocache=true" alt="This website is hosted Green - checked by thegreenwebfoundation.org">
                </div>
            </footer>
            </div>
                <script src="<?= $basePath ?>/static/js/theme.js"></script>
            </body>

</html>
