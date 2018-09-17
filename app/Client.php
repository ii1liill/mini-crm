<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use SoftDeletes;
    //
    protected $table = 'crm_clients';

    protected $guarded = [];
    /**
     * 应被转换为日期的属性。
     *
     * @var array
     */
    protected $dates = [
        'created_at',
        'reg_at',
        'updated_at',
        'deleted_at',
        'order_at',
        'insure_created_at',
        'insure_sent_at',
        'commercial_insure_time',
        'forced_insure_time',
        'prev_insure_create_at'
    ];

    protected $casts = [
        'pics' => 'array',
    ];
    /**
     * 一对一创建者
     *
     * @return void
     */
    public function creator()
    {
        return $this->hasOne('App\User', 'id', 'create_by');
    }

    /**
     * 最后一条追踪
     *
     * @return void
     */
    public function lastNote()
    {
        return $this->hasOne('App\Trace', 'client_id', 'id')->whereNotNull('note')->orderBy('id', 'desc');
    }
    
    /**
     * Undocumented function
     *
     * @return void
     */
    public function service()
    {
        return $this->hasOne('App\User', 'id', 'belong_service');
    }

    
    
}
