<?php

class EquifaxFactory
{
    public static function get($triggerName)
    {
        switch ($triggerName)
        {
            case 'approve':
                return new ApproveReport();
                break;

            case 'cancelled':
                return new CancellReport();
                break;

            case 'signing':
                return new SigningReport();
                break;

            case 'issuance':
                return new IssuanceReport();
                break;

            case 'expire':
                return new ExpiredReport();
                break;
        }
    }
}