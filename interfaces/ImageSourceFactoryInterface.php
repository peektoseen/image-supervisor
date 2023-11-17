<?php
namespace app\interfaces;

interface ImageSourceFactoryInterface
{
    public function createImageSource(string $url = ''): ImageSourceInterface;
}
