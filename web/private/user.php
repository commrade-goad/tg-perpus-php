<?php

class User {
    public int $id;
    public string $name;
    public string $password;
    public int $type;

    public function __construct(int $id, string $name, string $password, int $type) {
        $this->id = $id;
        $this->name = $name;
        $this->password = $password;
        $this->type = $type;
    }
}
