<?php

class UserTest extends TestCase
{

    private $uri = '/api/v1/admin/user';



    public function testListagemRetorno()
    {
        $this->json('GET',$this->uri,[],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    public function testListagemIncludeRoles(){
        $this->json('GET',$this->uri,[
                'include'=>'roles'
            ],$this->getMyHeader())
            ->seeJsonStructure([
                'roles'=>'data'
            ])->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    public function testListagemIncludePermission(){
        $this->json('GET',$this->uri,[
                'include'=>'permissions'
            ],$this->getMyHeader())
            ->seeJsonStructure([
                'permission'=>'data'
            ])
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    public function testListagemIncludePermissionRoles(){
        $this->json('GET',$this->uri,[
            'include'=>'permissions,roles'
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK)
            ->seeJsonStructure([
                'permission'=>'data',
                'roles'=>'data'
            ]);
    }

    /**
     * filtro default repository
     */
    public function testListagemFiltroDefaultRepository(){
        $this->json('GET',$this->uri,[
            'search'=>'adr'
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * verificando cadastro com falta do parameto nome
     */
    public function testStoreWithoutName(){
        $this->json('POST',$this->uri,[
            'name' => null,
            'email' => 'teste@teste.com',
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>1,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'chk_newsletter'=>false
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * verificando cadastro com falta do parameto email
     */
    public function testStoreWithoutEmail(){
        $this->json('POST',$this->uri,[
            'name' => 'teste',
            'email' => null,
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>1,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'chk_newsletter'=>false
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * verificando cadastro com falta do parameto email alternativo
     */
    public function testStoreWithoutEmailAlternativo(){
        $this->json('POST',$this->uri,[
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => null,
            'sexo'=>1,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'chk_newsletter'=>false
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * verificando cadastro com falta do parameto sexo
     */
    public function testStoreWithoutSexo(){
        $this->json('POST',$this->uri,[
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>null,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'chk_newsletter'=>false
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * verificando cadastro com falta do parameto password
     */
    public function testStoreWithoutPassword(){
        $this->json('POST',$this->uri,[
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>1,
            'password' => null,
            'password_confirmation' => '12345678',
            'chk_newsletter'=>false
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * verificando cadastro com falta do parameto password
     */
    public function testStorePasswordMenorQueOito(){
        $this->json('POST',$this->uri,[
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>1,
            'password' => '123456',
            'password_confirmation' => '123456',
            'chk_newsletter'=>false
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * verificando cadastro com falta do parameto password
     */
    public function testStorePasswordDiferente(){
        $this->json('POST',$this->uri,[
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>1,
            'password' => '123456789',
            'password_confirmation' => '12345678',
            'chk_newsletter'=>false
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * verificando cadastro com falta do parameto chk_newsletter
     */
    public function testStoreWithoutNewsletter(){
        $this->json('POST',$this->uri,[
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>1,
            'password' => '123456789',
            'password_confirmation' => '12345678',
            'chk_newsletter'=>null
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }
    /**
     * verificando cadastro com o parameto imagem inválido
     */
    public function testStoreImagemExtensaoInvalida(){
        $this->json('POST',$this->uri,[
            'name' => 'teste',
            'email' => 'teste@teste.com',
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>1,
            'imagem'=>'http://lorempixel.com/250/250.jpg',
            'password' => '123456789',
            'password_confirmation' => '12345678',
            'chk_newsletter'=>null
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * realizando um cadastro
     */
    public function testStore(){
        $this->json('POST',$this->uri,[
                'name' => 'teste',
                'email' => 'teste@teste.com',
                'email_confirmation' => 'teste@teste.com',
                'email_alternativo' => 'teste2@teste.com',
                'sexo'=>1,
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'chk_newsletter'=>false
            ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);

    }

    /**
     * verificando cadastro com duplicidade
     */
    public function testStoreDuplicarCadastro(){
        $this->json('POST',$this->uri,[
                'name' => 'teste',
                'email' => 'teste@teste.com',
                'email_confirmation' => 'teste@teste.com',
                'email_alternativo' => 'teste2@teste.com',
                'sexo'=>1,
                'password' => '12345678',
                'password_confirmation' => '12345678',
                'chk_newsletter'=>false
            ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * Editando cadastro
     */
    public function testUpdate(){
        $user = \App\Models\User::all()->last();
        $this->json('PUT',$this->uri.'/'.$user->id,[
            'name' => 'teste mais',
            'email' => 'teste@teste.com',
            'email_confirmation' => 'teste@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>1,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'chk_newsletter'=>false
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);

    }

    /**
     * Duplicidade de email
     */
    public function testUpdateDuplicateEmail(){
        $user = \App\Models\User::all()->last();
        $this->json('PUT',$this->uri.'/'.$user->id,[
            'name' => 'teste mais 3',
            'email' => 'user2@teste.com',
            'email_confirmation' => 'user2@teste.com',
            'email_alternativo' => 'teste2@teste.com',
            'sexo'=>1,
            'password' => '12345678',
            'password_confirmation' => '12345678',
            'chk_newsletter'=>false
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);

    }

    /**
     * Excluir Usuário
     */
    public function testDelete(){
        $user = \App\Models\User::all()->last();
        $this->json('DELETE',$this->uri.'/'.$user->id,[],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);

    }

    /**
     * Excluir um usuário inválido
     */
    public function testDeleteInvalid(){
        $this->json('DELETE',$this->uri.'/3213',[],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * Excluir um usuário inválido
     */
    public function testUpdatePassword(){
        $this->json('PATCH',$this->uri.'/password/change',[
            'old_password' => 'secret',
            'new_password' => '12345678',
            'new_password_confirmation' => '12345678'
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * Esqueceu a senha
     */
    public function testForgotPassword(){
        $this->json('POST',$this->uri.'/password/reset',[
            'email' => 'user1@teste.com',
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }

    /**
     * Nova senha sem o token
     */
    public function testNewPassword(){
        $this->json('POST',$this->uri.'/password/reset',[
            'email' => 'user1@teste.com',
            'new_password' => '12345678',
            'new_password_confirmation' => '12345678'
        ],$this->getMyHeader())
            ->seeStatusCode(\Symfony\Component\HttpFoundation\Response::HTTP_OK);
    }


}
