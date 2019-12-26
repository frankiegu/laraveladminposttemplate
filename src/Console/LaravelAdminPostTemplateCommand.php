<?php

namespace yangze\LaravelAdminPostTemplate\Console;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

/**
 *
 */
class LaravelAdminPostTemplateCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    //php artisan admin:post-template --module=Crm --post=Post --cat=Category --stat=Statistic --comm=Comment
    /**
     *
     */
    protected $signature = 'admin:post-template
{--force : force to replace exists file}
{--module= : the Module name}
{--post= : the Post controller name}
{--cat= : the Category controller name}
{--comm= : the Comment controller name}
{--stat= : the Statistic controller name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'create backend module with post template';

    /**
     *
     */
    protected $sectionList = [
        'module' => 'module',
        'post' => 'post',
        'category' => 'cat',
        'statistic' => 'stat',
        'comment' => 'comm',
    ];
    /**
     *
     */
    protected $sectionNameList = [];
    /**
     *
     */
    protected $filesystem;


    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
        $this->filesystem = new Filesystem;
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        if (empty($this->option('module'))
            || empty($this->option('post'))
            || empty($this->option('cat'))
            || empty($this->option('stat'))
            || empty($this->option('comm'))
        ) {
            $this->table(['options', 'example'], [
                ['--module', 'Cms'],
                ['--post', 'Post'],
                ['--cat', 'Category'],
                ['--comm', 'Comment'],
                ['--stat', 'Statistic'],
            ]);
            $this->warn('php artisan admin:post-template --module=Crm --post=Post --cat=Category --stat=Statistic --comm=Comment');
            return $this->error('option missing');
        }
        // 文件列表
        foreach ($this->sectionList as $sectionKey => $option) {
            if (!$this->hasOption($option)) {
                continue;
            }
            $this->sectionNameList['Dummy' . ucfirst($sectionKey)] = $this->option($option);
            $this->sectionNameList['DummyName' . ucfirst($sectionKey)] = $this->uncamelize($this->option($option));
        }
        $this->sectionNameList['stub'] = 'php';
        
        $this->alert("generator file");

        // 迁移文件
        $fileTypeList = [
            'Controllers' => admin_path('/Controllers/' . $this->sectionNameList['DummyModule']),
            'migrations' => database_path('/migrations/'),
            'Models' => app_path('Models/' . $this->sectionNameList['DummyModule']),
        ];
        foreach ($fileTypeList as $stubPath => $dir) {
            foreach ($this->filesystem->glob(__DIR__ . '/stubs/' . $stubPath . '/*.stub') as $stub) {
                $this->copyFile($stub, $dir, $stubPath == 'migrations' ? date("Y_m_d_His_") : '');
            }
        }

        //生成提示信息
        $this->alert("the next step you should do");
        $this->info($this->replaceDummy($this->filesystem->get(__DIR__ . '/stubs/Other/route.stub')));
    }

    /**
     * copyFile
     *
     * @param $file
     * @param $dir
     * @param $prefix
     *
     * @return
     */
    protected function copyFile($file, $dir, $prefix = '')
    {
        if (!$this->filesystem->exists($file)) {
            return;
        }
        if (!$this->filesystem->isDirectory($dir)) {
            $this->filesystem->makeDirectory($dir, 0777, true, true);
        }

        $fileName = $prefix . $this->filesystem->basename($file);
        $newFileName = $this->replaceDummy($fileName);
        $newRealFilePath = $dir . '/' . $newFileName;
        if (!$this->option('force') && $this->filesystem->exists($newRealFilePath)) {
            $this->warn($newFileName. ' exists!');
            return;
        }
        $newContent = $this->replaceDummy($this->filesystem->get($file));
        $this->filesystem->put($dir . '/' . $newFileName, $newContent);
        $this->info($newFileName . ' OK');
    }

    /**
     * replaceDummy
     *
     * @param $content
     *
     * @return
     */
    protected function replaceDummy($content = '')
    {
        return str_replace(array_keys($this->sectionNameList), array_values($this->sectionNameList), $content);
    }

    /**
     * uncamelize
     *
     * @param $camelCaps
     * @param $separator
     *
     * @return
     */
    protected function uncamelize($camelCaps, $separator = '_')
    {
        return strtolower(preg_replace('/([a-z])([A-Z])/', "$1" . $separator . "$2", $camelCaps));
    }
}
