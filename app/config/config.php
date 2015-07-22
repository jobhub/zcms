<?php
return array (
  'version' => '2.0.1',
  'debug' => 0,
  'logError' => 0,
  'debugType' => 'var_dump',
  'database' => 
  array (
    'adapter' => 'Mysql',
    'host' => 'localhost',
    'username' => 'root',
    'password' => 'root',
    'dbname' => 'zcms',
    'port' => '3306',
    'schema' => 'public',
    'log' => 0,
    'charset' => 'utf8',
  ),
  'website' => 
  array (
    'baseUri' => '',
    'direction' => 'ltr',
    'language' => 'en-GB',
    'metaDesc' => 'ZCMS Power by Phalcon 2',
    'metaKey' => 'zcms, phalcon 2',
    'siteName' => 'ZCMS Demo',
    'systemName' => 'ZCMS SYSTEM',
    'timezone' => 'America/Los_Angeles',
  ),
  'auth' => 
  array (
    'salt' => '09oi5ilFsWH5J92ZobvVsg',
    'lifetime' => 3600,
  ),
  'backendTemplate' => 
  array (
    'compileTemplate' => 1,
    'defaultTemplate' => 'default',
  ),
  'frontendTemplate' => 
  array (
    'compileTemplate' => 1,
    'defaultTemplate' => 'default',
  ),
  'mail' => 
  array (
    'from_name' => 'ZCMS',
    'mailFrom' => '',
    'mailStatus' => 1,
    'mailType' => 'smtp',
    'sendMail' => '/usr/sbin/sendmail',
    'smtpAuth' => 1,
    'smtpHost' => 'smtp.gmail.com',
    'smtpPass' => '',
    'smtpPort' => 465,
    'smtpSecure' => 'ssl',
    'smtpUser' => '',
  ),
  'pagination' => 
  array (
    'feedLimit' => 15,
    'limit' => 15,
    'mediaLimit' => 12,
  ),
  'viewCache' => 
  array (
    'lifetime' => 1800,
    'dir' => '/cache/web/',
  ),
  'cachePrefix' => 'ZCMS_',
  'fileCache' => 
  array (
    'lifetime' => 1800,
    'cacheDir' => '/cache/fileCache/',
    'status' => true,
  ),
  'apcCache' => 
  array (
    'prefix' => 'cache',
    'lifetime' => 1800,
    'status' => true,
  ),
  'memCache' => 
  array (
    'host' => 'localhost',
    'lifetime' => 1800,
    'port' => 11211,
    'prefix' => 'ZCMS_',
    'status' => true,
  ),
  'redisCache' => 
  array (
    'host' => 'localhost',
    'port' => 6379,
    'lifetime' => 1800,
    'auth' => 'ZCMS',
    'persistent' => false,
    'status' => true,
  ),
  'modelMetadataCache' => 
  array (
    'status' => true,
    'lifetime' => 1800,
    'type' => 'files',
  ),
);
