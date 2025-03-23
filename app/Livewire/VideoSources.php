<?php

namespace App\Livewire;

use Livewire\Component;

class VideoSources extends Component
{

    public $movieId;

    public $streamServices = [];
    public $currentStreamService = "";

    public function mount(string $movieId = "")
    {
        $this->movieId = $movieId;
        $this->streamServices = [
            "VidJoy" => config("services.stream.url_vid_joy"),
            "VidSrc" => config("services.stream.url_vid_src")
        ];
        $this->currentStreamService = $this->streamServices["VidJoy"];
    }

    public function changeStreamingService(string $name)
    {
        if (key_exists($name, $this->streamServices)) {
            $this->currentStreamService = $this->streamServices[$name];
        }
    }

    public function render()
    {
        return view('livewire.video-sources');
    }
}
