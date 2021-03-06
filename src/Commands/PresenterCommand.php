<?php namespace RyanNielson\Prez\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

class PresenterCommand extends Command
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'prez:presenter';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "Create a presenter with the given name.";

    /**
     * The filesystem instance.
     *
     * @var \Illuminate\Filesystem\Filesystem
     */
    protected $files;

    /**
     * Create a new configuration publish command instance.
     *
     * @param  \Illuminate\Filesystem\Filesystem $files
     * @return void
     */
    public function __construct(Filesystem $files)
    {
        parent::__construct();

        $this->files = $files;
    }

    /**
     * Execute the console command.
     *
     * @return void
     */
    public function fire()
    {
        $name = studly_case($this->argument('name'));
        $presenterName = "{$name}Presenter";
        $destinationDirectory = $this->option('path');
        $destination = "{$destinationDirectory}/{$presenterName}.php";

        $this->files->isDirectory($destinationDirectory) ?: $this->files->makeDirectory($destinationDirectory);

        $content = $this->prepareTemplate(__DIR__ . '/templates/presenter.txt', ['name' => $name, 'camelname' => camel_case($name)]);

        $this->files->put($destination, $content);

        $this->output->writeln("<info>{$presenterName} created at {$destination}</info>");
    }

    /**
     * Get the console command arguments.
     *
     * @return array
     */
    protected function getArguments()
    {
        return [
            ['name', InputArgument::REQUIRED, 'The name of the presenter.']
        ];
    }

    /**
     * Get the console command options.
     *
     * @return array
     */
    protected function getOptions()
    {
        return [
            ['path', null, InputOption::VALUE_OPTIONAL, 'Where should the presenter be created?', app_path() . '/presenters']
        ];
    }

    private function prepareTemplate($template, $data)
    {
        $contents = $this->files->get($template);

        foreach ($data as $key => $value)
        {
            $contents = preg_replace("/\\$$key\\$/i", $value, $contents);
        }

        return $contents;
    }
}
