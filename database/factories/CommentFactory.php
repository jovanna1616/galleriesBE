<?php

use Faker\Generator as Faker;

$factory->define(App\Comment::class, function (Faker $faker) {
    return [
    	'author_id' => '1',
    	'text' => $faker->paragraph($nbSentences = 3, $variableNbSentences = true)
    ];
});
