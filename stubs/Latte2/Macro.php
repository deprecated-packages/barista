<?php

// this allows to lint Latte 2 project with this linter

namespace Latte;

if (interface_exists('Latte\Macro')) {
    return;
}

interface Macro
{
}
