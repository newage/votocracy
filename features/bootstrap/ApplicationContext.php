<?php

declare(strict_types=1);

use Behat\Behat\Context\Context;
use Imbo\BehatApiExtension\Context\ApiContext;

class ApplicationContext extends ApiContext implements Context
{
    /**
     * Initializes context.
     *
     * Every scenario gets its own context instance.
     * You can also pass arbitrary arguments to the
     * context constructor through behat.yml.
     */
    public function __construct()
    {
    }
}
