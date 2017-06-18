<?php
declare (strict_types=1);

namespace Vohinc\GsutilSync\Commands;

use Illuminate\Console\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Wilderborn\Partyline\Facade as Partyline;

/**
 * Class AbstractCommand
 *
 * @package Vohinc\GsutilSync\Commands
 */
abstract class AbstractCommand extends Command
{
    /**
     * @var array
     */
    protected $config;

    /**
     * AbstractCommand constructor.
     */
    public function __construct()
    {
        parent::__construct();
        $this->config = config('gsutil-sync');
    }

    /**
     * Run the console command.
     *
     * @param  \Symfony\Component\Console\Input\InputInterface  $input
     * @param  \Symfony\Component\Console\Output\OutputInterface  $output
     * @return int
     */
    public function run(InputInterface $input, OutputInterface $output)
    {
        Partyline::bind($this);

        return parent::run($input, $output);
    }
}
