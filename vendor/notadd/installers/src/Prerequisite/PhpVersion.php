<?php
/**
 * This file is part of Notadd.
 *
 * @author TwilRoad <269044570@qq.com>
 * @copyright (c) 2016, iBenchu.org
 * @datetime 2016-08-27 19:30
 */
namespace Notadd\Installer\Prerequisite;

use Notadd\Installer\Abstracts\Prerequisite;

/**
 * Class PhpVersion.
 */
class PhpVersion extends Prerequisite
{
    /**
     * @var string
     */
    protected $minVersion;

    /**
     * PhpVersion constructor.
     *
     * @param $minVersion
     */
    public function __construct($minVersion)
    {
        $this->minVersion = $minVersion;
    }

    /**
     * Checking prerequisite's rules.
     */
    public function check()
    {
        if (version_compare(PHP_VERSION, $this->minVersion, '<')) {
            $this->errors[] = [
                'message' => "PHP {$this->minVersion} is required.",
                'detail' => 'You are running version ' . PHP_VERSION . '. Talk to your hosting provider about upgrading to the latest PHP version.',
            ];
        }
    }
}
