<?php

namespace Aigletter\TestTask;

class Renderer
{
    protected $banner;

    public function __construct(string $banner)
    {
        $this->banner = $banner;
    }

    public function render(): void
    {
        $mime = mime_content_type($this->banner);

        header('Content-Type: ' . $mime);

        echo file_get_contents($this->banner);

        exit();
    }
}