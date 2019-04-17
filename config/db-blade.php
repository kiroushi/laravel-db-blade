<?php

return [

    'model_name' => 'Kiroushi\DbBlade\Models\DbView',
    'table_name' => 'db_views',

    /**
     * The default name field used to look up for the model.
     * e.g. DbView::make($viewName) or dbview($viewName)
     */
    'name_field' => 'name',

    /**
     * The default model field to be compiled when not explicitly specified
     * with DbView::field($fieldName) or DbView::model($modelName, $fieldName)
     */
    'content_field' => 'content',

    /**
     * This property will be added to models being compiled with DbView
     * to keep track of which field in the model is being compiled
     */
    'model_property' => '__db_blade_compiler_content_field',

    'cache' => false,
    'cache_path' => 'app/db-blade/cache/views'

];