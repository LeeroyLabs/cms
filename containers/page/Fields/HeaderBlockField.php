<?php

namespace Page\Fields;

use ReflectionClass;
use SailCMS\Collection;
use SailCMS\Models\Entry\Field;
use SailCMS\Types\Fields\InputTextField;
use SailCMS\Types\StoringType;

class HeaderBlockField extends Field
{
    public function description(): string
    {
        return "Field to represent header blocks";
    }

    public function storingType(): string
    {
        return StoringType::ARRAY->value;
    }

    public function defaultSettings(): Collection
    {
        return new Collection([
            'blockTitle' => InputTextField::defaultSettings(),
            'blockDescription' => InputTextField::defaultSettings(true)
        ]);
    }

    protected function defineBaseConfigs(): void
    {
        $this->baseConfigs = new Collection([
            'blockTitle' => InputTextField::class,
            'blockDescription' => InputTextField::class
        ]);
    }

    protected function validate(Collection $content): ?Collection
    {
        $errors = new Collection();

        if (!$content->get('blockTitle') && !$content->get('blockDescription')) {
            $errors->push('You must set at least blockTitle or blockDescription');
        }

        return $errors;
    }
}