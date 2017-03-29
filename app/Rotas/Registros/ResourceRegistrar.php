<?php

namespace App\Rotas\Registros;

use Illuminate\Routing\ResourceRegistrar as OriginalRegistrar;

class ResourceRegistrar extends OriginalRegistrar
{
    // add data to the array
    /**
     * The default actions for a resourceful controller.
     *
     * @var array
     */
    protected $resourceDefaults = ['index', 'create', 'excluir', 'store', 'trasheds', 'show', 'edit', 'update', 'destroy'];


    /**
     * Add the data method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceExcluir($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/destroy-all';

        $action = $this->getResourceAction($name, $controller, 'excluir', $options);

        return $this->router->post($uri, $action);
    }

    /**
     * Add the data method for a resourceful route.
     *
     * @param  string  $name
     * @param  string  $base
     * @param  string  $controller
     * @param  array   $options
     * @return \Illuminate\Routing\Route
     */
    protected function addResourceTrasheds($name, $base, $controller, $options)
    {
        $uri = $this->getResourceUri($name).'/lixeira';

        $action = $this->getResourceAction($name, $controller, 'trasheds', $options);

        return $this->router->get($uri, $action);
    }
}