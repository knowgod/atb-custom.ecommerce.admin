<?php

namespace App\Mappings;

use Doctrine\Common\Annotations\AnnotationRegistry;
use Doctrine\Common\Annotations\Annotation;
use Illuminate\Contracts\Config\Repository;
use LaravelDoctrine\ACL\Mappings\RelationAnnotation;

/**
 * @Annotation
 * @Target("PROPERTY")
 */
final class HasAnnotatedPermissions extends RelationAnnotation
{
    /**
     * @param Repository $config
     *
     * @return mixed
     */
    public function getTargetEntity(Repository $config)
    {
        if($config->get('acl.permissions.driver') === 'policy'){
            return false;
        }
        // Config driver has no target entity
        if ($config->get('acl.permissions.driver', 'config') === 'config') {
            return false;
        }

        return $this->targetEntity ?: $config->get('acl.permissions.entity', 'Permission');
    }
}
