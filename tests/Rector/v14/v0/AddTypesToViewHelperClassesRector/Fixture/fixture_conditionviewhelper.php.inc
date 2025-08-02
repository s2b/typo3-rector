<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v14\v0\AddTypesToViewHelperClassesRectorTest\Fixture;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class MyViewHelper extends AbstractConditionViewHelper
{
    protected $escapeChildren = false;
    protected $escapeOutput = false;

    public static function verdict()
    {
        return true;
    }
}
?>
-----
<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v14\v0\AddTypesToViewHelperClassesRectorTest\Fixture;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;

class MyViewHelper extends AbstractConditionViewHelper
{
    protected ?bool $escapeChildren = false;
    protected ?bool $escapeOutput = false;

    public static function verdict(): bool
    {
        return true;
    }
}
?>
