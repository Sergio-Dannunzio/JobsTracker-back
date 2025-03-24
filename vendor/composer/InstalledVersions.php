<?php

namespace Composer;

use Composer\Semver\VersionParser;






class InstalledVersions
{
private static $installed = array (
  'root' => 
  array (
    'pretty_version' => '1.0.0',
    'version' => '1.0.0.0',
    'aliases' => 
    array (
    ),
    'reference' => NULL,
    'name' => 'sergio/backend-mongo',
  ),
  'versions' => 
  array (
    'graham-campbell/result-type' => 
    array (
      'pretty_version' => 'v1.1.3',
      'version' => '1.1.3.0',
      'aliases' => 
      array (
      ),
      'reference' => '3ba905c11371512af9d9bdd27d99b782216b6945',
    ),
    'mongodb/builder' => 
    array (
      'replaced' => 
      array (
        0 => '*',
      ),
    ),
    'mongodb/mongodb' => 
    array (
      'pretty_version' => '1.21.1',
      'version' => '1.21.1.0',
      'aliases' => 
      array (
      ),
      'reference' => '37bc8df3a67ddf8380704a5ba5dbd00e92ec1f6a',
    ),
    'phpoption/phpoption' => 
    array (
      'pretty_version' => '1.9.3',
      'version' => '1.9.3.0',
      'aliases' => 
      array (
      ),
      'reference' => 'e3fac8b24f56113f7cb96af14958c0dd16330f54',
    ),
    'psr/log' => 
    array (
      'pretty_version' => '3.0.2',
      'version' => '3.0.2.0',
      'aliases' => 
      array (
      ),
      'reference' => 'f16e1d5863e37f8d8c2a01719f5b34baa2b714d3',
    ),
    'sergio/backend-mongo' => 
    array (
      'pretty_version' => '1.0.0',
      'version' => '1.0.0.0',
      'aliases' => 
      array (
      ),
      'reference' => NULL,
    ),
    'symfony/polyfill-ctype' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a3cc8b044a6ea513310cbd48ef7333b384945638',
    ),
    'symfony/polyfill-mbstring' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '85181ba99b2345b0ef10ce42ecac37612d9fd341',
    ),
    'symfony/polyfill-php73' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '0f68c03565dcaaf25a890667542e8bd75fe7e5bb',
    ),
    'symfony/polyfill-php80' => 
    array (
      'pretty_version' => 'v1.31.0',
      'version' => '1.31.0.0',
      'aliases' => 
      array (
      ),
      'reference' => '60328e362d4c2c802a54fcbf04f9d3fb892b4cf8',
    ),
    'vlucas/phpdotenv' => 
    array (
      'pretty_version' => 'v5.6.1',
      'version' => '5.6.1.0',
      'aliases' => 
      array (
      ),
      'reference' => 'a59a13791077fe3d44f90e7133eb68e7d22eaff2',
    ),
  ),
);







public static function getInstalledPackages()
{
return array_keys(self::$installed['versions']);
}









public static function isInstalled($packageName)
{
return isset(self::$installed['versions'][$packageName]);
}














public static function satisfies(VersionParser $parser, $packageName, $constraint)
{
$constraint = $parser->parseConstraints($constraint);
$provided = $parser->parseConstraints(self::getVersionRanges($packageName));

return $provided->matches($constraint);
}










public static function getVersionRanges($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

$ranges = array();
if (isset(self::$installed['versions'][$packageName]['pretty_version'])) {
$ranges[] = self::$installed['versions'][$packageName]['pretty_version'];
}
if (array_key_exists('aliases', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['aliases']);
}
if (array_key_exists('replaced', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['replaced']);
}
if (array_key_exists('provided', self::$installed['versions'][$packageName])) {
$ranges = array_merge($ranges, self::$installed['versions'][$packageName]['provided']);
}

return implode(' || ', $ranges);
}





public static function getVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['version'])) {
return null;
}

return self::$installed['versions'][$packageName]['version'];
}





public static function getPrettyVersion($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['pretty_version'])) {
return null;
}

return self::$installed['versions'][$packageName]['pretty_version'];
}





public static function getReference($packageName)
{
if (!isset(self::$installed['versions'][$packageName])) {
throw new \OutOfBoundsException('Package "' . $packageName . '" is not installed');
}

if (!isset(self::$installed['versions'][$packageName]['reference'])) {
return null;
}

return self::$installed['versions'][$packageName]['reference'];
}





public static function getRootPackage()
{
return self::$installed['root'];
}







public static function getRawData()
{
return self::$installed;
}



















public static function reload($data)
{
self::$installed = $data;
}
}
