<?php

namespace Sitegeist\Babbylon\Eel;

use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\ContentRepository\Domain\Model\Node;
use Neos\Eel\ProtectedContextAwareInterface;

class ContentHelper implements ProtectedContextAwareInterface
{

    /**
     * Bring the key to the start of the array
     *
     * @param NodeInterface[] $currentContents
     * @param NodeInterface[] $translatedContents
     * @return array
     */
    public function compareContentCollections($currentContents, $translatedContents) {
        $translatedContentIdentifiers = [];
        $currentContentIdentifiers = [];
        $currentContentByIdentifier = [];
        $result = array();

        if ($currentContents) {
            foreach ($currentContents as $currentContent) {
                $currentContentIdentifiers[] = $currentContent->getIdentifier();
                $currentContentByIdentifier[$currentContent->getIdentifier()] = $currentContent;
            }
        }

        if ($translatedContents) {
            foreach ($translatedContents as $translatedContent) {
                $identifier = $translatedContent->getIdentifier();
                if (in_array($identifier, $currentContentIdentifiers)) {
                    $result[] = [
                        'status' => ($translatedContent instanceof Node && $translatedContent->dimensionsAreMatchingTargetDimensionValues()) ? 'translated' : 'fallback',
                        'node' => $translatedContent,
                        'reference' => $currentContentByIdentifier[$identifier]
                    ];
                    $translatedContentIdentifiers[] = $identifier;
                } else {
                    $result[] = [
                        'status' => 'addition',
                        'node' => $translatedContent,
                        'reference' => null
                    ];
                }
            }
        }

        $missingTranslationIdentifiers = array_diff($currentContentIdentifiers, $translatedContentIdentifiers);
        foreach ($missingTranslationIdentifiers as $missingTranslationIdentifier) {
            $result[] = [
                'status' => 'missing',
                'node' => $currentContentByIdentifier[$missingTranslationIdentifier],
                'reference' => null
            ];
        }

        return $result;
    }

    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
