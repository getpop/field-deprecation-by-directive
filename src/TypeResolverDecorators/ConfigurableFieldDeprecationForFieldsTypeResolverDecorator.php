<?php

declare(strict_types=1);

namespace PoP\FieldDeprecationByDirective\TypeResolverDecorators;

use PoP\FieldDeprecationByDirective\Facades\FieldDeprecationManagerFacade;
use PoP\ComponentModel\Facades\Schema\FieldQueryInterpreterFacade;
use PoP\Engine\DirectiveResolvers\AddFeedbackForFieldDirectiveResolver;
use PoP\MandatoryDirectivesByConfiguration\TypeResolverDecorators\AbstractMandatoryDirectivesForFieldsTypeResolverDecorator;

class ConfigurableFieldDeprecationForFieldsTypeResolverDecorator extends AbstractMandatoryDirectivesForFieldsTypeResolverDecorator
{
    protected static function getConfigurationEntries(): array
    {
        $fieldDeprecationManager = FieldDeprecationManagerFacade::getInstance();
        return $fieldDeprecationManager->getEntriesForFields();
    }

    protected function getMandatoryDirectives($entryValue = null): array
    {
        $message = $entryValue;
        $fieldQueryInterpreter = FieldQueryInterpreterFacade::getInstance();
        $directiveName = AddFeedbackForFieldDirectiveResolver::getDirectiveName();
        $fieldDeprecationDirective = $fieldQueryInterpreter->getDirective(
            $directiveName,
            [
                'message' => $message,
                'type' => AddFeedbackForFieldDirectiveResolver::FEEDBACK_TYPE_DEPRECATION,
                'target' => AddFeedbackForFieldDirectiveResolver::FEEDBACK_TARGET_SCHEMA,
            ]
        );
        return [
            $fieldDeprecationDirective,
        ];
    }
}
