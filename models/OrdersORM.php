<?php

class OrdersORM extends \Illuminate\Database\Eloquent\Model
{
    protected $table = 's_orders';
    protected $guarded = [];
    public $timestamps = false;

    public function user()
    {
        return $this->hasOne(UsersORM::class, 'id', 'user_id');
    }

    public function contract()
    {
        return $this->hasOne(ContractsORM::class, 'id', 'contract_id');
    }
}