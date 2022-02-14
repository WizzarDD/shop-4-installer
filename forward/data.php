<?php
/**
 * @author WizZzarD <artur.rusanov2013@gmail.com>
 *
 * @link https://steamcommunity.com/id/WizzarD_1/
 *
 * @license GNU General Public License Version 3
 */

use app\modules\module_page_shop\ext\Key;
use app\modules\module_page_shop\ext\Query;
use app\modules\module_page_shop\ext\Tools;

if( IN_LR != true ) { header('Location: ' . $General->arr_general['site']); exit; }

$params = [
    'host' => $_SERVER['HTTP_HOST'],
    'license' => Key::getByName(Key::MAIN_KEY)
];

$content = Query::post(Tools::LICENSE_HOST . '/api/version/download/last', $params, [], true);

$fd = fopen (MODULES . 'module_page_shop/version.zip', "wb");
$out = fwrite ($fd, $content);

$zip = new ZipArchive;
$res = $zip->open(MODULES . 'module_page_shop/version.zip');
if ($res === TRUE) {
    $zip->extractTo(MODULES . 'module_page_shop');
    $zip->close();
    echo 'ok';
} else {
    echo 'failed';
}
refresh();