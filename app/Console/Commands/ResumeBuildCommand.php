<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\ResumeBuilder;

class ResumeBuildCommand extends Command
{
    protected $signature = 'resume:build {file} {--theme=professional}';
    protected $description = 'Build HTML resume from markdown';

    public function handle()
    {
        $file = $this->argument('file');
        $theme = $this->option('theme');

        try {
            $builder = new ResumeBuilder();
            $html = $builder->setTheme($theme)->build($file);

            $outputFile = str_replace('.md', '.html', $file);
            file_put_contents($outputFile, $html);

            $this->info("Resume built successfully: {$outputFile}");
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
