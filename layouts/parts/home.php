<div class="hero">
    <div class="hero-badge">dev</div>
    <div class="hero-badge">open source</div>
    <div class="hero-badge">privacy focus</div>
    <h1>Dummy<span class="primary-text"> X</span></h1>
    <p class="hero-tagline">Guide e consigli per la privacy e la libertà digitale</p>
    <div class="hero-actions">
        <a href="https://www.selectallfromdual.com/blog" class="md3-button">
            <span class="material-icons">feed</span>
            <span>Read blog</span>
        </a>
        <a href="<?= $basePath ?>?page=projects" class="md3-button">
            <span class="material-icons">apps</span>
            <span>View projects</span>
        </a>
        <a href="<?= $basePath ?>?page=page&v=support" class="md3-button outlined">
            <span class="material-icons">favorite</span>
            <span>Support my work</span>
        </a>
    </div>
</div>
<div class="values-bar">
    <div class="value-item">
        <span class="material-icons">code</span>
        <span>Open Source</span>
    </div>
    <div class="value-item">
        <span class="material-icons">shield</span>
        <span>Privacy</span>
    </div>
    <div class="value-item">
        <span class="material-icons">hub</span>
        <span>Decentralization</span>
    </div>
</div>
<h2 class="section-title"><span class="material-icons">star</span>
    <span>Featured projects</span>
</h2>
<div class="apps-grid">
<?php
$appsPath = $dirPath."/content/apps"; // Percorso della cartella

// Verifica se la directory esiste
if (is_dir($appsPath)) {
    // Recupera tutti i file .md
    $files = glob($appsPath . "/*.md");

    foreach ($files as $file) {
        // ESCLUSIONE: Salta i file che iniziano con l'underscore
        $fileName = basename($file);
        if (str_starts_with($fileName, "_")) {
            continue;
        }

        $content = file_get_contents($file);

        // Estraiamo il blocco Front Matter tra i primi due ---
        if (
            preg_match(
                '/^---\s*\n(.*?)\n---\s*\n/s',
                $content,
                $matches
            )
        ) {

            $yamlData = $matches[1];
            $metadata = [];

            // Parsing semplice riga per riga dello YAML
            foreach (explode("\n", $yamlData) as $line) {
                if (strpos($line, ":") !== false) {
                    list($key, $value) = explode(":", $line, 2);
                    $key = trim($key);
                    $value = trim($value, " \t\n\r\0\x0B\"'");

                    // Gestione speciale per l'array dei badges ["A", "B"]
                    if ($key === "badges") {
                        $value = trim($value, "[]");
                        $metadata[$key] = array_map(
                            fn($b) => trim($b, " \"'"),
                            explode(",", $value)
                        );
                    } else {
                        $metadata[$key] = $value;
                    }
                }
            }

            // Determiniamo lo slug dall'estensione del file (es: fedilab)
            $slug = basename($file, ".md");

            // Output HTML
            ?>
            <a href="<?= $basePath ?>?page=projectdetail&v=<?= $slug ?>" class="app-card md3-card">
                <img src="<?= $basePath.$subroot ?>/static<?= $metadata[
"logo"
] ?? "" ?>" alt="<?= htmlspecialchars(
$metadata["title"] ?? ""
) ?> logo" class="app-card-logo">
                <h3><?= htmlspecialchars(
                    $metadata["title"] ?? ""
                ) ?></h3>
                <p><?= htmlspecialchars(
                    $metadata["description"] ?? ""
                ) ?></p>
                <div class="app-links">
                    <?php if (isset($metadata["badges"])): ?>
                        <?php foreach (
                            $metadata["badges"]
                            as $badge
                        ): ?>
                            <span class="badge info"><?= htmlspecialchars(
                                $badge
                            ) ?></span>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </a>
            <?php
        }
    }
} else {
    echo "Directory non trovata: $appsPath";
}
?>
</div>
<div class="cta-section">
    <h2>Sostieni lo sviluppo indipendente</h2>
    <p>Questo progetto è gratuito e non ha sponsor diretti. Se apprezzi il mio lavoro e vuoi aiutarmi a mantenerlo attivo, puoi offrirmi un caffè. Un piccolo gesto può fare una grande differenza.</p>
    <div class="cta-actions">
        <!--<a href="https://github.com/francescoceliento" class="md3-button" target="_blank" rel="noopener">
            <span class="material-icons">code</span>
            <span>Browse on GitHub</span>
        </a>-->
        <a href="<?= $basePath ?>?page=page&v=support" class="md3-button outlined">
            <span class="material-icons">favorite</span>
            <span>Support my work</span>
        </a>
    </div>
</div>
