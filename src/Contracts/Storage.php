<?php

namespace CliqueTI\Storage\Contracts;

interface Storage {
    public function store(array $file, string $folder=null);
    public function storeAs(array $file, string $name, string $folder=null);

}