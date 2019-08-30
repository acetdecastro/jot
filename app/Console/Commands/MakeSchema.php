<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use DB;

class MakeSchema extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:schema {name?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create schema in connected DB';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->info('Creating schema...');

        $schemaName = $this->argument('name') ?: config("database.connections.mysql.database");

        $charset = config("database.connections.mysql.charset",'utf8');
        $collation = config("database.connections.mysql.collation",'utf8_bin');

        $query = "CREATE SCHEMA `".$schemaName."` DEFAULT CHARACTER SET ".$charset." COLLATE ".$collation.";";

        DB::connection('mysql-basic')->statement($query);

        $this->info('Success!');
    }
}
