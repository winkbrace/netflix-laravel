<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Netflix\Content\Importer;

class ImportVideos extends Command
{
    protected $signature = 'import:videos';
    protected $description = 'Import videos from Netflix api';

    public function handle(Importer $importer)
    {
        $importer->importAll($this->output);

        return Command::SUCCESS;
    }
}
