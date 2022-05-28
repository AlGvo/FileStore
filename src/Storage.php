<?php

namespace Algvo\FileStore;

use Exception;
use Iterator;

class Storage implements Iterator
{
    private $handler;
    private int $line = 1;

    public function __construct(string $filepath)
    {
        $this->setHandler($filepath);
    }

    public function __destruct()
    {
        fclose($this->handler);
    }

    private function setHandler(string $filepath)
    {
        if(! file_exists($filepath)) {
            throw new Exception("File \"{$filepath}\" don't exist");
        }
        $this->handler = fopen($filepath, 'r');
    }

    public function current()
    {
        return fgets($this->handler);
    }

    public function next()
    {
        $this->line++;
    }

    public function key()
    {
        return $this->line;
    }

    public function valid(): bool
    {
        return ! feof($this->handler);
    }

    public function rewind()
    {
        $this->line = 1;
        rewind($this->handler);
    }

}