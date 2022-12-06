<?php

class SmsMessagesORM extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 's_sms_messages';
    protected $guarded = [];
    public $timestamps = false;
}