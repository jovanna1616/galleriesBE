<?php

use Faker\Generator as Faker;

$factory->define(App\Image::class, function (Faker $faker) {
    return [
    	'gallery_id' => 1,
        'link' => $faker->imageUrl($width = 640, $height = 480)
    ];
});
