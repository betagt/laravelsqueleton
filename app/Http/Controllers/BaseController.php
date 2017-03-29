<?php
/**
 * Created by PhpStorm.
 * User: dsoft
 * Date: 09/01/2017
 * Time: 10:05
 */

namespace App\Http\Controllers;


use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Criteria\OrderCriteria;
use App\Interfaces\ICustomController;
use App\Traits\DefaultAcions;
use Prettus\Repository\Exceptions\RepositoryException;

abstract class BaseController extends Controller implements ICustomController
{
    use DefaultAcions;

    protected static $_PAGINATION_COUNT = 25;

    protected $defaultRepository;
    /**
     * @var
     */
    private $defaultCriteria;

    protected $validator = [];
    /**
     * @var string
     */
    private $defaultOrder;

    public function __construct($defaultRepository, $defaultCriteria, $defaultOrder = OrderCriteria::class)
    {
        $this->defaultRepository = $defaultRepository;
        $this->defaultCriteria = $defaultCriteria;
        $this->defaultOrder = $defaultOrder;
    }

    const MSG_REGISTRO_EXCLUIDO = 'Registro excluido com sucesso.';
    const MSG_REGISTRO_ALTERADO = 'Registro alterado com sucesso.';

    const HTTP_CODE_BAD_REQUEST = [
        'status'=>301,
        'code'=>'HTTP_CODE_BAD_REQUEST'
    ];
    const HTTP_CODE_NOT_FOUND = [
        'status'=>404,
        'code'=>'HTTP_CODE_NOT_FOUND'
    ];
    const HTTP_CODE_OK = [
        'status'=>200,
        'code'=>'HTTP_CODE_OK'
    ];
    const HTTP_CODE_CREATED = [
        'status'=>201,
        'code'=>'HTTP_CODE_CREATED'
    ];

    private $pathFile = null;

    /**
     * @return mixed
     */
    public function getDefaultCriteria()
    {
        return $this->defaultCriteria;
    }

    /**
     * @param mixed $defaultCriteria
     */
    public function setDefaultCriteria($defaultCriteria)
    {
        $this->defaultCriteria = $defaultCriteria;
    }

    /**
     * @return null
     */
    protected function getPathFile()
    {
        return $this->pathFile;
    }

    /**
     * @param null $pathFile
     */
    protected function setPathFile($pathFile)
    {
        $this->pathFile = $pathFile;
    }

    protected function responseSuccess (array $status_code,string $message = null){

       return  response()->json([
            "success"=> [
                "status_code"=>  $status_code['status'],
                "code"=> $status_code['code'],
                "description"=> $message
            ]
       ], $status_code['status']);
    }

    protected function responseError (array $status_code, string $message = null){

       return response()->json([
           "error"=> [
               "status_code"=>  $status_code['status'],
               "code"=> $status_code['code'],
               "description"=> $message
           ]
       ], $status_code['status']);

    }


}