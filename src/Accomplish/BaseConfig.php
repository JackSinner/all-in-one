<?php

namespace Library\Europe\Accomplish;

class BaseConfig
{
    private function __clone()
    {
    }

    public function toArray(): array
    {
        $ref = new \ReflectionObject($this);
        $result = [];
        $proper = $ref->getProperties();
        if ($proper) {
            foreach ($proper as $item) {
                /** @var \ReflectionProperty $item */
                if ($item->isPublic()) {
                    $value = $item->getValue($this);
                    if (!is_null($value)) {
                        if ($value instanceof BaseConfig) {
                            $value = $value->toArray();
                        }
                        $result[$item->getName()] = $value;
                    }
                }
            }
        }
        return $result;
    }

    public function __toString(): string
    {
        return json_encode($this->toArray());
    }
}