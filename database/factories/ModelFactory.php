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

$factory->define(\App\Models\RotaAcesso::class, function (Faker\Generator $faker){
    return [
        'parent_id' => null,
        'text' => $faker->word,
        'rota' => '',
        'icon' => '',
        'disabled' => false,
    ];
});

$factory->define(\App\Models\Configuracao::class, function (Faker\Generator $faker) {
    return [
        'titulo' => $faker->name,
        'email' => $faker->email,
        'url_site' => $faker->url,
        'telefone' => $faker->phoneNumber,
        'horario_atendimento' => $faker->date('H:i'),
        'endereco' => $faker->address,
        'rodape' => $faker->word,
        'facebook' => null,
        'twitter' => null,
        'google_plus' => null,
        'youtube' => null,
        'instagram' => null,
        'palavra_chave' => null,
        'descricao_site' => null,
        'og_tipo_app' => null,
        'og_titulo_site' => null,
        'od_url_site' => null,
        'od_autor_site' => null,
        'facebook_id' => null,
        'token' => null,
        'analytcs_code' => null,
    ];
});