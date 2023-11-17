<?php

/** @noinspection SpellCheckingInspection */
namespace app\components\picsum;
use app\interfaces\ImageSourceFactoryInterface;
use app\interfaces\ImageSourceInterface;

/**
 * Factory for picsium source.
 */
class PicsumImageSourceFactory implements ImageSourceFactoryInterface
{
    public function createImageSource(string $url = ''): ImageSourceInterface
    {
        return new PicsumImageSource($url);
    }
}