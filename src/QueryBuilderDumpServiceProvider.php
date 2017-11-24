<?php

namespace Morrislaptop\QueryBuilderDump;

use Illuminate\Database\Query\Builder;
use Illuminate\Support\ServiceProvider;

class QueryBuilderDumpServiceProvider extends ServiceProvider
{
    public function register()
    {
        $raw = function ($sql, $bindings) {
            $flat = array_flatten($bindings);
            foreach ($flat as $binding) {
                $binded = is_numeric($binding) ? $binding : "'{$binding}'";
                $sql = preg_replace('/\?/', $binded, $sql, 1);
            }

            return $sql;
        };

        Builder::macro('dump', function ($dumper = 'dump') use ($raw) {
            $dumper([
                'bindings' => $this->bindings,
                'sql' => $this->toSql(),
                'raw' => $raw($this->toSql(), $this->bindings)
            ]);

            return $this;
        });
    }
}
