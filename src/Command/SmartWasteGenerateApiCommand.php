<?php

namespace BespokeSupport\SmartWaste\Command;

use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class SmartWasteGenerateApiCommand extends Command
{
    public const API_URL = 'http://api.smartwaste.co.uk/api_data.js';

    public static $defaultName = 'sw:generate:api';

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $baseDir = dirname(__DIR__, 2);

        $methodDir = $baseDir . '/src/Method/';

        if (!is_dir($methodDir) && !mkdir($methodDir)) {
            throw new RuntimeException('No Method directory');
        }

        $file = $baseDir . '/api.json';

        if (!file_exists($file) || !$api = file_get_contents($file)) {
            $api = file_get_contents(self::API_URL);

            $api = str_replace('define({ "api":', '', $api);
            $api = str_replace('] });', ']', $api);
            file_put_contents($file, $api);
        }

        $json = json_decode($api);

        $uris = [];
        $classes = [];
        $methods = [];
        $groups = [];

        $authNon = [];
        $authReq = [];

        foreach ($json as $obj) {
            $uri = ltrim($obj->url, '/');

            preg_match_all('#(\{\w+\})#', $uri, $vars);

            $uris[$obj->title] = $uri;
            $methods[$obj->title] = $obj->type;

            $classes[] = $obj->title;

            if (!array_key_exists($obj->group, $groups)) {
                $groups[$obj->group] = [];
            }

            $groups[$obj->group][] = $obj->title;

            $headers = $obj->header ?? new \stdClass();
            $headerField = $headers->fields ?? new \stdClass();
            $headerFields = $headerField->Header ?? [];

            foreach ($headerFields as $field) {
                if ($field->field === 'authToken') {
                    $authReq[] = $obj->title;
                }
            }

            if (!in_array($obj->title, $authReq)) {
                $authNon[] = $obj->title;
            }

            $paramsObj = $obj->parameter ?? new \stdClass();
            $fields = $paramsObj->fields ?? new \stdClass();
            $params = $fields->Parameter ?? [];

            $paramsReq = [];
            $paramsOpt = [];

            foreach ($params as $param) {
                if ($param->optional) {
                    $paramsOpt[] = $param->field;
                } else {
                    $paramsReq[] = $param->field;
                }
            }

            $properties = '';
            $keys = '';
            $urlVars = $vars[0] ?? [];
            $urlVarsArr = array_map(function($v) {return preg_replace('#[\{\}]#', '', $v);}, $urlVars);

            $props = array_merge($urlVarsArr, $paramsReq, $paramsOpt);
            array_walk($props, function($k) use (&$properties, &$keys) {
                $properties .= " * @property mixed $k \n";
                $keys .= "        \$this->$k = \$$k;\n";
            });

            $constructor = '';

            foreach ($urlVarsArr as $param) {
                $constructor .= "\$$param, ";
            }

            foreach ($paramsReq as $param) {
                $constructor .= "\$$param, ";
            }

            foreach ($paramsOpt as $param) {
                $constructor .= "\$$param = null, ";
            }

            $constructor = rtrim($constructor, ', ');

            $className = $obj->title;

            $className = ucwords($className);

            $classStr = <<<PHP
<?php

namespace BespokeSupport\SmartWaste\Method;

use BespokeSupport\SmartWaste\Base\BaseMethod;

/**
$properties */
class $className extends BaseMethod
{
    public function __construct($constructor)
    {
$keys    }
}
PHP;

            $classFile = $methodDir . "$className.php";

            file_put_contents($classFile, $classStr);

            /**
             * Save the example responses
             */

            $success = $obj->success ?? null;

            if ($success) {
                $example = $success->examples[0] ?? null;

                if ($example) {
                    $content = preg_replace('#^HTTP[^\n]+#','', $example->content);

                    file_put_contents($baseDir . "/tests/Responses/{$obj->title}." . $example->type, $content);
                }
            }
        }

        $classFileApi = $baseDir . '/src/SmartWasteApi.php';

        $apiClassMethods = '';
        $uses = '';
        array_walk($classes, function($k) use (&$apiClassMethods, &$uses) {
            $class = ucwords($k);
            $uses .= "use BespokeSupport\SmartWaste\Method\\$class;\n";
            $apiClassMethods .= " * @method static $k(SmartWasteCredentials \$credentials, $class \$obj, Client \$client = null) \n";
        });

        $classStr = <<<PHP
<?php

namespace BespokeSupport\SmartWaste;

$uses
use GuzzleHttp\Client;

/**
$apiClassMethods */
class SmartWasteApi
{
    public static function __callStatic(\$method, \$args)
    {
        /**
         * @var \$credentials SmartWasteCredentials
         * @var \$obj
         * @var \$client Client|null
         */
        \$credentials = \$args[0] ?? null;
        \$obj = \$args[1] ?? null;
        \$client = \$args[2] ?? null;

        if (!\$credentials || !\$credentials instanceof SmartWasteCredentials) {
            throw new \LogicException('Credentials not provided');
        }

        if (!\$obj) {
            throw new \LogicException('API Method object not provided');
        }

        \$params = SmartWaste::params(\$obj);

        \$client = \$client ?? SmartWaste::client(\$credentials);

        \$res = SmartWaste::call(\$credentials, \$obj, \$params, \$client);

        return \$res;
    }
}
PHP;

        file_put_contents($classFileApi, $classStr);

        $classFile = $baseDir . '/src/SmartWasteRoutes.php';

        $classStr = <<<PHP
<?php

namespace BespokeSupport\SmartWaste;

class SmartWasteRoutes
{
    public const URL_API = 'http://api.smartwaste.co.uk/v1/';


PHP;

        $classStr .= '    public static $uri = ';
        $classStr .= \Symfony\Component\VarExporter\Internal\Exporter::export($uris, '    ');
        $classStr .= ";\n\n";

        $classStr .= '    public static $methods = ';
        $classStr .= \Symfony\Component\VarExporter\Internal\Exporter::export($methods, '    ');
        $classStr .= ";\n\n";

        $classStr .= '    public static $groups = ';
        $classStr .= \Symfony\Component\VarExporter\Internal\Exporter::export($groups, '    ');
        $classStr .= ";\n\n";

        $classStr .= <<<PHP
    /**
     * @param \$obj
     * @return string
     */
    public static function classToShort(\$obj): string
    {
        try {
            \$reflection = new \ReflectionClass(\$obj);

            \$method = lcfirst(\$reflection->getShortName());

            \$uri = SmartWasteRoutes::\$uri[\$method] ?? null;

            if (!\$uri) {
                throw new \RuntimeException("Unknown method '\$method'");
            }

            return \$method;
            // @codeCoverageIgnoreStart
        } catch (\ReflectionException \$e) {
            return '';
        }
        // @codeCoverageIgnoreEnd
    }

    /**
     * @param \$obj
     * @return string
     */
    public static function toUrlRelative(\$obj): string
    {
        \$class = self::classToShort(\$obj);

        \$uri = SmartWasteRoutes::\$uri[\$class] ?? null;

        preg_match_all('#(:\w+)|(\{\w+\})#', \$uri, \$vars);

        \$data = [];
        if (count(\$vars)) {
            foreach (\$vars[0] as \$var) {
                \$key = preg_replace('#[\:\{\}]#', '', \$var);

                \$val = \$obj->\$key ?? null;

                \$data[\$var] = \$val;
            }
        }

        \$uri = str_replace(array_keys(\$data), array_values(\$data), \$uri);

        return \$uri;
    }

PHP;

        $classStr .= "}\n";

        file_put_contents($classFile, $classStr);
    }
}