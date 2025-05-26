<?php

namespace shadow\books;

use MongoDB\Driver\Exception\InvalidArgumentException;
use pocketmine\utils\Config;
use shadow\Loader;

class BookManager
{
    public static ?BookManager $instance;
    public Config $config;
    private array $books = [];

    public function __construct()
    {
        $this->config = new Config(Loader::getInstance()->getDataFolder() . 'books.json', Config::JSON, [
            'books' => [
                'speed' => [
                    'lore' => 'Speed',
                    'tag' => 'speed'
                ]
            ]
        ]);
        self::$instance = $this;
    }

    public function load()
    {
        $data = $this->config->get('books', []);
        foreach ($data as $type => $bookData) {
            $this->books[$type] = new Books($type, $bookData['lore'], $bookData['tag']);
            $this->Save();
        }
    }

    public static function getInstance(): ?BookManager
    {
        return self::$instance ?? null;
    }

    public function createBooks(string $type)
    {
        $this->setInfoType($type);;
    }

    public function removeBooks(string $type)
    {
        if (isset($this->books[$type])) {
            unset($this->books[$type]);
            $this->Save();
        } else {
            throw new InvalidArgumentException("Book type '$type' does not exist.");
        }
    }

    public function getBooks(string $type): ?Books
    {
        return $this->books[$type] ?? null;
    }

    public function setInfoType(string $type)
    {
        if (isset($this->books[$type])) {
            return; // Book already exists
        }

        switch (strtolower($type)) {
            case 'speed':
                $this->books[$type] = new Books($type, 'Speed', 'speed');
                $this->Save();
                break;
            case 'fire':
                $this->books[$type] = new Books($type, 'FireResistance', 'fire');
                $this->Save();
                break;
            case 'inv':
                $this->books[$type] = new Books($type, 'Invisibility', 'inv');
                $this->Save();
                break;
            case 'hell':
                $this->books[$type] = new Books($type, 'HellForged', 'hell');
                $this->Save();
                break;
            case 'night':
                $this->books[$type] = new Books($type, 'NightVision', 'night');
                $this->Save();
                break;
            case 'zeus':
                $this->books[$type] = new Books($type, 'Zeus', 'Zeus');
                $this->Save();
                break;
            case 'fury':
                $this->books[$type] = new Books($type, 'Fury', 'fury');
                $this->Save();
                break;
            default:
                throw new \InvalidArgumentException("shadow book type: $type");
        }
    }

    public function getBooksList()
    {
        foreach ($this->books as $book) {
            return "\n" . $book->Data()['lore'] ?? '';
        }
        return [];
    }

    public function getAllBooks()
    {
        return $this->books;
    }

    public function Save()
    {
        $data = [];
        foreach ($this->books as $book) {
            $data[$book->getType()] = $book->Data();
        }
        $this->config->set('books', $data);
        $this->config->save();
    }
}