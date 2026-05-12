<?php
require_once $subroot.'lib/Parsedown.php';

$filePath = $dirPath . '/content/' . $vPage . '.md';

if (file_exists($filePath)) {
    $fileContent = file_get_contents($filePath);
    
    // Separiamo il Front Matter dal corpo del testo
    $parts = preg_split('/^---[\s]*$/m', $fileContent, 3);
    
    if (count($parts) >= 3) {
        $yamlData = trim($parts[1]);
        $bodyMarkdown = trim($parts[2]);
        $metadata = [];
        
        // Estraiamo i metadati (per il titolo della pagina)
        foreach (explode("\n", $yamlData) as $line) {
            if (strpos($line, ':') !== false) {
                list($key, $value) = explode(':', $line, 2);
                if($key==='iframe' && $value!='') {
                    $iframeurl = trim($value, " \t\n\r\0\x0B\"'");
                } else {
                    $metadata[trim($key)] = trim($value, " \t\n\r\0\x0B\"'");
                }
            }
        }
        
        if (isset($iframeurl)) {
            ?>
             <style>
             .iframe-full {
                position: absolute;
                top: 0;
                left: 0;
                width: 100vw;  /* 100% della larghezza della finestra */
                height: 100vh; /* 100% dell'altezza della finestra */
                border: none;
             }
             </style>
             <iframe src="<?=$iframeurl;?>" class="iframe-full"></iframe> 
            <?php
        } else {
        
            // Inizializziamo Parsedown
            $parsedown = new Parsedown();
            
            // IMPORTANTE: Abilitiamo la gestione dei blocchi HTML sicuri 
            // per permettere ai div delle "support-cards" di passare inalterati
            $htmlContent = $parsedown->text($bodyMarkdown);
            // Aggiunge target="_blank" a tutti i tag <a>
            $htmlContent = str_replace('<a ', '<a target="_blank" rel="noopener noreferrer" ', $htmlContent);

            ?>
            <main class="site-content">
                <article>
                    <div class="page-header">
                        <h1><?= htmlspecialchars($metadata['title']) ?></h1>
                        <h2><?= htmlspecialchars($metadata['description']) ?></h2>
                    </div>
                    
                    <div class="page-content">
                        <?= $htmlContent ?>
                    </div>
                </article>
            </main>
            <?php
        }
    }
} else {
    echo "Pagina non trovata.";
}
?>
