<?php
namespace app\components;

use Yii;
use yii\web\UrlRuleInterface;
use yii\base\Object;

class UsernameUrlRule implements UrlRuleInterface
{
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
        //This rule only applies to paths that start with 'jobs'
        if(Yii::$app->user->isGuest){
        	return false;
        }
        //controller/action that will handle the request
        //$route = 'post/<action>';
        //parameters in the URL (category, subcategory, state, city, page)
        $params = [];
        /*$parameters = explode('/', $pathInfo);
        if (count($parameters) == 4) {
            $subdomain = explode('.', $parameters[0]);
            if($params['subdomain']==Yii::$app->user->identity->username){
            	$params['subdomain'] = $subdomain[0];
            }
            return false;
        }
        if (count($parameters) != 4 ) {
            return false;
        }*/
        //$params['subdomain']=$request->getHostInfo();
        Yii::trace("Request parsed with URL rule: site/jobs", __METHOD__);
        return [$route, $params];
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
        /*if ($route !== 'post/<action>') {
            return false;
        }*/
        //If a parameter is defined and not empty - add it to the URL
        if (array_key_exists('subdomain', $params) && !empty($params['subdomain'])) {
            $url = $params['subdomain'];
        }
        else{
        	$url = 'www';
        }
        $url.='.rgkproject.kz/site/post/<action>';
        return $url;
    }
}