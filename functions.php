<?php

function getMarkdownYAMLData($filePath) {
    if (!file_exists($filePath)) return null;

    $content = file_get_contents($filePath);
    
    // Regex più flessibile: gestisce spazi opzionali e diversi tipi di "a capo"
    // Cerca i delimitatori --- anche se non sono perfettamente all'inizio
    $pattern = '/^[\s]*---\s*(.*?)\s*---\s*(.*)/s';
    
    if (preg_match($pattern, $content, $matches)) {
        $yamlString = trim($matches[1]);
        $body = trim($matches[2]);

        $data = [];
        // Esplode per ogni tipo di nuova riga
        $lines = preg_split('/\r\n|\r|\n/', $yamlString);
        
        foreach ($lines as $line) {
            if (strpos($line, ':') !== false) {
                // Separa solo al primo ":" incontrato
                $parts = explode(':', $line, 2);
                $key = trim($parts[0]);
                $value = trim($parts[1], " \t\n\r\0\x0B\"'");
                $data[$key] = $value;
            }
        }

        $data['content'] = $body;
        return $data;
    }

    // Se non trova il front matter, restituisce tutto come content
    return ['content' => trim($content)];
}

// Esempio di utilizzo:
/*$fileData = getMarkdownData('path/to/your/file.md');

echo "Titolo: " . $fileData['title'] . "\n";
echo "Descrizione: " . $fileData['description'] . "\n";*/
?>
