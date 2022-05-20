<?php

// this allows to lint Latte 2 project with this linter

namespace Latte\Macros;

if (interface_exists('Latte\Macros\MacroSet')) {
    return;
}

abstract class MacroSet
{
}
