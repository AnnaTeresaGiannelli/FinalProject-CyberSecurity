<?php

namespace App\Livewire;

use GuzzleHttp\Client;
use Livewire\Component;
use App\Services\HttpService;

class LatestNews extends Component
{
    public $selectedApi;
    public $news;
    protected $httpService;

    public function __construct()
    {
        $this->httpService = app(HttpService::class);
    }

    public function fetchNews()
    {
        $allowedUrls = [
            "https://newsapi.org/v2/top-headlines?country=it ", 
            "https://newsapi.org/v2/top-headlines?country=gb", 
            "https://newsapi.org/v2/top-headlines?country=us"
        ];

        if (!in_array($this->selectedApi, $allowedUrls)) {
            return redirect()->route('articles.create')->with('error', 'Invalid URL');
        };

        $this->news = json_decode($this->httpService->getRequest($this->selectedApi), true);

    }
    public function render()
    {
        return view('livewire.latest-news');
    }
}