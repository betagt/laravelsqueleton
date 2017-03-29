<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Contracts\Auth\PasswordBroker;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Criteria\OrderCriteria;
use App\Criteria\UserCriteria;
use App\Http\Controllers\BaseController;
use App\Http\Requests\UserChangePasswordRequest;
use App\Http\Requests\UserRequest;
use App\Http\Requests\UserResetPasswordRequest;
use App\Http\Requests\UserResetSendEmailRequest;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Services\ImageUploadService;
use Prettus\Repository\Exceptions\RepositoryException;
use Validator;

/**
 * @resource API Usuário - Backend
 *
 * Essa API é responsável pelo gerenciamento de Usuários no App qImob.
 * Os próximos tópicos apresenta os endpoints de Consulta, Cadastro, Edição e Deleção.
 */
class UserController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    private $passwordBroker;
    /**
     * @var ImageUploadService
     */
    private $imageUploadService;

    /**
     * UserController constructor.
     * @param UserRepository $userRepository
     * @param PasswordBroker $passwordBroker
     */
    public function __construct(
        UserRepository $userRepository,
        PasswordBroker $passwordBroker,
        ImageUploadService $imageUploadService)
    {
        $this->userRepository = $userRepository;
        $this->passwordBroker = $passwordBroker;
        $this->setPathFile(public_path('arquivos/img/user'));
        $this->imageUploadService = $imageUploadService;
        parent::__construct($userRepository, UserCriteria::class);
    }

    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new UserRequest())->rules();
        return $this->validator;
    }

    /**
     * Cadastrar
     *
     * Endpoint para cadastrar
     *
     * @param Request $request
     * @return retorna um registro criado
     */
    public function store(Request $request){
        $data = $request->all();
        \Validator::make($data, $this->getValidator())->validate();
        try{
            $data['status'] = User::INATIVO;
            $data = $this->defaultRepository->skipPresenter(true)->create($data);
            $data->assignRole('anunciante');
            return $this->defaultRepository->skipPresenter(false)->find($data->id);
        }catch (ModelNotFoundException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (RepositoryException $e){
            return self::responseError(self::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return self::responseError(self::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
    }

    /**
     * Alterar Imagem Usuário logado
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function changeImage(Request $request){
        $data = $request->all();
        Validator::make($data, [
            'imagem' => [
                'required',
                'image',
                'mimes:jpg,jpeg,bmp,png'
            ]
        ])->validate();
        try{
            $this->imageUploadService->upload('imagem',$this->getPathFile(),$data);
            return $this->userRepository->update($data,$request->user()->id);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }

    /**
     * Alterar Imagem Administrativo
     *
     * @param Request $request
     * @param $id
     * @return \Illuminate\Http\JsonResponse|mixed
     */
    public function changeImageAdmin(Request $request,$id){
        $data = $request->all();
        Validator::make($data, [
            'imagem' => [
                'required',
                'image',
                'mimes:jpg,jpeg,bmp,png'
            ]
        ])->validate();
        try{
            $this->imageUploadService->upload('imagem',$this->getPathFile(),$data);
            return $this->userRepository->update($data,$id);
        }
        catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
        }
    }
    /**
     * Consultar Perfil Usuário
     *
     * Endpoint para consultar perfil do usuário passando o ID como parametro
     *
     * @param $id
     * @return mixed
     */
    public function myProfile(Request $request){
        $id  = $request->user()->id;
        try{
            return $this->userRepository->find($id);
        }catch (ModelNotFoundException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (RepositoryException $e){
            return parent::responseError(parent::HTTP_CODE_NOT_FOUND, trans('errors.registre_not_found', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
        catch (\Exception $e){
            return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, trans('errors.undefined', ['status_code'=>$e->getCode(),'line'=>$e->getLine()]));
        }
    }
    /**
     * Solicitar Nova Senha
     *
     * Enviar email com link para usuário recuperar senha
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function solicitarNovaSenha(UserResetSendEmailRequest $request)
    {
        $response = $this->passwordBroker->sendResetLink($request->only('email'), function($m)
        {
            $m->subject($this->getEmailSubject());
        });

        switch ($response)
        {
            case PasswordBroker::RESET_LINK_SENT:
                return parent::responseSuccess(parent::HTTP_CODE_OK, "O link de recuperação de senha foi enviado para seu endereço de e-mail");
            case PasswordBroker::INVALID_USER:
                return parent::responseError(parent::HTTP_CODE_NOT_FOUND, "Não é possível encontrar um usuário com esse endereço de e-mail");
        }
    }

    /**
     * Criar Nova Senha
     *
     * Enviar dados para criar a nova senha solicitada pelo usuário
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function criarNovaSenha(UserResetPasswordRequest $request)
    {
        $credentials = $request->only(
            'email', 'password', 'password_confirmation', 'token'
        );

        $response = $this->passwordBroker->reset($credentials, function($user, $password)
        {
            $user->forceFill([
                'password' => $password,
                'remember_token' => Str::random(60),
            ])->save();
        });

        switch ($response)
        {
            case PasswordBroker::PASSWORD_RESET:
                return parent::responseSuccess(parent::HTTP_CODE_OK, "Senha alterada com sucesso.");
            case PasswordBroker::INVALID_TOKEN:
                return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, "O Token de reinicialização inválida ou já expirou.");
            case PasswordBroker::INVALID_USER:
                return parent::responseError(parent::HTTP_CODE_NOT_FOUND, "Não é possível encontrar um usuário com esse endereço de e-mail");
            default:
                return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, "Erro inesperado.");
        }
    }

    /**
     * Alterar Senha
     *
     * Enviar dados para alterar a senha
     *
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function alterarSenha(UserChangePasswordRequest $request)
    {
        $user = $request->user();
        if(password_verify($request->get('old_password'), $user->password)) {
            $this->userRepository->update(['password' => $request->get('new_password')], $user->id);
            return parent::responseSuccess(parent::HTTP_CODE_OK, "Senha alterada com sucesso.");
        }
        return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, "A senha atual não confere.");
    }

    /**
     * Deletar Usuário
     */
    public function destroy($id){
         try{
             $this->userRepository->delete($id);
             return parent::responseSuccess(parent::HTTP_CODE_OK, parent::MSG_REGISTRO_EXCLUIDO);
         }
         catch (ModelNotFoundException $e){
             return parent::responseError(parent::HTTP_CODE_NOT_FOUND, $e->getMessage());
         }
         catch (\Exception $e){
             return parent::responseError(parent::HTTP_CODE_BAD_REQUEST, $e->getMessage());
         }
    }



}
