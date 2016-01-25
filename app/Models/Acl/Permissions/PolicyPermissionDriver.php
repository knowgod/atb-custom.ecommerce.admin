<?php

namespace App\Models\Acl\Permissions;

use Illuminate\Contracts\Config\Repository;
use Illuminate\Support\Collection;
use LaravelDoctrine\ACL\Permissions\PermissionDriver;
use Symfony\Component\Finder\Finder as FileFinder;

class PolicyPermissionDriver implements PermissionDriver {
    /**
     * @var Repository
     */
    protected $repository;

    /**
     * @param Repository $repository
     */
    public function __construct(Repository $repository){
        $this->repository = $repository;
    }

    /**
     * @return Collection
     */
    public function getAllPermissions($policiesClassesDirPath = null, $policiesNamespace = 'App\\Policies'){

        if (!$policiesClassesDirPath){
            $policiesClassesDirPath = app_path() . DIRECTORY_SEPARATOR . 'Policies';
        }
        $finder = new FileFinder();

        $finder->files()->name('*Policy.php')->in($policiesClassesDirPath);

        $permissionsList = [];

        foreach ($finder as $file){
            if ($relativePath = $file->getRelativePath()){
                $policiesNamespace .= '\\' . strtr($relativePath, '/', '\\');
            }
            $class = $policiesNamespace . '\\' . $file->getBasename('.php');
            $policyReflectionObject = new \ReflectionClass($class);

            $permissionsList[$policyReflectionObject->getShortName()] = $this->getAnnotatedPermissions($policyReflectionObject->getMethods());
        }
        return new Collection(
                $permissionsList
        );
    }

    protected function getAnnotatedPermissions($reflectionMethods = []){
        $result = [];

        foreach($reflectionMethods as $method){
            /**
             * @var $method ReflectionMethod
             */

            if(strstr($method->getDocComment(), '@Policy\PermissionMethod') !== false){
                $result[] = $method->getName();
            }
        }
        return $result;
    }
}
