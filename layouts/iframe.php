<?php

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
                
                if ($key === 'iframe') {
                    $value = trim($value);
                    $iframeurl = $value;
                }
            }
        }
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
    }
} else {
    http_response_code(404);
    echo "<h1>404 - Progetto non trovato</h1>";
}

?>
