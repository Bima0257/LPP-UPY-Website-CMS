<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class MakeServiceCommand extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Generate a service class';

    public function handle()
    {
        $name = $this->argument('name');

        $path = app_path('Services/' . $name . '.php');

        // Buat folder Services jika belum ada
        if (!File::isDirectory(app_path('Services'))) {
            File::makeDirectory(app_path('Services'));
        }

        // Cegah overwrite
        if (File::exists($path)) {
            $this->error("Service {$name} already exists!");
            return;
        }

        // Template kelas service
        $template = <<<EOT
<?php

namespace App\Services;

class {$name}
{
    // Your service logic here
}
EOT;

        File::put($path, $template);

        $this->info("Service {$name} created successfully at: app/Services/{$name}.php");
    }
}
