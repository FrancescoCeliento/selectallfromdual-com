<?php
require_once $subroot.'lib/Parsedown.php'; // Carica la libreria

$filePath = $dirPath . '/content/apps/' . $vPage . '.md';

if (!empty($vPage) && file_exists($filePath)) {
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
        // Aggiunge target="_blank" a tutti i tag <a>
        $htmlContent = str_replace('<a ', '<a target="_blank" rel="noopener noreferrer" ', $htmlContent);

        ?>
        <article>
            <div class="app-detail-header">
                <img src="<?= $basePath.$subroot ?>/static<?= htmlspecialchars($metadata['logo'] ?? '') ?>" alt="Logo" class="app-detail-logo">
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
                    
                <?php elseif (!empty($metadata['iframe'])): ?>
                    <a href="?page=iframe&v=<?= $vPage; ?>" class="md3-button" rel="noopener">
                        <span class="material-icons">language</span>
                        <span>Run</span>
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

            <div class="app-detail-back">
                <a href="<?= $basePath ?>?page=projects" class="md3-button text">
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
