<div class="page-header">
    <h1>Projects</h1>
</div>
<div class="projects-list">
    <?php
    $appsPath = $dirPath . '/content/apps';

    if (is_dir($appsPath)) {
        $files = glob($appsPath . "/*.md");

        foreach ($files as $file) {
            $fileName = basename($file);

            // Escludi file che iniziano con _
            if (str_starts_with($fileName, '_')) {
                continue;
            }

            $content = file_get_contents($file);
            
            // Estrazione Front Matter
            if (preg_match('/^---\s*\n(.*?)\n---\s*\n/s', $content, $matches)) {
                $yamlData = $matches[1];
                $metadata = [];
                
                foreach (explode("\n", $yamlData) as $line) {
                    if (strpos($line, ':') !== false) {
                        list($key, $value) = explode(':', $line, 2);
                        $key = trim($key);
                        $value = trim($value, " \t\n\r\0\x0B\"'");
                        $metadata[$key] = $value;
                    }
                }

                $slug = basename($file, ".md");
                $projectUrl = $basePath . "?page=projectdetail&v=" . $slug ;
                ?>

                <div class="project-card md3-card">
                    <div class="project-card-header">
                        <img src="<?= $basePath.$subroot ?>/static<?= htmlspecialchars($metadata['logo'] ?? '') ?>" alt="Projects logo" class="project-card-logo">
                        <div class="project-card-info">
                            <a href="<?= $projectUrl ?>" class="project-card-title"><?= htmlspecialchars($metadata['title'] ?? '') ?></a>
                            <span class="project-card-platform"><?= htmlspecialchars($metadata['platform'] ?? '') ?></span>
                        </div>
                    </div>
                    
                    <p class="project-card-desc"><?= htmlspecialchars($metadata['description'] ?? '') ?></p>
                    
                    <div class="project-card-actions">
                        <?php if (!empty($metadata['fdroid'])): ?>
                            <a href="<?= htmlspecialchars($metadata['fdroid']) ?>" class="md3-button" target="_blank" rel="noopener">
                                <span class="material-icons">android</span>
                                <span>F-Droid</span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($metadata['playstore'])): ?>
                            <a href="<?= htmlspecialchars($metadata['playstore']) ?>" class="md3-button" target="_blank" rel="noopener">
                                <span class="material-icons">shop</span>
                                <span>Google Play</span>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($metadata['repo'])): ?>
                            <a href="<?= htmlspecialchars($metadata['repo']) ?>" class="md3-button outlined" target="_blank" rel="noopener">
                                <span class="material-icons">code</span>
                                <span>Source</span>
                            </a>
                        <?php endif; ?>

                        <a href="<?= $projectUrl ?>" class="md3-button text">
                            <span class="material-icons">arrow_forward</span>
                            <span>Details</span>
                        </a>
                    </div>
                </div>

                <?php
            }
        }
    }
    ?>
</div>
