<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
{
    public function toArray($request)
    {
        return [
            'data' => $this->collection->map(function($data) {
                return [
                    'id' => (integer) $data->id,
                    'name' => $data->getTranslation('name'),
                    'slug' => $data->slug,
                    'thumbnail_image' => api_asset($data->thumbnail_img),
                    'photos' => $this->convertPhotos($data->photos),
                    'base_price' => (double) product_base_price($data),
                    'base_discounted_price' => (double) product_discounted_base_price($data),
                    'stock' => $data->stock,
                    'unit' => $data->getTranslation('unit'),
                    'min_qty' => $data->min_qty,
                    'max_qty' => $data->max_qty,
                    'rating' => (double) $data->rating,
                    'earn_point' => (float) $data->earn_point,
                    'is_variant' => (int) $data->is_variant,
                    'variations' => $data->variations,
                    'is_digital' => $data->digital == 1 ? true : false,
                ];
            })
        ];
    }

    public function with($request)
    {
        return [
            'success' => true,
            'status' => 200
        ];
    }

//    protected function convertPhotos(){
//        $result = array();
//        foreach (explode(',', $this->photos) as $item) {
//            array_push($result, api_asset($item));
//        }
//        return $result;
//    }


    protected function convertPhotos($photos) // Accept the photos as a parameter
    {
        $result = [];
        // Check if $photos is a string and split if necessary
        if (is_string($photos)) {
            foreach (explode(',', $photos) as $item) {
                array_push($result, api_asset(trim($item))); // Trim spaces to avoid issues
            }
        }
        return $result;
    }


}
