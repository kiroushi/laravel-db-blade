<?php

namespace Kiroushi\DbBlade\Models;

use Illuminate\Database\Eloquent\Model;

class DbView extends Model
{

    public function __construct(array $attributes = [])
    {
        parent::__construct($attributes);

        $this->setTable(config('db-blade.table_name'));
    }

}
