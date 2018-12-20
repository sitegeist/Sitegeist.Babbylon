<?php

namespace Sitegeist\Babbylon\Eel;

use Neos\ContentRepository\Domain\Model\NodeInterface;
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

        foreach ($currentContents as $currentContent) {
            $currentContentIdentifiers[] = $currentContent->getIdentifier();
            $currentContentByIdentifier[ $currentContent->getIdentifier() ] = $currentContent;
        }

        $result = array();

        foreach ($translatedContents as $translatedContent) {
            $identifier = $translatedContent->getIdentifier();
            if (in_array($identifier, $currentContentIdentifiers)) {
                $result[] = [
                    'status' => 'translated',
                    'node' => $translatedContent
                ];
                $translatedContentIdentifiers[] = $identifier;
            } else {
                $result[] = [
                    'status' => 'addition',
                    'node' => $translatedContent
                ];
            }
        }

        $missingTranslationIdentifiers = array_diff($currentContentIdentifiers, $translatedContentIdentifiers);
        foreach ($missingTranslationIdentifiers as $missingTranslationIdentifier) {
            $result[] = [
                'status' => 'missing',
                'node' => $currentContentByIdentifier[$missingTranslationIdentifier]
            ];
        }

        return $result;
    }

    public function allowsCallOfMethod($methodName)
    {
        return true;
    }
}
