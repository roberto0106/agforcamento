<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class EventTypeForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text',[
                'label' => 'Nome',
                'rules' => 'required',
            ])
            // ->add('status', 'number',[
            //     'label' => 'Status',
            //     'rules' => 'required',
            // ])
            ->add('position', 'number',[
                'label' => 'Posição',
                'rules' => 'required',
            ]);
    }
}
