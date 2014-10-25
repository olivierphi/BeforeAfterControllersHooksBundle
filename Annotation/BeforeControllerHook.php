<?php

namespace Rougemine\Bundle\BeforeAfterControllersHooksBundle\Annotation;

/**
 * @Annotation
 */
class BeforeControllerHook extends ControllerHookAnnotationBase
{
    /**
     * @return mixed the Controller hook result
     */
    public function triggerControllerHook()
    {
        if ('@' == $this->targetCallable[0]) {
            // The target is a "@serviceId::method" string
            list($serviceId, $serviceMethodName) = explode('::', $this->targetCallable);
            $serviceId = substr($serviceId, 1);// leading "@" removal
            $callable = array($this->container->get($serviceId), $serviceMethodName);
        } else {
            // The target is a method name of the Controller itself
            $callable = array($this->controller[0], $this->targetCallable);
        }

        return call_user_func_array($callable, $this->targetCallableArgs);
    }
}
