<?php
$subroot = '';
$config = require __DIR__ .'/'.$subroot.'config.php';

// key cache (basata su URL completo)
$cacheKey = md5($_SERVER['REQUEST_URI']);
$cacheFile = $config['cache_dir'] . $cacheKey . '.html';

// pagina corrente (già lo usi dopo)
$tPage = $_GET['page'] ?? '';

// controlla se è esclusa
$isExcluded = in_array($tPage, $config['cache_exclude']);

// verifica cache valida
if (!$isExcluded && file_exists($cacheFile)) {
    $cacheAge = time() - filemtime($cacheFile);

    if ($cacheAge < $config['cache_ttl']) {
        readfile($cacheFile);
        exit;
    } else {
        // Il file è scaduto: lo eliminiamo
        unlink($cacheFile);
    }
}

// start buffering
ob_start();

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

// recupero gli input delle pagine
$tPage = $_GET['page'] ?? ''; 
$vPage = $_GET['v'] ?? '';

$dirPath = __DIR__."/".$subroot;
?>

<html lang="en" class=" rggiqjmsp idc0_350" data-theme="auto">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width,initial-scale=1">
        <title>Dummy-X | Select * From Dual</title>
        <meta name="description" content="L'informatica a portata di tutti. Guide e consigli per la privacy e la libertà digitale.">
        <link rel="shortcut icon" href="favicon.ico">
        
        <!-- Facebook Meta Tags -->
        <meta property="og:url" content="https://www.selectallfromdual.com/">
        <meta property="og:type" content="website">
        <meta property="og:title" content="Dummy-X | Select * From Dual">
        <meta property="og:description" content="L'informatica a portata di tutti. Guide e consigli per la privacy e la libertà digitale.">
        <meta property="og:image" content="https://www.selectallfromdual.com/logo.png">

        <!-- Twitter Meta Tags -->
        <meta name="twitter:card" content="summary_large_image">
        <meta property="twitter:domain" content="selectallfromdual.com">
        <meta property="twitter:url" content="https://www.selectallfromdual.com/">
        <meta name="twitter:title" content="Dummy-X | Select * From Dual">
        <meta name="twitter:description" content="L'informatica a portata di tutti. Guide e consigli per la privacy e la libertà digitale.">
        <meta name="twitter:image" content="https://www.selectallfromdual.com/logo.png">
        
        <link href="https://fonts.bunny.net/css2?family=Roboto:wght@400;500;700&amp;display=swap" rel="stylesheet">
        <link href="https://fonts.bunny.net/css?family=Material+Icons" rel="stylesheet">
        <link rel="stylesheet" href="<?= $basePath.$subroot ?>/static/css/md3-tokens.css">
        <link rel="stylesheet" href="<?= $basePath.$subroot ?>/static/css/md3-components.css">
        <link rel="stylesheet" href="<?= $basePath.$subroot ?>/static/css/site.css">
        
        <link href="https://www.selectallfromdual.com/blog/feed" rel="alternate" type="application/rss+xml" title="Dummy-X">
        <link rel="me" href="https://mastodon.uno/@selectallfromdual">
	    <link rel="me" href="https://livellosegreto.it/@francommit">
        
        <script src="<?= $basePath.$subroot ?>/static/js/theme-init.js"></script>
    </head>

    <body>
        <div class="site-wrapper">
            <?php require_once($subroot.'layouts/parts/header.php'); ?>
            <main class="site-content">
                <?php
                if ($tPage == '') {
                    require_once($subroot.'layouts/parts/home.php');
                } else if ($tPage == 'projects') {
                    require_once($subroot.'layouts/projects.php');
                } else if ($tPage == 'projectdetail' && $vPage !='') {
                    require_once($subroot.'layouts/projectdetail.php');
                } else if ($tPage == 'page' && $vPage !='') {
                    require_once($subroot.'layouts/page.php');
                } else if ($tPage == 'iframe' && $vPage !='') {
                    require_once($subroot.'layouts/iframe.php');
                } else {
                    http_response_code(404);
                    echo "<h1>404 - Pagina non trovata</h1>";
                }
                ?>
            </main>
            <?php require_once($subroot.'layouts/parts/footer.php'); ?>
        </div>
        <script src="<?= $basePath.$subroot ?>/static/js/theme.js"></script>
        <script src="/_iconstat/tracker.js"></script>
    </body>
    <?php
    // salva cache se non esclusa
    if (!$isExcluded) {
        if (!is_dir($config['cache_dir'])) {
            mkdir($config['cache_dir'], 0777, true);
        }

        $content = ob_get_contents();
        file_put_contents($cacheFile, $content);
    }

    // flush output
    ob_end_flush();
    ?>
</html>
