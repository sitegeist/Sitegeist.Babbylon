<?php

namespace Sitegeist\Babbylon\Eel;

use Neos\Eel\ProtectedContextAwareInterface;

class ArrayHelper implements ProtectedContextAwareInterface
{

    /**
     * Bring the key to the start of the array
     *
     * @param $arrayValue
     * @param $keyToPromote
     * @return mixed
     */
    public function promoteKey($arrayValue, $keyToPromote) {
        if (array_key_exists($keyToPromote, $arrayValue)) {
            $value = $arrayValue[$keyToPromote];
            unset($arrayValue[$keyToPromote]);
            array_merge([$keyToPromote => $value], $arrayValue);
        }
        return $arrayValue;
    }

    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
