<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v14\v0\AddTypesToViewHelperClassesRectorTest\Fixture;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class MyViewHelper extends AbstractTagBasedViewHelper
{
    protected $escapeChildren = false;
    protected $escapeOutput = false;
    protected $tagName = 'p';

    public function render()
    {
        return $this->tag->render();
    }
}
?>
-----
<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v14\v0\AddTypesToViewHelperClassesRectorTest\Fixture;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class MyViewHelper extends AbstractTagBasedViewHelper
{
    protected ?bool $escapeChildren = false;
    protected ?bool $escapeOutput = false;
    protected string $tagName = 'p';

    public function render(): mixed
    {
        return $this->tag->render();
    }
}
?>
