<?php

namespace spec\App\Http\Controllers;

use App\Http\Controllers\LineasEstrategicasController;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

class LineasEstrategicasControllerSpec extends ObjectBehavior
{
    function it_is_initializable()
    {
        $this->shouldHaveType(LineasEstrategicasController::class);
    }

    function it_returns_correct_json()
    {
        $this->show(1);
        $this->shouldReturn(12);
    }
}
