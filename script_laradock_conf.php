<?php


class Laradock
{
    const EXAMPLE = 'data/example.conf';

    private $fileName;
    private $dest;

    public function setFileName()
    {
        $this->fileName = readline('Digite o nome do arquivo .conf: ');
    }

    public function setDest()
    {
        $this->path = readline('Digite o caminho do seu laradock: ');
        $this->dest = $this->path . '/nginx/sites/' . $this->fileName . '.conf';
    }

    public function getFileName()
    {
        return $this->fileName;
    }

    private function copyExampleToNew()
    {
        copy(self::EXAMPLE, $this->dest);
    }

    public function replaceOriginalToFileName()
    {
        $this->setFileName();

        if ($this->fileName) {
            $this->setDest();
            $this->copyExampleToNew();
        }

        $data = file($this->dest);
        $finalData  = [];

        foreach ($data as $value) {
            $finalData[] = str_replace('example', $this->fileName, $value);
        }

        file_put_contents($this->dest, $finalData);
    }
}

class Hosts
{
    const HOST = '/etc/hosts';

    private $line;

    private function setLine($fileName)
    {
        $this->line = '127.0.0.1 ' . $fileName . '.dev';
    }

    public function editHostsWithFileName($fileName)
    {
        $this->setLine($fileName);
        file_put_contents(self::HOST, $this->line.PHP_EOL, FILE_APPEND);
    }
}


$laradock = new Laradock();
$laradock->replaceOriginalToFileName();

$hosts = new Hosts();
$hosts->editHostsWithFileName($laradock->getFileName());






