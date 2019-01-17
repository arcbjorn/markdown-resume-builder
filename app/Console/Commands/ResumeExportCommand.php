<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ResumeBuilder;

class ResumeExportCommand extends Command
{
    protected $signature = 'resume:export {file} {--format=pdf} {--theme=professional}';
    protected $description = 'Export resume to PDF';

    public function handle()
    {
        $file = $this->argument('file');
        $format = $this->option('format');
        $theme = $this->option('theme');

        try {
            $builder = new ResumeBuilder();
            $html = $builder->setTheme($theme)->build($file);

            if ($format === 'pdf') {
                $outputFile = str_replace('.md', '.pdf', $file);
                $builder->exportToPdf($html, $outputFile);
                $this->info("Resume exported to PDF: {$outputFile}");
            } else {
                $this->error("Unsupported format: {$format}");
            }
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
