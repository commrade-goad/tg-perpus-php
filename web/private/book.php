<?php

class Book implements JsonSerializable{
    public int $id;
    public string $title;
    public string $author;
    public string $desc;
    public array $tags;
    public string $year;
    public string $cover;
    public string $prodi;
    public string $pos;

    public function __construct(int $id, string $title, string $author, string $desc, array $tags, string $year, string $cover, string $prodi, string $pos) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->desc = $desc;
        $this->tags = $tags;
        $this->year = $year;
        $this->cover = $cover;
        $this->prodi = $prodi;
        $this->pos = $pos;
    }

    public function jsonSerialize(): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'author' => $this->author,
            'desc' => $this->desc,
            'tags' => $this->tags,
            'year' => $this->year,
            'cover' => $this->cover,
            'prodi' => $this->prodi,
            'pos' => $this->pos,
        ];
    }
}
