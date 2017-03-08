<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Criteria\OrderCriteria;
use Prettus\Repository\Exceptions\RepositoryException;

trait DefaultAcions
{
    /**
     * Consultar
     *
     *
     * Endpoint para consultar todos os Anuncio cadastrados
     *
     * Nessa consulta pode ser aplicado os seguintes filtros:
     *
     *  - Consultar Normal:
     *   <br> - Não passar parametros
     *
     *  - Consultar por Cidade:
     *   <br> - ?consulta={"filtro": {"estados.uf": "TO", "cidades.titulo" : "Palmas"}}
     */
    public function index(Request $request){

        try{
            return $this->defaultRepository
                ->pushCriteria(new $this->defaultCriteria($request))
                ->pushCriteria(new OrderCriteria($request))
                ->paginate(self::$_PAGINATION_COUNT);
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
     * Consulta  por ID
     *
     * Endpoint para consultar passando o ID como parametro
     *
     * @param $id
     * @return retorna um registro
     */
    public function show($id){
        try{
            return $this->defaultRepository->find($id);
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
            return $this->defaultRepository->create($data);
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
    public function update(Request $request, $id){
        $data = $request->all();
        \Validator::make($data, $this->getValidator($id))->validate();
        try{
            return $this->defaultRepository->update($request->all(),$id);
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
     * Deletar
     *
     * Endpoint para deletar passando o ID
     */
    public function destroy($id){
        try{
            $this->defaultRepository->delete($id);
            return self::responseSuccess(self::HTTP_CODE_OK, self::MSG_REGISTRO_EXCLUIDO);
        }
        catch (ModelNotFoundException $e){
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