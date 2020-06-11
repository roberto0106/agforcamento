<?php

namespace App\Forms;

use App\Helpers\BudgetHelper;
use App\Models\Client;
use Kris\LaravelFormBuilder\Form;

class BudgetForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Nome do Orçamento',
                'rules' => 'required|max:30'
            ])
            ->add('client_id', 'select', [
                'choices' => Client::ClientToSelect(),
                'label' => 'Cliente',
                'rules' => 'required|int',
                'model' => 'client',
                'attr' => ['id' => 'client']
            ])
            ->add('number_of_installments', 'number', [
                'label' => 'Número de Parcelas',
                'rules' => 'required|int|min:1',
                'attr' => ['id' => 'parcels'],
                'empty_value' => '=== Numero de Parcelas ==='
            ])
            ->add('fee', 'text', [
                'label' => 'FEE',
                'rules' => 'required|int',
                'template' => 'customs.fee'
            ])
            ->add('photo_exclusivity', 'text', [
                'label' => 'Exclusividade Fotográfica',
                'rules' => 'required|int',
                'template' => 'customs.exclusividade_fotografica'
            ])
            ->add('paying_commission', 'number', [
                'label' => 'Comissão Pagante',
                'rules' => 'required|string|int',
                'template' => 'customs.paying_commision'
            ])
            ->add('shelf_life', 'date', [
                'label' => 'Validado até',
                'rules' => 'required|date'
            ])
            ->add('internal_comment', 'textarea', [
                'label' => 'Comentário Interno',
                'rules' => ''
            ])
            ->add('external_comment', 'textarea', [
                'label' => 'Comentário para o Cliente',
                'rules' => ''
            ])
            ->add('status', 'select', [
                'choices' => \App\Models\Budget::status(),
                'label' => 'Status',
                'rules' => 'required|in:' . implode(',', array_keys(\App\Models\Budget::status()))
            ]);

    }

}