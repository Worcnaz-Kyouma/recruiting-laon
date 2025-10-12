<?php

namespace App\Entities;

class Actor extends MediaWorker {
    public function __construct(int $tmbdId, string $name) {
        parent::__construct($tmbdId, $name);
    }
}
