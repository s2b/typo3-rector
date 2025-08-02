<?php

declare(strict_types=1);

/*
 * This file belongs to the package "TYPO3 Fluid".
 * See LICENSE.txt that was shipped with this package.
 */

namespace Ssch\TYPO3Rector\TYPO314\v0;

use PhpParser\Node;
use PhpParser\Node\Identifier;
use PhpParser\Node\Stmt\Class_;
use PhpParser\Node\Stmt\ClassMethod;
use PhpParser\Node\Stmt\Property;
use Rector\Rector\AbstractRector;
use Symplify\RuleDocGenerator\Contract\DocumentedRuleInterface;
use Symplify\RuleDocGenerator\ValueObject\CodeSample\CodeSample;
use Symplify\RuleDocGenerator\ValueObject\RuleDefinition;
use TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormFieldViewHelper;
use TYPO3\CMS\Fluid\ViewHelpers\Form\AbstractFormViewHelper;
use TYPO3\CMS\Fluid\ViewHelpers\Format\AbstractEncodingViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractConditionViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper;

class AddTypesToViewHelperClassesRector extends AbstractRector implements DocumentedRuleInterface
{
    public function getRuleDefinition(): RuleDefinition
    {
        return new RuleDefinition('Add type hints to ViewHelper classes', [new CodeSample(
            <<<'CODE_SAMPLE'
class MyViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
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
CODE_SAMPLE
            ,
            <<<'CODE_SAMPLE'
class MyViewHelper extends \TYPO3Fluid\Fluid\Core\ViewHelper\AbstractViewHelper
{
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
CODE_SAMPLE
        )]);
    }

    /**
     * @return array<class-string<Node>>
     */
    public function getNodeTypes(): array
    {
        return [Class_::class];
    }

    /**
     * @param Class_ $classNode
     */
    public function refactor(Node $classNode): ?Node
    {
        if ($this->shouldSkip($classNode)) {
            return null;
        }

        $classChanged = false;

        // Set correct return type for initializeArguments()
        $initializeArguments = $classNode->getMethod('initializeArguments');
        if ($initializeArguments instanceof ClassMethod && ! $initializeArguments->returnType) {
            $initializeArguments->returnType = new Identifier('void');
            $classChanged = true;
        }

        // Set correct return type for compile()
        $compile = $classNode->getMethod('compile');
        if ($compile instanceof ClassMethod && ! $compile->returnType) {
            $compile->returnType = new Identifier('string');
            $classChanged = true;
        }

        // Set fallback "mixed" type for render()
        $render = $classNode->getMethod('render');
        if ($render instanceof ClassMethod && ! $render->returnType) {
            $render->returnType = new Identifier('mixed');
            $classChanged = true;
        }

        // Set correct types for escaping flags
        $escapeChildren = $classNode->getProperty('escapeChildren');
        if ($escapeChildren instanceof Property) {
            $escapeChildren->type = new Identifier('?bool');
            $classChanged = true;
        }

        $escapeOutput = $classNode->getProperty('escapeOutput');
        if ($escapeOutput instanceof Property) {
            $escapeOutput->type = new Identifier('?bool');
            $classChanged = true;
        }

        // Set return type for verdict() in condition ViewHelpers
        if ($this->isName($classNode->extends, AbstractConditionViewHelper::class)) {
            $verdict = $classNode->getMethod('verdict');
            if ($verdict instanceof ClassMethod && ! $verdict->returnType) {
                $verdict->returnType = new Identifier('bool');
                $classChanged = true;
            }
        }

        // Set type for $tagName in tag-based ViewHelpers
        if ($this->isNames(
            $classNode->extends,
            [AbstractTagBasedViewHelper::class, AbstractFormViewHelper::class, AbstractFormFieldViewHelper::class]
        )) {
            $tagName = $classNode->getProperty('tagName');
            if ($tagName instanceof Property) {
                $tagName->type = new Identifier('string');
                $classChanged = true;
            }
        }

        return $classChanged ? $classNode : null;
    }

    private function shouldSkip(Class_ $classNode): bool
    {
        $parentClasses = [
            AbstractViewHelper::class,
            AbstractTagBasedViewHelper::class,
            AbstractConditionViewHelper::class,
            AbstractFormViewHelper::class,
            AbstractFormFieldViewHelper::class,
            AbstractEncodingViewHelper::class,
        ];
        if ($this->isNames($classNode, $parentClasses)) {
            return true;
        }

        return ! $classNode->extends || ! $this->isNames($classNode->extends, $parentClasses);
    }
}
