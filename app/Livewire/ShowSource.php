<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Http;

class ShowSource extends Component
{
    public $showId;

    public $streamServices = [];
    public $streamName = "";
    public $currentStreamService = "";
    public $season = [];
    public $episode = [];
    public $numberOfSeasons;


    public function mount(string $showId = "", $season, $numberOfSeasons)
    {
        $this->showId = $showId;
        $this->numberOfSeasons = $numberOfSeasons;
        $this->season = $season;
        $this->episode = $this->season["episodes"][0];
        $this->streamServices = [
            "VidJoy" => config("services.stream.url_vid_joy_series"),
            "VidSrc" => config("services.stream.url_vid_src_series")
        ];
        $this->streamName = "VidJoy";
        $this->currentStreamService = $this->streamServices[$this->streamName] . $this->getStreamingExtenstion($showId, $this->season['season_number'], $this->episode['episode_number']);
    }

    public function changeStreamingService(string $name)
    {
        if (key_exists($name, $this->streamServices)) {
            $this->streamName = $name;
            $this->currentStreamService = $this->streamServices[$name] . $this->getStreamingExtenstion($this->showId, $this->season['season_number'], $this->episode['episode_number']);
        }
    }

    private function getStreamingExtenstion(string $showId, string $seasonNumber, string $episodeNumber)
    {
        return "{$showId}/{$seasonNumber}/{$episodeNumber}";
    }

    public function changeSeason($seasonNumber)
    {
        if ($seasonNumber <= $this->numberOfSeasons) {
            $this->season = Http::withToken(config('services.tmdb.token'))
                ->get(config('services.tmdb.url') . "/tv/$this->showId/season/$seasonNumber")->json();
            $this->episode = $this->season["episodes"][0];

            $this->currentStreamService = $this->streamServices[$this->streamName] . $this->getStreamingExtenstion($this->showId, $this->season['season_number'], $this->episode['episode_number']);
        }
    }

    public function changeEpisode($episodeNumber)
    {
        $episodeNumber -= 1;
        if ($episodeNumber <= count($this->season["episodes"]) - 1) {
            $this->episode = $this->season["episodes"][$episodeNumber];
            $this->currentStreamService = $this->streamServices[$this->streamName] . $this->getStreamingExtenstion($this->showId, $this->season['season_number'], $this->episode['episode_number']);
        }
    }

    public function render()
    {
        return view('livewire.show-source');
    }
}
