<?php
declare(strict_types=1);

namespace Vohinc\GsutilSync\Process;

use Illuminate\Support\Facades\File;
use Vohinc\GsutilSync\Exceptions\MissingBinException;

class CheckBinFileProcess implements ProcessInterface
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
     * @return boolean
     * @throws \Vohinc\GsutilSync\Exceptions\MissingBinException
     */
    public function run()
    {
        if (File::exists($this->path)) {
            return true;
        }

        throw new MissingBinException();
    }
}
