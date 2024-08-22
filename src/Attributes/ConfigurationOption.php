<?php

namespace TimWithers\TeamNotificationSettings\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS | Attribute::IS_REPEATABLE)]
class ConfigurationOption
{
    public function __construct(
        public string $label,
        public string $field,
        public string $rules,
        public mixed $default = null
    ) {}
}
