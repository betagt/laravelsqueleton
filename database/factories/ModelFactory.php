<?php
$factory->define(\App\Models\User::class, function (Faker\Generator $faker) {
    static $password;

    return [
        'name' => $faker->name,
        'email' => $faker->unique()->safeEmail,
        'email_alternativo' => $faker->unique()->safeEmail,
        'sexo'=>1,
        'imagem'=>$faker->imageUrl(250, 250),
        'password' => 'secret',
        'status' => 'ativo',
        'remember_token' => str_random(10),
    ];
});
$factory->define(\App\Models\Role::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'slug' => strtolower($faker->name),
        'description' => $faker->word,
    ];
});
$factory->define(\App\Models\Permission::class, function (Faker\Generator $faker) {
    return [
        'name' => $faker->name,
        'slug' => [          // pass an array of permissions.
            'store'      => true,
            'view'       => true,
            'show'       => true,
            'update'     => true,
            'delete'     => true,
        ],
        'description' => $faker->word,
    ];
});

$factory->define(\Portal\Models\RotaAcesso::class, function (Faker\Generator $faker){
    return [
        'parent_id' => null,
        'text' => $faker->word,
        'rota' => '',
        'icon' => '',
        'disabled' => false,
    ];
});