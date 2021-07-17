<?php

namespace Drupal\gestion_usuario\Controller;

use Drupal\user\UserInterface;
use Drupal\Core\Controller\ControllerBase;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

use Drupal\Core\Link;
use Drupal\Core\Url;

class UsuarioController extends ControllerBase{

    private $session;

    public function __construct( SessionInterface $session){
        $this->session = $session;

    }
    public static function create(ContainerInterface $container){
        return new static(
        $container->get('session')
        );
    }
    public function listar()
    {
        
        $build = [];
        $build[] = $this->formBuilder()->getForm('Drupal\gestion_usuario\Form\FiltroFormUsuario');
        $filtros = $this->session->get('gestion_usuario_filtro', []);

        $query= $this->entityTypeManager()->getStorage('user')->getQuery();
        $query->sort('created', 'ASEC');

        if(isset($filtros['nombre'])){
            if(!empty($filtros['nombre'])){
                $query->condition('name', $filtros['nombre'], 'CONTAINS');

            }
        }
        $query->pager(10);

        $result = $query->execute();

        /** @var UserInterface[] $users */
        $users = $this->entityTypeManager()->getStorage('user')->loadMultiple($result);

        $filas = [];

        
        foreach ($users as $user) {
            $telefono = $user->get('field_telefono_de_contacto')->getString();
            $whatsapp = Url::fromUri('https://api.whatsapp.com/send?phone=+57'.$telefono);
            $llamar = Url::fromUri('tel:+'.$telefono);



            $filas[]=[
                'data' => [
                    $user->get('name')->getString(),
                    $user->get('mail')->getString(),
                    $telefono,
                    //Creamos el link con el obketo Url a un sitio externo
                    $link_whatsapp = Link::fromTextAndUrl('Whatsapp ', $whatsapp),
                    $link_llamar = Link::fromTextAndUrl('Llamar ', $llamar)

                ], 
            ];
        }
        $cabeceras=[
            'Usuario',
            'email',
            'tel',
            'Accion 1',
            'Accion 2'

        ];
        $tabla= [
            '#type' => 'table',
            '#header' => $cabeceras,
            '#rows' => $filas
          ];
        $build[] = $tabla;
        $build[] =[
            '#type' => 'pager'
          ];
        return  $build;
        
    }
}
