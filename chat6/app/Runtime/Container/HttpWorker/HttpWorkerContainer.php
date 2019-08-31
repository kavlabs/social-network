<?php

namespace App\Runtime\Container\HttpWorker;

use Kraken\Core\CoreInterface;
use Kraken\Runtime\RuntimeContainer;
use Kraken\Runtime\RuntimeContainerInterface;

class HttpWorkerContainer extends RuntimeContainer implements RuntimeContainerInterface
{
    /**
     * @override
     * @inheritDoc
     */
    protected function config(CoreInterface $core)
    {
        return [];
    }

    /**
     * @override
     * @inheritDoc
     */
    protected function boot(CoreInterface $core)
    {
        return $this;
    }

    /**
     * @override
     * @inheritDoc
     */
    protected function construct(CoreInterface $core)
    {
        $this->onCreate(function() {
            $this->onCreateHandler();
        });

        return $this;
    }

    /**
     *
     */
    private function onCreateHandler()
    {
        $this->getLoop()->addPeriodicTimer(1, function() {
            echo 'Runtime::[' . $this->getAlias() . '] is alive and ' . time() . PHP_EOL;
        });
    }
}
