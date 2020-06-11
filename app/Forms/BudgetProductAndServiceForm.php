<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class BudgetProductAndServiceForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Nome',
                'rules' => 'required|max:100'
            ])
            ->add('price', 'text', [
                'label' => 'Preço',
                'rules' => 'required',
                'class' => 'col-md-12'
            ])
            ->add('description', 'text', [
                'label' => 'Descrição',
                'rules' => 'required|max:100'
            ])
            ->add('position', 'number', [
                'label' => 'Posição',
                'rules' => 'required|int|min:1'
            ])
            ->add('comments', 'textarea', [
                'label' => 'Comentario'
            ]);
    }
}
