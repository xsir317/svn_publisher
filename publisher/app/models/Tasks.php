<?php

class Tasks extends Eloquent {


    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'tasks';
    public $timestamps = false;

    //自定义一些enum字段的含义
    public static $types = array(
        'checkout' => '版本库初始化', 
        'update' => '更新', 
        'delete' => '删除版本库', 
        'rsync' => '同步',
    );
    public static $status = array(
        'created' => '已建立', 
        'execute' => '执行中', 
        'success' => '成功', 
        'failed' => '失败'
    );
    
}
