<?php

class PermissionTest extends TestCase
{
    private $uri = '/api/v1/admin/permissao/';
    private $param_fields;

    public function setUp()
    {
        parent::setUp();
        $this->param_fields =  [
            'name'           => 'permissao_name',
            'slug'           => [
                'view'=>true
            ],
            'description'    => 'permissao_description',
        ];
    }

    public function testRetornoListagem()
    {
        $response = $this->json('GET',$this->uri,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;

        $this->assertJson($response->getContent());


    }

    public function testRetornoListagemFiltro()
    {
        $param_filter = [
            'search' => 'iure',
            'searchFields' => 'name:like',
        ];

        $response = $this->json('GET',$this->uri, $param_filter, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());

    }

    public function testRetornoRegistro()
    {
        $response = $this->json('GET',$this->uri.'100',[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND)->response;
        $this->assertJson($response->getContent());

        $response = $this->json('GET',$this->uri.'1',[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());
    }

    public function testCadastrarRegistro()
    {

        $response = $this->json('POST',$this->uri, $this->param_fields, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
        $this->assertJson($response->getContent());

        foreach ($this->param_fields as $key => $val){
            $this->param_fields[$key] = '';
            $this->json('POST',$this->uri, $this->param_fields, $this->getMyHeader())
                ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;
        }

        $response = $this->json('POST',$this->uri, $this->param_fields, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;

        $this->assertJson($response->getContent());


    }

    public function testAlterarRegistro()
    {
        $registro = \App\Models\Permission::all()->last();
        $this->json('PUT',$this->uri.$registro->id, $this->param_fields, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;

        foreach ($this->param_fields as $key => $val){
            $this->param_fields[$key] = '';
            $this->json('PUT',$this->uri.$registro->id, $this->param_fields, $this->getMyHeader())
                ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_UNPROCESSABLE_ENTITY)->response;
        }

        $this->json('PUT',$this->uri.$registro->id+100, $this->param_fields, $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND)->response;



    }

    public function testDeletarRegistro()
    {
        $registro = \App\Models\Permission::all()->last();
        $this->json('DELETE',$this->uri.$registro->id+100,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_NOT_FOUND)->response;

        $this->json('DELETE',$this->uri.$registro->id,[], $this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)->response;
    }
}
