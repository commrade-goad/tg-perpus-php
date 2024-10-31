<?php

class Book implements JsonSerializable{
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

    public function jsonSerialize() {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'desc' => $this->desc,
            'tags' => $this->tags,
            'year' => $this->year,
            'cover' => $this->cover,
        ];
    }
}
