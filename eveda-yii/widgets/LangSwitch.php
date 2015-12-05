<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\widgets;

use Yii;
use yii\helpers\Html;

/**
 * Alert widget renders a message from session flash. All flash messages are displayed
 * in the sequence they were assigned using setFlash. You can set message as following:
 *
 * ```php
 * \Yii::$app->getSession()->setFlash('error', 'This is the message');
 * \Yii::$app->getSession()->setFlash('success', 'This is the message');
 * \Yii::$app->getSession()->setFlash('info', 'This is the message');
 * ```
 *
 * Multiple messages could be set as follows:
 *
 * ```php
 * \Yii::$app->getSession()->setFlash('error', ['Error 1', 'Error 2']);
 * ```
 *
 * @author Kartik Visweswaran <kartikv2@gmail.com>
 * @author Alexander Makarov <sam@rmcreative.ru>
 */
class LangSwitch extends \yii\base\Widget
{
    //error
    private $error;

    // Language items
    public $items = [];

    public function init()
    {
        $route = Yii::$app->controller->route;
        $appLanguage = Yii::$app->language;
        $params = $_GET;
        $this->error = $route === Yii::$app->errorHandler->errorAction;

        array_unshift($params, '/'.$route);

        foreach (Yii::$app->params['supportLang'] as $lk => $lv) {
            $isWildcard = substr($lk, -2)==='-*';
            $isActive = false;
            if (
                $lk===$appLanguage ||
                // Also check for wildcard language
                $isWildcard && substr($appLanguage,0,2)===substr($lk,0,2)
            ) {
                //continue;   // Exclude the current language
                $isActive = true;
            }
            if ($isWildcard) {
                $lk = substr($lk,0,2);
            }
            $params['language'] = $lk;

            $this->items[] = [
                'label' => $lv,
                'url' => $params,
                'active' => $isActive
            ];
        }
        parent::init();
    }

    public function run()
    {
        // Only show this widget if we're not on the error page
        if ($this->error) {
            return '';
        } else {
            
            if(!empty($this->items) && Yii::$app->getI18n()) {

                $html = Html::beginTag('ul', ['class' => 'lang-switch']);
                foreach ($this->items as $item) {
                    $html .= Html::beginTag('li');
                    $html .= Html::a($item['label'], $item['url'], ['class' => $item['active'] ? 'active' : '']);
                    $html .= Html::endTag('li');
                }
                $html .= Html::endTag('ul');
                echo $html;
            }
        }
    }

}