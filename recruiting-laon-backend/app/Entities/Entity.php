<?php

namespace App\Entities;

abstract class Entity {
    abstract public function toArray(): array;
}
