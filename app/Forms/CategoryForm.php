<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class CategoryForm extends Form
{
    public function buildForm()
    {
        $eventTypes = \App\Models\EventType::getEventTypesArray();
        $this
            ->add('event_type_id', 'select', [
                'choices' => ['Selecione...' => $eventTypes],
                'label' => 'Tipo do Evento',
                'rules' => 'required|min:1|in:' . implode(',', array_keys($eventTypes))
            ])
            ->add('name', 'text', [
                'label' => 'Nome da Categoria',
                'rules' => 'required|max:30'
            ])
            ->add('position', 'number', [
                'label' => 'Posição',
                'rules' => 'required|int|min:1'
            ])
            ->
            add('image', 'file', [
                'label' => 'Escolha a imagem que irá representar sua categoria',
                'rules' => 'required'
               
            ]);
        /*            ->add('status', 'select', [
                        'choices' => \App\Models\Category::status(),
                        'label' => 'Status',
                        'rules' => 'required|in:'.implode(',', array_keys(\App\Models\Category::status()))
                    ]);*/
    }


}
