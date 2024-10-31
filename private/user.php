<?php

class User {
    public int $id;
    public string $password;
    public int $type;

    public function __construct(int $id, string $password, int $type) {
        $this->id = $id;
        $this->password = $password;
        $this->type = $type;
    }
}
