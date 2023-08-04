<?php
namespace App\Services;

use App\Repositories\Interfaces\ImageInterface;

class ImageService
{
    private $imageRepository;

    public function  __construct(ImageInterface $imageInterface)
    {
        $this->imageRepository = $imageInterface;
    }

    public function insertMultipleRow(array $data)
    {
        if (count($data) == 0) {
            return [];
        }
        $attributes = array_keys($data[0]);
        $result = $this->imageRepository->getModel()->upsert($data, $attributes);
        return  $result;
    }

    public function getCloneImage()
    {
        $condition = [
            'status' => 0
        ];
        return $this->imageRepository->advancedGet([
            'condition' => $condition
        ]);
    }
}
