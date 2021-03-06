<?php
/*
 * This file is part of the Magallanes package.
 *
 * (c) Andrés Montañez <andres@andresmontanez.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Mage\Tests;

use Mage\MageApplication;
use Mage\Runtime\Exception\RuntimeException;
use Mage\Runtime\Runtime;
use Symfony\Component\Console\Tester\ApplicationTester;
use Exception;
use PHPUnit_Framework_TestCase as TestCase;

class MageApplicationTest extends TestCase
{
    public function testValidConfiguration()
    {
        $application = new MageApplication(__DIR__ . '/Resources/basic.yml');
        $this->assertTrue($application instanceof MageApplication);
    }

    public function testInValidConfiguration()
    {
        try {
            $application = new MageApplication(__DIR__ . '/Resources/invalid.yml');
            $application->configure();
            $this->assertTrue(false, 'Application did not throw exception.');
        } catch (Exception $exception) {
            $this->assertTrue($exception instanceof RuntimeException);
            $this->assertEquals(sprintf('The file "%s" does not have a valid Magallanes configuration.', __DIR__ . '/Resources/invalid.yml'), $exception->getMessage());
        }
    }

    public function testConfigurationWithDefaultEnvironment()
    {
        $application = new MageApplication(__DIR__ . '/Resources/basic-with-default-env.yml');
        $application->configure();
        // options
        $application->getRuntime()->setEnvironment('production');
        $this->assertEquals(
            $application->getRuntime()->getEnvOption('host_path', 'default'),
            '/var/www/myapp'
        );
        $this->assertEquals(
            $application->getRuntime()->getEnvOption('releases', 'default'),
            '4'
        );
        $this->assertEquals(
            $application->getRuntime()->getEnvOption('exclude', 'default'),
            'default'
        );
        // tasks
        $application->getRuntime()->setStage(Runtime::ON_DEPLOY);
        $this->assertEquals(
            $application->getRuntime()->getTasks(),
            [
                ['symfony/cache-warmup' => ['env' => 'dev']],
                ['symfony/assets-install' => ['env' => 'dev']],
                ['symfony/assetic-dump' => ['env' => 'dev']],
            ]
        );
        $application->getRuntime()->setStage(Runtime::ON_RELEASE);
        $this->assertEquals(
            $application->getRuntime()->getTasks(),
            []
        );
        $application->getRuntime()->setStage(Runtime::POST_RELEASE);
        $this->assertEquals(
            $application->getRuntime()->getTasks(),
            [['symfony/assetic-dump' => ['env' => 'dev']]]
        );
    }

    public function testParserError()
    {
        try {
            $application = new MageApplication(__DIR__ . '/Resources/invalid-yaml.yml');
            $application->configure();
            $this->assertTrue(false, 'Application did not throw exception.');
        } catch (Exception $exception) {
            $this->assertTrue($exception instanceof RuntimeException);
            $this->assertEquals(sprintf('Error parsing the file "%s".', __DIR__ . '/Resources/invalid-yaml.yml'), $exception->getMessage());
        }
    }

    public function testInvalidFile()
    {
        try {
            $application = new MageApplication(__DIR__ . '/Resources/this-does-not-exists.yml');
            $application->configure();
            $this->assertTrue(false, 'Application did not throw exception.');
        } catch (Exception $exception) {
            $this->assertTrue($exception instanceof RuntimeException);
            $this->assertEquals(sprintf('The file "%s" does not exists or is not readable.', __DIR__ . '/Resources/this-does-not-exists.yml'), $exception->getMessage());
        }
    }

    public function testAppDispatcher()
    {
        $application = new MageApplication(__DIR__ . '/Resources/basic.yml');
        $application->setAutoExit(false);
        $this->assertTrue($application instanceof MageApplication);

        $application->register('foo')->setCode(function () {
            throw new \RuntimeException('foo');
        });

        $tester = new ApplicationTester($application);
        $tester->run(['command' => 'foo']);

        $this->assertContains('Oops, exception thrown while running command foo', $tester->getDisplay());
    }
}
