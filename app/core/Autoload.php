<?php
class Autoload
{
    public static function register()
    {
        spl_autoload_register([__CLASS__, 'autoload']);
    }

    private static function autoload($className)
    {
        $baseDir = __DIR__ . '/../';
        
        // Mapeo de carpetas según el sufijo
        $folders = [
            'Controller' => 'controllers/',
            'Model' => 'models/',
            'Service' => 'services/',
        ];
        
        // Buscar por sufijo
        foreach ($folders as $suffix => $folder) {
            if (strpos($className, $suffix) !== false) {
                $file = $baseDir . $folder . $className . '.php';
                if (file_exists($file)) {
                    require_once $file;
                    return true;
                }
            }
        }
        
        // Buscar en core
        $coreFile = $baseDir . 'core/' . $className . '.php';
        if (file_exists($coreFile)) {
            require_once $coreFile;
            return true;
        }
        
        // Búsqueda general en todas las carpetas
        $allFolders = ['controllers', 'models', 'core', 'services', 'config'];
        foreach ($allFolders as $folder) {
            $file = $baseDir . $folder . '/' . $className . '.php';
            if (file_exists($file)) {
                require_once $file;
                return true;
            }
        }
        
        return false;
    }
}