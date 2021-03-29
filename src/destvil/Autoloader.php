<?php


namespace destvil;


class Autoloader {
    protected array $registeredPrefixs;

    public function __construct() {
        $this->registeredPrefixs = array();
    }

    public function register(): void {
        spl_autoload_register(array($this, 'loader'));
    }

    public function registerPrefix(string $prefix): Autoloader {
        $this->registeredPrefixs[] = $prefix;
        return $this;
    }

    private function loader($className): void {
        $class = str_replace('\\', DIRECTORY_SEPARATOR, trim($className));
        foreach ($this->registeredPrefixs as $prefix) {
            $prefix = str_replace('\\', DIRECTORY_SEPARATOR, trim($prefix));
            $classPath = sprintf('%s/%s/%s.php', $_SERVER['DOCUMENT_ROOT'], $prefix, $class);
            if (is_readable($classPath)) {
                include $classPath;
                return;
            }
        }

        $classPath = sprintf('%s/%s.php', $_SERVER['DOCUMENT_ROOT'], $class);
        if (is_readable($classPath)) {
            include $classPath;
            return;
        }
    }
}