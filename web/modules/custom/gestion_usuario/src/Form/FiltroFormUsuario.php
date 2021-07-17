<?php

namespace Drupal\gestion_usuario\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Symfony\Component\DependencyInjection\ContainerInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;


class FiltroFormUsuario extends FormBase{

    
    private $session;
    public function __construct(SessionInterface $session)
    {
      $this->session = $session;
  
    }
    public static function create(ContainerInterface $container)
    {
      return new static(
        $container->get('session')
      );
    }
  public function getFormId(){

    return 'gestion_usuario_filtro';
  }

  
  public function buildForm(array $form, FormStateInterface $form_state){
    $filtros= $this->session->get('gestion_usuario_filtro', []);

    $form['nombre'] = [
        '#type' => 'textfield',
        '#title' => 'Nombre',
        '#default_value' => isset($filtros['nombre']) ? $filtros['nombre'] : '',
    ];
    $form['actions']['submit']=[
        '#type' => 'submit',
        '#value' => 'Filtrar',
  
      ];
      $form['actions']['reset']=[
        '#type' => 'submit',
        '#value' => 'Resetear',
        '#submit' => ['::resetSubmit']
  
      ];
    return $form;
  }

 

  public function submitForm(array &$form, FormStateInterface $form_state){
      $filtro=[];
      $filtro['nombre']= $form_state->getValue('nombre');
      $this->session->set('gestion_usuario_filtro', $filtro);

  }
  public function resetSubmit(array &$form, FormStateInterface $form_state)
  {
    $filtro = [];
    $this->session->set('gestion_usuario_filtro', $filtro);

  }

}