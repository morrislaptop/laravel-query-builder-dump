<?php

namespace Morrislaptop\QueryBuilderDump;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class QueryBuilderDumpServiceProvider extends ServiceProvider
{
    public function register()
    {
        Builder::macro('dump', function ($dumper = 'dump') {

            $dumper([
                'bindings' => $this->bindings,
                'sql' => $this->toSql()
            ]);

            return $this;
        });
    }
}
