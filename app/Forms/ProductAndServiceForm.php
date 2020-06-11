<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ProductAndServiceForm extends Form
{
    public function buildForm()
    {
        $aliasProducts = \App\Models\ProductAndService::getProductsArray();
        $aliasProducts[0] = 'Nenhum';
        $this
            ->add('name', 'text', [
                'label' => 'Nome',
                'rules' => 'required|max:100'
            ])
            ->add('category_id', 'select', [
                'choices' => \App\Models\Category::getCategoryEventTypeArray(),
                'label' => 'Categoria',
                'rules' => 'required|int|min:1'
            ])
            ->add('price', 'text', [
                'label' => 'Preço',
                'rules' => 'required',
                'class' => 'col-md-12'
            ])
            ->add('cost_price', 'text', [
                'label' => 'Preço de Custo',
                'rules' => 'required'
            ])
            ->add('minimum_price', 'text', [
                'label' => 'Preço Mínimo',
                'rules' => 'required'
            ])
            ->add('description', 'text', [
                'label' => 'Descrição',
                'rules' => 'required|max:100'
            ])
            ->add('position', 'number', [
                'label' => 'Posição',
                'rules' => 'required|int|min:1'
            ])
            ->add('proportion_per_person', 'number', [
                'label' => 'Proporção por pessoa',
                'rules' => 'required|int|min:0'
            ])
            ->add('multiplying_graduates', 'select', [
                'choices' => [0 => 'Não', 1 => 'Sim'],
                'label' => 'Multiplicado por Formando',
                'rules' => 'required|int|min:0'
            ])
            ->add('multiplied_invitations', 'select', [
                'choices' => [0 => 'Não', 1 => 'Sim'],
                'label' => 'Multiplicado por Convite',
                'rules' => 'required|int|min:0'
            ])
            ->add('extras_invitations', 'select', [
                'choices' => [0 => 'Não', 1 => 'Sim'],
                'label' => 'Multiplicado por Convites Extras',
                'rules' => 'required|int|min:0'
            ])
            ->add('extras_tables', 'select', [
                'choices' => [0 => 'Não', 1 => 'Sim'],
                'label' => 'Multiplicado por Mesas Extras',
                'rules' => 'required|int|min:0'
            ])
/*            ->add('alias', 'select', [
                'choices' => $aliasProducts,
                'label' => 'Sub Produto de',
                'rules' => 'required|int|min:0'
            ])*/
            ->add('comments', 'textarea', [
                'label' => 'Comentario (Aparece no Orçamento)'
            ]);
    }
}
