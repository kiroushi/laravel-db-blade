<?php

namespace Kiroushi\DbBlade\Engines;

use Illuminate\View\Engines\CompilerEngine;
use Kiroushi\DbBlade\Compilers\DbBladeCompiler;

class DbBladeCompilerEngine extends CompilerEngine
{
    /**
     * Create a new DbView engine instance.
     *
     * @param  \Kiroushi\DbBlade\Compilers\DbBladeCompiler  $compiler
     */
    public function __construct(DbBladeCompiler $compiler)
    {
        $this->compiler = $compiler;
    }
}
