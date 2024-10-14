<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use function Laravel\Prompts\select;

class CreateTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'make:template {name} {--type=}';

    /**
     * The console command description.
     */
    protected $description = 'Create a new PDF template for invoice or estimate';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $templateName = $this->argument('name');
        $type = $this->option('type') ?? select(
            'Create a PDF template for?',
            ['invoice', 'estimate']
        );

        $templatePath = "app/templates/{$type}/{$templateName}.blade.php";
        if (Storage::exists($templatePath)) {
            $this->error('PDF template with given name already exists.');
            return Command::FAILURE;
        }

        try {
            $this->createPdfTemplate($type, $templateName);
            $this->copyPdfImages($type, $templateName);

            $path = storage_path("app/templates/{$type}/{$templateName}.blade.php");
            $this->components->info(ucfirst($type) . " PDF template created successfully at " . $path);

            return Command::SUCCESS;
        } catch (\Exception $e) {
            $this->components->error("Failed to create PDF template: " . $e->getMessage());
            return Command::FAILURE;
        }
    }

    /**
     * Create the PDF template file.
     */
    private function createPdfTemplate(string $type, string $templateName): void
    {
        $sourcePath = storage_path("app/templates/{$type}/{$type}1.blade.php");
        $destinationPath = storage_path("app/templates/{$type}/{$templateName}.blade.php");
        
        $this->comment("Source path: {$sourcePath}");
        $this->comment("Destination path: {$destinationPath}");

        if (!file_exists($sourcePath)) {
            throw new \RuntimeException("Source template file does not exist: {$sourcePath}");
        }

        if (!copy($sourcePath, $destinationPath)) {
            $error = error_get_last();
            throw new \RuntimeException("Failed to copy template file. Error: " . ($error['message'] ?? 'Unknown error'));
        }

        if (!file_exists($destinationPath)) {
            throw new \RuntimeException("Failed to verify copied template file: {$destinationPath}");
        }
    }

    /**
     * Copy the PDF template images.
     */
    private function copyPdfImages(string $type, string $templateName): void
    {
        $sourceResource = resource_path("static/img/PDF/{$type}1.png");
        $destinationResource = resource_path("static/img/PDF/{$templateName}.png");
        $destinationPublic = public_path("build/img/PDF/{$templateName}.png");

        $this->comment("Preview image source: {$sourceResource}");
        $this->comment("Preview image destination: {$destinationResource}");
        $this->comment("Preview image public: {$destinationPublic}");

        if (!file_exists($sourceResource)) {
            throw new \RuntimeException("Source resource image does not exist: {$sourceResource}");
        }
    }
}
