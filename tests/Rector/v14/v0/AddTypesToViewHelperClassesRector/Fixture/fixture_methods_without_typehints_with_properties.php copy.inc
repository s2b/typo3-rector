<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v14\v0\AddTypesToViewHelperClassesRectorTest\Fixture;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class MyViewHelper extends AbstractViewHelper
{
    protected $escapeChildren = false;
    protected $escapeOutput = false;

    public function initializeArguments()
    {
        $this->registerArgument('value', 'string', '');
    }

    public function render()
    {
        return $this->arguments['value'];
    }
}
?>
-----
<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v14\v0\AddTypesToViewHelperClassesRectorTest\Fixture;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class MyViewHelper extends AbstractViewHelper
{
    protected ?bool $escapeChildren = false;
    protected ?bool $escapeOutput = false;

    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', '');
    }

    public function render(): mixed
    {
        return $this->arguments['value'];
    }
}
?>
