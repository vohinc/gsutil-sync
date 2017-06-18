<?php
declare (strict_types=1);

namespace Vohinc\GsutilSync\Process;

use Illuminate\Support\Facades\File;
use Vohinc\GsutilSync\Exceptions\MissingConfigException;

class CheckCfgProcess implements ProcessInterface
{
    /**
     * @var string
     */
    private $path;

    /**
     * CheckBinFileProcess constructor.
     *
     * @param $path
     */
    public function __construct($path)
    {
        $this->path = $path;
    }

    /**
     * Run process
     *
     * @return boolean
     * @throws \Vohinc\GsutilSync\Exceptions\MissingConfigException
     */
    public function run()
    {
        if (File::exists(realpath($this->path))) {
            return true;
        }

        throw new MissingConfigException();
    }
}
