<?php

declare(strict_types=1);

use Phinx\Migration\AbstractMigration;

final class CreateDadosPessoaisTable extends AbstractMigration
{
    public function change(): void
    {
        $table = $this->table('dadospessoais');
        $table->addColumn('id', 'integer', ['identity' => true]) 
              ->addColumn('tipo', 'enum', ['values' => ['fisica', 'juridica']])
              ->addColumn('nome', 'string', ['limit' => 100])
              ->create();
    }
}