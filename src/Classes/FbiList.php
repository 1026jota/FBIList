<?php
namespace Jota\FbiList\Classes;
use Goutte\Client;

class FbiList{

    /**
     * url where is find the list
     * @var string
     */
    private string $url;

    /**
     * Name to search
     * @var string $name
     */
    private string $name;

    /**
     * Result to search
     * @var string $name
     */
    private $result;

    /**
     * init result default
     * @return void
     */
    private function initResult() : void
    {
        $this->result['is_registered'] = false;
        $this->result['total_results'] = 0;
        $this->result['result'] = [];
    }

    /**
     * search by specific names into the fbi list
     * @param string name
     * @return void
     */
    public function searchByName(string $name) : void
    {
        $this->initResult();
        $this->name = strtolower($name);
        $this->client = new Client();
        $peticiones = $this->getTotal() / 40;
        for ($i = 1; $i <= (int)$peticiones; $i++) {
            $this->url = config('fbilist.url') . $i;
            $this->getByName();
        }
    }

    /**
     * search all names into the fbi list
     * @return void
     */
    public function searchAll() : void
    {
        $this->initResult();
        $this->client = new Client();
        $peticiones = $this->getTotal() / 40;
        for ($i = 1; $i <= (int)$peticiones; $i++) {
            $this->url = config('fbilist.url') . $i;
            $this->getAll();
        }
    }

    /**
     * get the total numbers of register into de the fbi list
     * @return int
     */
    private function getTotal(): int
    {
        $crawler = $this->client->request('GET', config('fbilist.url'));
        $html = $crawler->filter('[class="right"]');
        $total = explode(" ", $html->text());
        return (int)$total[1];
    }

    /**
     * function use for get all registers
     * @return void
     */
    private function getAll() : void
    {
        $crawler = $this->client->request('GET', $this->url);
        $crawler->filter('li')->each( function($data){
            $nombre = $data->filter('p')->first()->text();
            $info = [
                'name' => $nombre,
                'link' => trim($data->filter('a')->attr('href'))
            ];
            $this->result['total_results'] += 1;
            $this->result['is_registered'] = true;
            array_push($this->result['result'],$info);
        });
    }

    /**
     * function use for get register by specific name
     * @return void
     */
    private function getByName() : void
    {
        $crawler = $this->client->request('GET', $this->url);
        $crawler->filter('li')->each(function ($data) {
            $nombre = $data->filter('p')->first()->text();
            if (strcmp($this->name, strtolower($nombre)) == 0) {
                $info = [
                    'name' => $nombre,
                    'link' => trim($data->filter('a')->attr('href'))
                ];
                $this->result['total_results'] += 1;
                $this->result['is_registered'] = true;
                $this->result['result'] = $info;
            }
        });
    }

    /**
     * Return a search result in json form
     * @return string
     */
    public function getResult(): string
    {
        return json_encode($this->result);
    }
}