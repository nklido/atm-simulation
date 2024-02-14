<?php

namespace Core;

interface CashDispenser
{
    public function dispense($notes,$amount): array|null;
}