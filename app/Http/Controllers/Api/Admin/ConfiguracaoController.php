<?php

namespace App\Http\Controllers\Api\Admin;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Criteria\ConfiguracaoCriteria;
use App\Http\Controllers\BaseController;
use App\Http\Requests\ConfiguracaoRequest;
use App\Repositories\ConfiguracaoRepository;
use Prettus\Repository\Exceptions\RepositoryException;

/**
 * @resource API Configuração - Backend
 *
 * Essa API é responsável pelo gerenciamento da Configuração no App qImob.
 * Os próximos tópicos apresentara os endpoints de Consulta, Cadastro, Edição e Deleção.
 *
 * Class ConfiguracaoController
 * @package App\Http\Controllers\Api
 */

class ConfiguracaoController extends BaseController
{
    private $configuracaoRepository;
    /**
     * ConfiguracaoController constructor.
     * @param ConfiguracaoRepository $configuracaoRepository
     */
    public function __construct(ConfiguracaoRepository $configuracaoRepository)
    {
           $this->configuracaoRepository = $configuracaoRepository;
           parent::__construct($configuracaoRepository,ConfiguracaoCriteria::class);
    }
    /**
     * @return array
     */
    public function getValidator($id = null)
    {
        $this->validator = (new ConfiguracaoRequest())->rules();
        return $this->validator;
    }

    /**
     * Consulta  por ID
     *
     * Endpoint para consultar passando o ID como parametro
     *
     * @param $id
     * @return retorna um registro
     */
    public function view(){
        try{
            return $this->configuracaoRepository->first();
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
     * Alterar
     *
     * Endpoint para alterar
     *
     * @param Request $request
     * @param $id
     * @return retorna registro alterado
     */
    public function editar(Request $request){
        $data = $request->all();
        $config = $this->configuracaoRepository->skipPresenter(true)->first();
        \Validator::make($data, $this->getValidator($config->id))->validate();
        try{
            return $this->configuracaoRepository->update($request->all(),$config->id);
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
}
