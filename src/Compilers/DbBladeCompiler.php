<?php

namespace Kiroushi\DbBlade\Compilers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\View\Compilers\BladeCompiler;
use Illuminate\View\Compilers\CompilerInterface;

class DbBladeCompiler extends BladeCompiler implements CompilerInterface
{

    /**
     * Compile the view from the given model
     *
     * @param  Model  $model
     * @return void
     */
    public function compile($model = null)
    {
        if (is_null($model)) {
            return;
        }
       
        // Defaults to '__db_blade_compiler_content_field' property
        $field = config('db-blade.model_property');

        $column = $model->{$field};
        $content = $model->{$column};

        // Compile to PHP
        $contents = $this->compileString($content);

        if (!is_null($this->cachePath)) {
            $this->files->put($this->getCompiledPath($model), $contents);
        }
    }

    /**
     * Get the path to the compiled version of a view.
     *
     * @param  Model  $model
     * @return string
     */
    public function getCompiledPath($model)
    {

        /*
         * A unique path for the given model instance must be generated
         * so the view has a place to cache. The following generates a
         * path using almost the same logic as Blueprint::createIndexName()
         *
         * e.g db_table_name_id_4
         */
        $field = config('db-blade.model_property');
        $path  = 'db_' . $model->getTable() . '_' . $model->{$field} . '_';
        
        if (is_null($model->primaryKey)) {
            $path .= $model->id;
        } else if (is_array($model->primaryKey)) {
            $path .= implode('_', $model->primaryKey);
        } else {
            $path .= $model->primaryKey;
        }

        $path = strtolower(str_replace(array('-', '.'), '_', $path));

        return $this->cachePath . '/' . md5($path);
    }

    /**
     * Determine if the view for the given model is expired.
     *
     * @param  Model  $model
     * @return bool
     */
    public function isExpired($model)
    {
        if (!config('db-blade.cache')) {
            return true;
        }

        $compiled = $this->getCompiledPath($model);

        // If the compiled file doesn't exist we will indicate that the view is expired
        // so that it can be re-compiled. Else, we will verify the last modification
        // of the views is less than the modification times of the compiled views.
        if (!$this->cachePath || !$this->files->exists($compiled)) {
            return true;
        }

        $lastModified = strtotime($model->updated_at);

        return $lastModified >= $this->files->lastModified($compiled);
    }

}
