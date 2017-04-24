<?php

namespace App\Utils;

use App\Utils\TencentImage\Auth;
use App\Utils\TencentImage\Conf;

class TencentImage
{
    const APPID = 10002987;
    /**
     * @var 图片空间名 supade（供求）
     */
    const BUCKET_SUPADE = 'supade';

    /**
     * @var 图片空间名 price（鱼价通）
     */
    const BUCKET_PRICE = 'price';

    /**
     * @var 图片空间名 water（水面获取）
     */
    const BUCKET_WATER = 'water';

    /**
     * @var 图片空间名 passport（用户头像）
     */
    const BUCKET_PASSPORT = 'passport';
    /**
     * 交易图片
     */
    const BUCKET_TRADE = 'trade';


    /**
     * 构造图片唯一ID
     * @param int $userid
     * @param string $bucket
     * @return boolean|string
     */
    public static function makeFileid($userid)
    {
        if (!$userid) {
            return false;
        } else {
            return $userid . '-' . uniqid();
        }
    }

    /**
     * 获取签名
     * @param type $bucket 空间名
     * @param int $expired 过期时间 默认30天，单次则传0
     * @param type $fileid 自定义字段
     * @return type
     */
    public static function makeTencentSign($bucket = self::BUCKET_PASSPORT, $expired = 30, $fileid = '')
    {

        if ($expired > 0) {
            $time = time() + $expired * 24 * 3600;
        } else {
            $time = 0;
        }
        return Auth::getAppSignV2($bucket, $fileid, $time);
    }

    /**
     * 获取万象优图路径
     * @param type $fileid 自定义图片路径
     * @param type $bucket 图片空间名
     * @param type $type 缩略图类型
     * @param type $imageView2 缩略图处理参数
     * @return string DownloadUri
     */
    public static function makeDownloadUri($fileid, $bucket = self::BUCKET_PASSPORT, $type = 1, $imageView2 = '')
    {
        $params = '';
        if (!$bucket) {
            $bucket = self::BUCKET_PASSPORT;
        }
        if (!$type) {
            $type = 1;
        }
        if (!$fileid) {
            $fileid = 'avatar-system-000';
        }
        if ($imageView2) {
            $params = sprintf('?imageView2/%s/%s', $type, $imageView2);
        }
        return sprintf('http://%s-%s.image.myqcloud.com/%s%s', $bucket, Conf::APPID, $fileid, $params);
    }

    /**
     * 获取万象优图路径(默认灰色底色的图片)
     * @param type $fileid 自定义图片路径
     * @param type $bucket 图片空间名
     * @param type $type 缩略图类型
     * @param type $imageView2 缩略图处理参数
     * @return string DownloadUri
     */
    public static function makeDownloadDefaultUri($fileid, $bucket = self::BUCKET_PASSPORT, $type = 1, $imageView2 = '')
    {
        $params = '';
        if (!$bucket) {
            $bucket = self::BUCKET_PASSPORT;
        }
        if (!$type) {
            $type = 1;
        }
        if (!$fileid) {
            $fileid = 'avatar-system-00';
        }
        if ($imageView2) {
            $params = sprintf('?imageView2/%s/%s', $type, $imageView2);
        }
        return sprintf('http://%s-%s.image.myqcloud.com/%s%s', $bucket, Conf::APPID, $fileid, $params);
    }

}
