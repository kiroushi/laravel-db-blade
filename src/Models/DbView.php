<?php

namespace Kiroushi\DbBlade\Models;

use Illuminate\Database\Eloquent\Model;

class DbView extends Model
{

    /**
     * Create a new Eloquent model instance.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct()
    {
        parent::__construct(...func_get_args());

        $this->setTable(config('db-blade.table_name'));
    }

}
