<?php

class Tag {
    public int $id;
    public string $name;
    public string $img;

    public function __construct(int $id, string $name, string $img) {
        $this->id = $id;
        $this->name = $name;
        $this->img = $img;
    }
}

