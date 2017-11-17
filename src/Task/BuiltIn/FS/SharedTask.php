<?php

namespace Mage\Task\BuiltIn\FS;

use Mage\Task\Exception\ErrorException;
use Symfony\Component\Process\Process;

class SharedTask extends AbstractFileTask
{
    public function getName()
    {
        return 'fs/shared';
    }

    public function getDescription()
    {
        try {
            return sprintf('[Custom] Creating symbolic link %s to %s', $this->getLink(), $this->getTarget());
        } catch (\Exception $exception) {
            return '[Custom] Creating symbolic link [missing parameters]';
        }
    }

    public function execute()
    {
        $link = $this->getLink();
        $target = $this->getTarget();

        $cmd = sprintf('mkdir -p %s && rm -rf %s && ln -sT %s %s', dirname($link), $link, $target, $link);

        /** @var Process $process */
        $process = $this->runtime->runCommand($cmd);
        return $process->isSuccessful();
    }

    private function getLink()
    {
        if (!array_key_exists('link', $this->options)) {
            throw new ErrorException('Parameter "link" are required.');
        }
        return './'.ltrim($this->options['link'], '/');
    }

    private function getTarget()
    {
        return rtrim($this->runtime->getEnvOption('host_path'), '/').'/shared/'.
            ltrim(array_key_exists('target', $this->options) ? $this->options['target'] : $this->options['link'], '/');
    }

    protected function getParameters()
    {
        return ['link', 'target', 'flags'];
    }
}