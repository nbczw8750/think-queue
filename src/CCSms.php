<?php
/**
 * Created by PhpStorm.
 * User: 蔡志伟
 * Date: 2017/5/27
 * Time: 10:25
 */

namespace nbczw8750\sms;


class CCSms
{
    protected $error = "";
    /*
     * 插入发送数据
     * $param = array(
     *  'interface_id' => '接口id',
     *  'content' => '内容',
     *  'phones' => '手机号码【数组或“,”分开】',
     *  'counts' => '条数',
     * )
     * $return = "返回结果说明"
     * */
    /**
     * @param $param
     */
    public function send($param){

    }
    public function getError(){
        return $this->error;
    }
}