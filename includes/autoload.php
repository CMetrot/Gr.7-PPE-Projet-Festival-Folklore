<?php
/**
 * Chargement dynamique des classes 
 * dont les espaces de noms respectent la PSR-0
 * sauf qu'ils ne sont pas préfixés par le "Vendor"
 * @param type $className
 */
function __autoload($className)
{
//    $className = ltrim($className, '\\');
    $fileName  = __DIR__.'/../';

    $fileName  .= str_replace('\\', DIRECTORY_SEPARATOR, $className).'.class.php';
    if (file_exists($fileName)) {
        require_once($fileName);
    } else {
        throw new Exception('Pb autoload : Le fichier ' . $fileName . ' n\'existe pas.');
    }
    
}