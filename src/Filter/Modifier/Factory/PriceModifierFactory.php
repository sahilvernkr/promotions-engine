<?php

namespace App\Filter\Modifier\Factory;

use App\Filter\Modifier\PriceModifierInterface;
use Symfony\Component\VarExporter\Exception\ClassNotFoundException;

class PriceModifierFactory implements PriceModifierFactoryInterface
{
    public function create(string $modifiertype): PriceModifierInterface
    {
        $modifierClassBaseName = str_replace('_', '', ucwords($modifiertype, '_'));

        $modifier = self::PRICE_MODIFIER_NAMESPACE . $modifierClassBaseName;

        if (!class_exists($modifier)) {
            throw new ClassNotFoundException($modifier);
        }

        return new $modifier();
    }
}
