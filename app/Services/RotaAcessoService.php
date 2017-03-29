<?php


namespace App\Services;


use App\Repositories\RotaAcessoRepository;
use App\Repositories\EnderecoRepository;

class RotaAcessoService
{
    /**
     * @var RotaAcessoRepository
     */
    private $rotaAcessoRepository;

    public function __construct(RotaAcessoRepository $rotaAcessoRepository)
    {
        $this->rotaAcessoRepository = $rotaAcessoRepository;
    }

    public function createOrUpdate($data, $id=null){
       \DB::beginTransaction();
       try{
           $rotaAcesso = $this->rotaAcessoRepository->skipPresenter(true)->updateOrCreate(['id'=>$id],$data);
           if(isset($data['roles']))
               $rotaAcesso->roles()->sync($data['roles']);
           \DB::commit();
           return $this->rotaAcessoRepository->parserResult($rotaAcesso);
       }catch (\Exception $e){
           \DB::rollback();
       }
    }
}