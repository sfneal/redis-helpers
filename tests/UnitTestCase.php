<?php

namespace Sfneal\Helpers\Redis\Tests;

use Sfneal\Helpers\Redis\Tests\Unit\Traits\DeleteTest;
use Sfneal\Helpers\Redis\Tests\Unit\Traits\ExistsTest;
use Sfneal\Helpers\Redis\Tests\Unit\Traits\GetTest;
use Sfneal\Helpers\Redis\Tests\Unit\Traits\KeysTest;
use Sfneal\Helpers\Redis\Tests\Unit\Traits\MissingTest;
use Sfneal\Helpers\Redis\Tests\Unit\Traits\RememberTest;
use Sfneal\Helpers\Redis\Tests\Unit\Traits\SetTest;
use Sfneal\Helpers\Redis\Tests\Unit\Traits\TtlTest;

abstract class UnitTestCase extends TestCase
{
    use DeleteTest;
    use ExistsTest;
    use GetTest;
    use KeysTest;
    use MissingTest;
    use RememberTest;
    use SetTest;
    use TtlTest;
}
