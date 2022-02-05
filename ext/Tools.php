<?php
/**
 * @author WizZzarD <artur.rusanov2013@gmail.com>
 *
 * @link https://steamcommunity.com/id/WizzarD_1/
 *
 * @license GNU General Public License Version 3
 */

namespace app\modules\module_page_shop\ext;

class Tools
{
    public const SHOP_URL = '/shop/';

    public const LICENSE_HOST = 'https://war-ussr.myarena.site';

    public static function generateBillId()
    {
        $bytes = '';
        for ($i = 1; $i <= 16; $i++) {
            $bytes .= chr(mt_rand(0, 255));
        }

        $hash = bin2hex($bytes);

        return sprintf(
            '%08s-%04s-%04s-%02s%02s-%012s',
            substr($hash, 0, 8),
            substr($hash, 8, 4),
            str_pad(dechex(hexdec(substr($hash, 12, 4)) & 0x0fff & ~(0xf000) | 0x4000), 4, '0', STR_PAD_LEFT),
            str_pad(dechex(hexdec(substr($hash, 16, 2)) & 0x3f & ~(0xc0) | 0x80), 2, '0', STR_PAD_LEFT),
            substr($hash, 18, 2),
            substr($hash, 20, 12)
        );

    }

    public static function getCurrentURL(): string
    {
        $url = (!empty($_SERVER['HTTPS'])) ? 'https' : 'http';
        $url .= '://' . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
        $url = explode('?', $url)[0];

        return $url;
    }

    public static function timestampByDays(int $days): int
    {
        return $days === 0 ? 0 : time() + $days * 24 * 60 * 60;
    }

    public static function getNicknameBySteam(string $steam): ?string
    {
        $steam = con_steam32to64($steam);

        $data = simplexml_load_file("http://steamcommunity.com/profiles/$steam/?xml=1");

        return isset($data->steamID) ? $data->steamID : null;
    }
}
