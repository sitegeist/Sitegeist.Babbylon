<?php

namespace Sitegeist\Babbylon\Eel;

use Neos\Flow\Annotations as Flow;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Eel\ProtectedContextAwareInterface;
use Neos\Flow\Security\Context;
use Neos\Flow\Security\Authentication\AuthenticationManagerInterface;

class SecurityHelper implements ProtectedContextAwareInterface
{

    /**
     * @Flow\Inject
     * @var Context
     */
    protected $securityContext;

    /**
     * @Flow\Inject
     * @var AuthenticationManagerInterface
     */
    protected $authenticationManager;

    /**
     * Bring the key to the start of the array
     *
     * @param NodeInterface[] $currentContents
     * @param NodeInterface[] $translatedContents
     * @return array
     */
    public function getCsrfToken() {
        if (!$this->securityContext->isInitialized() || !$this->authenticationManager->isAuthenticated()) {
            return '';
        }
        $csrfToken = $this->securityContext->getCsrfProtectionToken();

        return $csrfToken;
    }

    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
