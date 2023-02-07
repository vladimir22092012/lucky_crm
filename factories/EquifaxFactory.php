<?php

class EquifaxFactory
{
    public static function get($triggerName)
    {
        switch ($triggerName)
        {
            case 'issuance':
                return new IssuanceReport();
                break;
        }
    }
}