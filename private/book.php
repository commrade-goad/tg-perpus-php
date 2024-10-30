<?php

class Book {
    public int $id;
    public string $title;
    public string $author;
    public string $desc;
    public array $tags;
    public string $year;
    public string $cover;

    public function __construct(int $id, string $title, string $author, string $desc, array $tags, string $year, string $cover) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->desc = $desc;
        $this->tags = $tags;
        $this->year = $year;
        $this->cover = $cover;
    }
}
