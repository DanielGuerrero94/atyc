<?php

namespace Tests;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class DatabaseCase extends TestCase
{
    use DatabaseMigrations;
    use DatabaseTransactions;
}
