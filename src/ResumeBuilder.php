<?php

namespace App;

use Parsedown;
use Dompdf\Dompdf;

class ResumeBuilder
{
    protected $parser;
    protected $theme = 'professional';

    public function __construct()
    {
        $this->parser = new Parsedown();
    }

    public function build($markdownFile)
    {
        if (!file_exists($markdownFile)) {
            throw new \Exception("File not found: {$markdownFile}");
        }

        $markdown = file_get_contents($markdownFile);
        $html = $this->parser->text($markdown);

        return $this->applyTheme($html);
    }

    public function setTheme($theme)
    {
        $this->theme = $theme;
        return $this;
    }

    protected function applyTheme($html)
    {
        $css = $this->getThemeStyles();

        return <<<HTML
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Resume</title>
    <style>{$css}</style>
</head>
<body>
    <div class="resume">
        {$html}
    </div>
</body>
</html>
HTML;
    }

    protected function getThemeStyles()
    {
        $themes = [
            'professional' => '
                body { font-family: Georgia, serif; max-width: 800px; margin: 40px auto; color: #333; }
                h1 { font-size: 32px; margin-bottom: 10px; border-bottom: 2px solid #333; }
                h2 { font-size: 24px; margin-top: 30px; color: #0066cc; }
                h3 { font-size: 18px; margin-top: 20px; }
                ul { list-style-type: disc; margin-left: 20px; }
                strong { color: #000; }
            ',
            'modern' => '
                body { font-family: Arial, sans-serif; max-width: 800px; margin: 40px auto; color: #444; }
                h1 { font-size: 36px; margin-bottom: 5px; color: #2c3e50; }
                h2 { font-size: 22px; margin-top: 25px; color: #e74c3c; border-left: 4px solid #e74c3c; padding-left: 10px; }
                h3 { font-size: 16px; margin-top: 15px; font-weight: bold; }
            ',
            'minimal' => '
                body { font-family: Helvetica, sans-serif; max-width: 700px; margin: 50px auto; color: #222; }
                h1 { font-size: 28px; font-weight: 300; margin-bottom: 15px; }
                h2 { font-size: 20px; font-weight: 400; margin-top: 30px; }
                h3 { font-size: 16px; font-weight: 400; margin-top: 20px; }
            '
        ];

        return $themes[$this->theme] ?? $themes['professional'];
    }

    public function exportToPdf($html, $outputPath)
    {
        $dompdf = new Dompdf();
        $dompdf->loadHtml($html);
        $dompdf->setPaper('A4', 'portrait');
        $dompdf->render();

        file_put_contents($outputPath, $dompdf->output());

        return $outputPath;
    }
}
