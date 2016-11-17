<?php
namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\web\UrlRule;
use yii\base\Object;

class MyUrlRule extends UrlRule
{//Object implements UrlRuleInterface
	/**
     * Parses the given request and returns the corresponding route and parameters.
     * @param \yii\web\UrlManager $manager the URL manager
     * @param \yii\web\Request $request the request component
     * @return array|boolean the parsing result. The route and the parameters are returned as an array.
     * If false, it means this rule cannot be used to parse this path info.
     */
    public function parseRequest($manager, $request)
    {

        $pathInfo = $request->getPathInfo();
        if(Yii::$app->user->isGuest){
            return false;
        }
        $parameters = explode('/', $pathInfo);
        if (count($parameters) == 4) {
            $subdomain = explode('.', $parameters[0]);
            if($subdomain[0]==Yii::$app->user->identity->username){
                return false;
            } 
        }
        /*if (count($parameters) != 4 ) {
            return false;
        }*/
        //return false;
        return parent::parseRequest($manager,$request);
    }
    /**
     * Creates a URL according to the given route and parameters.
     * @param \yii\web\UrlManager $manager the URL manager
     * @param string $route the route. It should not have slashes at the beginning or the end.
     * @param array $params the parameters
     * @return string|boolean the created URL, or false if this rule cannot be used for creating this URL.
     */
    public function createUrl($manager, $route, $params)
    {
        /*if (!array_key_exists('subdomain', $params) || empty($params['subdomain'])) {
            $params['subdomain']='www';
        }*/
        /*if($params['subdomain']!=Yii::$app->user->identity->username){
            return false;
        }*/
        //return parent::createUrl($manager, $route, $params);
        //return 'www.rgkproject.kz/site/default/index';
        return http_build_query($params);
    }
}