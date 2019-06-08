<?php

namespace Kiroushi\DbBlade;

use View;
use ArrayAccess;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Contracts\Support\Renderable;
use Kiroushi\DbBlade\Compilers\DbBladeCompiler;
use Kiroushi\DbBlade\Engines\DbBladeCompilerEngine;

class DbView extends \Illuminate\View\View implements ArrayAccess, Renderable
{
    protected $contentField = null;
    protected $model = null;

    /**
     * Create a new dbview instance.
     *
     * @param  \Kiroushi\DbBlade\Factory  $factory
     * @param  string  $view
     * @param  Model  $model
     * @param  mixed  $data
     * @param  string|null  $contentField
     */
    public function __construct(Factory $factory, $view, $model, $data = [], $contentField = null)
    {
        $this->view = $view;
        $this->path = $view;
        $this->model = $model;
        $this->engine = new DbBladeCompilerEngine(app(DbBladeCompiler::class));
        $this->factory = $factory;

        if (! is_null($contentField)) {
            $this->contentField = $contentField;
        } else {
            $this->contentField = config('db-blade.content_field');
        }

        $this->data = $data instanceof Arrayable ? $data->toArray() : (array) $data;
    }

    /**
     * Get the evaluated contents of the view.
     *
     * @return string
     */
    protected function getContents()
    {
        $field = config('db-blade.model_property');

        $this->model->{$field} = $this->contentField;

        return $this->engine->get($this->model, $this->gatherData());
    }
}
