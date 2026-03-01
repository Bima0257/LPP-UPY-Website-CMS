<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeTrait extends Command
{
    protected $signature = 'make:trait {name : The name of the trait}';
    protected $description = 'Create a new Trait class';

    public function handle()
    {
        $name = $this->argument('name');
        $filesystem = new Filesystem();

        // Path Traits
        $path = app_path('Traits/' . $name . '.php');

        // Buat folder Traits kalau belum ada
        if (! $filesystem->isDirectory(app_path('Traits'))) {
            $filesystem->makeDirectory(app_path('Traits'));
        }

        // Cegah overwrite
        if ($filesystem->exists($path)) {
            $this->error("Trait {$name} already exists!");
            return Command::FAILURE;
        }

        // Template isi trait
        $stub = <<<EOT
<?php

namespace App\Traits;

trait {$name}
{
    //
}
EOT;

        // Buat file trait
        $filesystem->put($path, $stub);

        $this->info("Trait {$name} created successfully.");
        return Command::SUCCESS;
    }
}
