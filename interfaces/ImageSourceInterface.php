<?php


namespace app\interfaces;
interface ImageSourceInterface
{
    public function getImageUrl(): string;

    public function getSourceImageId(): int;
}