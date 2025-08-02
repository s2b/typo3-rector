<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v14\v0\AddTypesToViewHelperClassesRectorTest\Fixture;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class MyViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', '');
    }

    public function render(): string
    {
        return $this->arguments['value'];
    }

    public function compile($argumentsName, $closureName, &$initializationPhpCode, ViewHelperNode $node, TemplateCompiler $compiler): string
    {
        return '';
    }
}
?>
-----
<?php

namespace Ssch\TYPO3Rector\Tests\Rector\v14\v0\AddTypesToViewHelperClassesRectorTest\Fixture;

use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class MyViewHelper extends AbstractViewHelper
{
    public function initializeArguments(): void
    {
        $this->registerArgument('value', 'string', '');
    }

    public function render(): string
    {
        return $this->arguments['value'];
    }

    public function compile($argumentsName, $closureName, &$initializationPhpCode, ViewHelperNode $node, TemplateCompiler $compiler): string
    {
        return '';
    }
}
?>
