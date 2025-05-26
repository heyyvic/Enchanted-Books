<?php

namespace shadow\books;

class Books
{
    public string $type;
    public string $lore;
    public string $tag;

    public function __construct(string $type, string $lore = '', string $tag = '')
    {
        $this->lore = $lore;
        $this->tag = $tag;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @return string
     */
    public function getLore(): string
    {
        return $this->lore;
    }

    /**
     * @return string
     */
    public function getTag(): string
    {
        return $this->tag;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }

    /**
     * @param string $tag
     */
    public function setTag(string $tag): void
    {
        $this->tag = $tag;
    }

    /**
     * @param string $lore
     */
    public function setLore(string $lore): void
    {
        $this->lore = $lore;
    }

    public function Data()
    {
        return [
            'type' => $this->type,
            'lore' => $this->lore,
            'tag' => $this->tag,
        ];
    }
}