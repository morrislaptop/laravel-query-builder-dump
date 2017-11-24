<?php


use Illuminate\Database\Query\Builder;
use Morrislaptop\QueryBuilderDump\QueryBuilderDumpServiceProvider;

class DumpTest extends Orchestra\Testbench\TestCase
{
    /** @test */
    public function it_provides_a_dump_macro()
    {
        $this->assertTrue(Builder::hasMacro('dump'));
    }

    /** @test */
    public function it_dumps_the_query()
    {
        $dumped = null;

        $dumper = function ($var) use (&$dumped) {
            $dumped = $var;
        };

        $first = DB::table('users')->whereNull('first_name');

        $users = DB::table('users')
                   ->dump($dumper)
                   ->select('name', 'email as user_email')
                   ->distinct()
                   ->addSelect(DB::raw('count(*) as user_count'))
                   ->join('contacts', 'users.id', '=', 'contacts.user_id')
                   ->union($first)
                   ->where('something', 'true')
                   ->orWhere('name', 'John')
                   ->orderBy('name', 'desc')
                   ->groupBy('account_id')
                   ->offset(10)
                   ->limit(5)
                   ->having('account_id', '>', 100)
                   ->dump($dumper);

        $expected = [
            'bindings' => [
                'where' => [
                    'true',
                    'John'
                ],
                'having' => [
                    100
                ]
            ],
            'sql' => '(select distinct `name`, `email` as `user_email`, count(*) as user_count from `users` inner join `contacts` on `users`.`id` = `contacts`.`user_id` where `something` = ? or `name` = ? group by `account_id` having `account_id` > ?) union (select * from `users` where `first_name` is null) order by `name` desc limit 5 offset 10'
        ];

        $this->assertArraySubset($expected, $dumped);
    }

    /** @test */
    public function it_dumps_a_raw_query()
    {
        $dumped = null;

        $dumper = function ($var) use (&$dumped) {
            $dumped = $var;
        };

        $users = DB::table('users')
                   ->where('something', 50)
                   ->orWhere('name', 'John')
                   ->orderBy('name', 'desc')
                   ->having('account_id', '>', 100)
                   ->dump($dumper);

        $expected = "select * from `users` where `something` = 50 or `name` = 'John' having `account_id` > 100 order by `name` desc";

        $this->assertEquals($expected, $dumped['raw']);
    }

    protected function getPackageProviders($app)
    {
        return [QueryBuilderDumpServiceProvider::class];
    }
}
