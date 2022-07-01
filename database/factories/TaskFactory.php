<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Task;
use Faker\Generator as Faker;

$factory->define(Task::class, function (Faker $faker) {
    return [
         'title' => $faker->word
        ,'status' => $faker->numberBetween(1,4)
        ,'description' =>  $faker->realText(200)
        ,'created_at' => $faker->dateTimeThisMonth
        ,'updated_at' => $faker->dateTimeThisMonth
    ];
});

$factory->state(Task::class, 'Ready', function (Faker $faker) {
    return ['status' => 1, 'title' => 'Ready'];
});

$factory->state(Task::class, 'Doing', function (Faker $faker) {
    return ['status' => 2,'title' => 'Doing'];
});

$factory->state(Task::class, 'Done', function (Faker $faker) {
    return ['status' => 3,'title' => 'Done'];
});

$factory->state(Task::class, 'notReady', function (Faker $faker) {
    return ['status' => 4,'title' => 'notReady'];
});