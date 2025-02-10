<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class CreateBaseRepositoryCommand extends Command
{
    protected $signature = 'make:base-repository';
    protected $description = 'Create a base repository class';

    public function handle()
    {
        $path = app_path('Repositories');
        if (!File::exists($path)) {
            File::makeDirectory($path, 0755, true);
        }

        $content = <<<'EOT'
<?php

namespace App\Repositories;

abstract class BaseRepository {
protected $model;

public function all() {
return $this->model->all();
}
public function find($id) {
return $this->model->findOrFail($id);
}
public function create(array $data) {
return $this->model->create($data);
}
public function update($id, array $data) {
$record = $this->find($id);
$record->update($data);
return $record;
}
public function delete($id) {
return $this->find($id)->delete();
}
}
EOT;

        File::put($path . '/BaseRepository.php', $content);
        $this->info('Base repository created successfully at: ' . $path . '/BaseRepository.php');
    }
}
