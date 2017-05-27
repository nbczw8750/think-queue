<?php
namespace nbczw8750\sms;
/**
 * Created by PhpStorm.
 * User: 蔡志伟
 * Date: 2017/5/27
 * Time: 10:00
 */
class CCPhoneNum
{
    /**
     * 处理并过滤不需要的号码和不合法的号码
     * @param $phones
     * @param array $allow_type
     * @return array|bool
     */
    public static function dealPhone($phones,$allow_type = array("yd","lt","dx")){
        if(!$phones) return false;
        $phones_arr  = array();
        if(!is_array($phones)){
            $phones_arr = preg_split ( '/[,;\r\n]+/', trim ( $phones, ",;\r\n" ) );
        }
        foreach($phones_arr as $key => &$val){
            $val = preg_replace("/^\+86/",'',(string)$val);
            $type = self::getMobileType($val);
            if(!in_array($type,$allow_type)){
                array_splice($phones_arr,$key,1);
            }
        }
        $phones_arr = array_unique($phones_arr);
        return $phones_arr;
    }

    /**
     * 获取手机号码归属运营商
     * @param $phoneNum
     * @return string 移动yd 联通lt 电信dx
     */
    public static function getMobileType($phoneNum){
        $rule = array();
        $rule['lt'] = '/^13[012][0-9]{8}|15[56][0-9]{8}|145[0-9]{8}|176[0-9]{8}|18[56][0-9]{8}$/';
        $rule['yd'] = '/^134[0-8][0-9]{7}|13[56789][0-9]{8}|147[0-9]{8}|15[012789][0-9]{8}|178[0-9]{8}|18[23478][0-9]{8}$/';
        $rule['dx'] = '/^133[0-9]{8}|153[0-9]{8}|177[0-9]{8}|18[019][0-9]{8}$/';
        $type = "";
        if(preg_match ( $rule['yd'], (string)$phoneNum ) === 1){
            $type = "yd";
        }elseif(preg_match ( $rule['lt'], (string)$phoneNum ) === 1){
            $type = "lt";
        }elseif(preg_match ( $rule['dx'], (string)$phoneNum ) === 1){
            $type = "dx";
        }
        return $type;
    }

    /**
     * 过滤非法的手机号码
     * @param $phones
     * @return mixed
     */
    public static function filterMobile($phones){
        foreach ($phones as $key => &$val){
            $val = preg_replace("/^\+86/",'',(string)$val);
            if (false === self::isMobile($val)){
                array_splice($phones,$key,1);
            }
        }
        return $phones;
    }

    /**
     * 判断是否是手机号码
     * @param $value
     * @return bool
     */
    public static function isMobile($value){
        return 1 === preg_match("/^1[34578]{1}\d{9}$/",(string)$value);
    }

    /**
     * 扩展手机号码所属运营商
     * @param array $phones
     * @return array [number=>13000000000,type=lt]
     */
    public static function extendMobile($phones){
        if(!is_array($phones)){
            $phones = preg_split ( '/[,;\r\n]+/', trim ( $phones, ",;\r\n" ) );
        }
        $arr = array();
        $i = 0;
        while (isset($phones[0])){
            $phoneNum = array_shift($phones[0]);
            $arr[$i]['mobile'] = $phoneNum;
            $arr[$i]['type'] = self::getMobileType($phoneNum);
            $i++;
        }
        return $arr;
    }
}