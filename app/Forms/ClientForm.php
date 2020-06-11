<?php

namespace App\Forms;

use Kris\LaravelFormBuilder\Form;

class ClientForm extends Form
{
    public function buildForm()
    {
        $this
            ->add('name', 'text', [
                'label' => 'Nome da Turma',
                'rules' => 'required|max:20',
                'attr' => ['class' => 'form-control no-border']
            ])
            ->add('institution', 'text', [
                'label' => 'Instituição',
                'rules' => 'required|max:30',
                'attr' => ['class' => 'form-control no-border']
            ])
            ->add('courses', 'text', [
                'label' => 'Cursos',
                'rules' => 'required|max:100',
                'attr' => ['class' => 'form-control no-border']
            ])
            ->add('month_conclusion', 'select', [
                'choices' => \App\Models\Config::getMonthOfConclusion(),
                'label' => 'Mês de Conclusão',
                'rules' => 'required|in:'.implode(',', array_keys(\App\Models\Config::getMonthOfConclusion())),
                'attr' => ['class' => 'form-control no-border']
            ])
            ->add('year_conclusion', 'select', [
                'choices' => \App\Models\Config::getConclusionYear(),
                'label' => 'Ano de Conclusão',
                'rules' => 'required|in:'.implode(',', array_keys(\App\Models\Config::getConclusionYear())),
                'attr' => ['class' => 'form-control no-border']
            ])
            ->add('comments', 'textarea', [
                'label' => 'Comentario (Não aparece no orçamento)'
            ]);
    }
}
/*
 * $table->increments('id');
            $table->integer('user_id')->unsigned();
            $table->foreign('user_id')->references('id')->on('users');
            $table->string('institution');
            $table->string('courses');
            $table->integer('month_conclusion');
            $table->integer('year_conclusion');
            $table->tinyInteger('representative');
            $table->text('comments')->nullable();
            $table->timestamps();
 */
