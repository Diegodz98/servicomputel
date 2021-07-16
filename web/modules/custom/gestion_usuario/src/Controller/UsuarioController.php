<?php

namespace Drupal\gestion_usuario\Controller;

use Drupal\user\UserInterface;
use Drupal\Core\Controller\ControllerBase;

class UsuarioController extends ControllerBase{

    public function listar()
    {
        $build = [];
        $query= $this->entityTypeManager()->getStorage('user')->getQuery();
        $query->sort('created', 'DESC');


        $result = $query->execute();

        /** @var UserInterface[] $users */
        $users = $this->entityTypeManager()->getStorage('user')->loadMultiple($result);

        $filas = [];

        foreach ($users as $user) {
            $filas[]=[
                'data' => [
                    $user->get('name')->getString(),
                    $user->get('mail')->getString(),
                    $user->get('field_telefono_de_contacto')->getString(),  
                    $user->get('uid')->getString(),

                ], 
            ];
        }
        $cabeceras=[
            'Usuario',
            'email',
            'operaciones'
        ];

        return array(
            '#theme' => 'lista_usuarios',
            '#titulo' => 'Listado de usuarios',
            '#descripcion' =>'Listado de usuarios Registrados',
            '#usuarios' => $filas,

        );

    }
}
