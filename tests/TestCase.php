<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';
    private $token;
    private $refresh_token;
    private $header;
    public function setUp()
    {
        parent::setUp();
        $user = \App\Models\User::all()->first();
        $client = \Laravel\Passport\Client::where('user_id', $user->id)->first();
        $response = json_decode($this->json('POST','/api/v1/oauth/token',[
            'grant_type'=>'password',
            'username'=>$user->email,
            'password'=>'secret',
            'client_id'=>$client->id,
            'client_secret'=>$client->secret,
            'scope'=>''
        ])->response->getContent(),true);
        $this->token = $response['access_token'];
        $this->refresh_token = $response['refresh_token'];
        $this->header = [
            'Authorization'=>$this->getAuthorization()
        ];
    }
    protected function getMyHeader(){
        return $this->header;
    }

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

        return $app;
    }

    /**
     * @return string
     */
    protected function getAuthorization(){
        return 'Bearer '.$this->getToken();
    }

    protected function getToken(){
        return $this->token;
    }
}
