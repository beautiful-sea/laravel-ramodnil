<?php

namespace BeautifulSea\Laravelramodnil\Commands;

use Illuminate\Console\Command;
use File;

class Install extends Command
{
    const ROOT_PATH = __DIR__ . '/../../../../../';
    const SOURCES_PATH = __DIR__ . '/../';

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'ramodnil:install';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        echo "Instalando ramodnil...\n";

        echo "Instalando pacotes NPM...\n";

        $this->installNpmPackages();

        echo "\033[32mPacotes NPM instalados\033[0m\n";

        $this->makeAuth();

        $this->makeNotification();

        echo "Copiando arquivos... ";

        $this->copyMigrations();

        $this->setModels();

        $this->setControllers();

        $this->setNotifications();

        $this->copyFonts();

        $this->setACL();

        $this->setRoutes();

        $this->setStyles();

        $this->setScripts();

        $this->setTemplates();

        echo "\033[32mPronto\033[0m\n";

        echo "\033[32mramodnil instalado com sucesso\033[0m\n";
    }

    public function installNpmPackages() {
        $command = 'npm install';

        exec($command);        

        $npmLibraries = [
            '@fortawesome/fontawesome-free',
            'jquery-validation',
            'datatables.net-bs4',
            'select2',
            '@ttskch/select2-bootstrap4-theme',
            'jquery-maskmoney',
            'jquery-mask-plugin',
            'moment',
            'numeral',
            'webpack-jquery-ui',
            'summernote',
            'codemirror',
            'chart.js',
        ];

        $command = 'npm i ' . implode(' ', $npmLibraries);

        exec($command);
    }

    public function makeAuth() {
        $command = 'php artisan make:auth --force';

        echo "$command \n";

        exec($command);
    }

    public function makeNotification(){

        $command = 'php artisan notifications:table';

        echo "$command \n";

        exec($command);
    }

    public function copyMigrations() {
        File::copyDirectory(self::SOURCES_PATH . '/migrations', self::ROOT_PATH . '/database/migrations');
    }

    public function copyFonts() {
        File::copyDirectory(self::SOURCES_PATH . '/public/fonts', self::ROOT_PATH . '/public/fonts');
    }

    public function setACL() {
        File::copyDirectory(self::SOURCES_PATH . '/Providers', self::ROOT_PATH . '/app/Providers');
        File::copyDirectory(self::SOURCES_PATH . '/Policies', self::ROOT_PATH . '/app/Policies');
    }

    public function setStyles() {
        File::copyDirectory(self::SOURCES_PATH . '/resources/sass', self::ROOT_PATH . '/resources/sass');
        File::copyDirectory(self::SOURCES_PATH . '/public/css', self::ROOT_PATH . '/public/css');
    }

    public function setScripts() {        
        $command = 'php artisan vendor:publish --tag=bootstrap_forms_js --force';

        exec($command);

        File::copyDirectory(self::SOURCES_PATH . '/resources/js', self::ROOT_PATH . '/resources/js');
        File::copyDirectory(self::SOURCES_PATH . '/public/js', self::ROOT_PATH . '/public/js');

        $bootstrapJsFile = self::ROOT_PATH . '/resources/js/bootstrap.js';
        $requireCommand = "require('./ramodnil');";

        $file = fopen($bootstrapJsFile, 'r');

        $addLine = true;
        while (($line = fgets($file)) !== false) {
            if ($line == $requireCommand) {
                $addLine = false;
            }
        }

        fclose($file);

        if ($addLine) {
            $file = fopen($bootstrapJsFile, 'a');
            fwrite($file, "\n\n" . $requireCommand);
            fclose($file);
        }
    }

    public function setModels() {
        File::copyDirectory(self::SOURCES_PATH . '/models', self::ROOT_PATH . '/app');
    }

    public function setControllers() {
        File::copyDirectory(self::SOURCES_PATH . '/Controllers', self::ROOT_PATH . '/app/Http/Controllers');
    }

    public function setNotifications(){
        File::copyDirectory(self::SOURCES_PATH . '/Notifications', self::ROOT_PATH . '/app/Http/Notifications');
    }

    public function setTemplates() {
        File::copyDirectory(self::SOURCES_PATH . '/resources/views', self::ROOT_PATH . '/resources/views');
    }

    public function setI18n() {
        File::copyDirectory(self::SOURCES_PATH . '/resources/lang', self::ROOT_PATH . '/resources/lang');
    }

    public function copyImages() {
        File::copyDirectory(self::SOURCES_PATH . '/public/images', self::ROOT_PATH . '/public/images');
    }

    public function setRoutes() {
        $routesFile = self::ROOT_PATH . '/routes/web.php';
        $command = '\BeautifulSea\LaravelRamodnil\LaravelRamodnilServiceProvider::routes();';

        $file = fopen($routesFile, 'r');

        $addLine = true;
        while (($line = fgets($file)) !== false) {
            if ($line == $command) {
                $addLine = false;
            }
        }

        fclose($file);

        if ($addLine) {
            $file = fopen($routesFile, 'a');
            fwrite($file, "\n\n" . $command);
            fclose($file);
        }
    }
}
