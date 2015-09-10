<?php

require_once(__DIR__ . '/../vendor/autoload.php');

use NamelessCoder\Fluid\View\TemplateView;
use Symfony\Component\Yaml\Yaml;

/**
*
*/
class Bootstrap {

    public function __construct() {
		$httpMethod = isset($_SERVER['REQUEST_METHOD']) ? $_SERVER['REQUEST_METHOD'] : 'GET';
		$requestUri = isset($_SERVER['REQUEST_URI']) ? parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH) : '/';

        $baseUrl = str_replace('index.php', '', $_SERVER['SCRIPT_NAME']);
        $requestUri = str_replace($baseUrl, '', $requestUri);

        $path = $this->convertUriToPath($requestUri);
        if(empty($path)) {
            $path = 'Index';
        }

        $templateFile = __DIR__ . '/../Templates/' . $path . '.html';

        if (!file_exists($templateFile)) {
            die('Template not found!: ' . 'Templates/' . $path . '.html');
        }

        $paths = new \NamelessCoder\Fluid\View\TemplatePaths();
        $paths->setLayoutRootPaths(array(__DIR__ . '/../Layouts/'));
        $paths->setPartialRootPaths(array(__DIR__ . '/../Partials/'));
        $paths->setTemplatePathAndFilename($templateFile);
        $view = new \NamelessCoder\Fluid\View\TemplateView($paths);

        $fixturesPaths = array('Global', $path);
        $fixtures = array();
        foreach ($fixturesPaths as $fixturePath) {
            $fixturePath = __DIR__ . '/../Fixtures/' . $fixturePath . '.yaml';
            if (file_exists($fixturePath)) {
                $fixtures = array_replace_recursive($fixtures, Yaml::parse(file_get_contents($fixturePath)));
            }
        }
        $view->assign('baseUrl', $baseUrl);
        $view->assign('currentPath', $path);
        $view->assignMultiple($fixtures);
        echo $view->render();
    }

    public function convertUriToPath($uri) {
        $parts = explode('/', $uri);
        array_walk($parts, function(&$value, $key){
            $value = ucfirst($value);
        });
        return implode('/', $parts);
    }
}