<?php
namespace Sitegeist\Babbylon\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\ContentRepository\Domain\Model\NodeInterface;
use Neos\Neos\Domain\Service\SiteService;

/**
 * @Flow\Scope("singleton")
 */
class NodeController extends ActionController
{

    /**
     * Translate content form a node to another content from one node to
     *
     * @param NodeInterface $contentNode
     * @param NodeInterface $targetCollection
     * @param NodeInterface $targetDocument
     * @return void
     */
    public function translateContentAction(NodeInterface $contentNode, NodeInterface $targetCollection, NodeInterface $targetDocument)
    {
        $targetContext = $targetCollection->getContext();
        $targetContext->adoptNode($contentNode, true);
        $parentNode = $contentNode;
        while ($parentNode = $parentNode->getParent()) {
            $visibleInContext = $targetContext->getNodeByIdentifier($parentNode->getIdentifier()) !== null;
            if ($parentNode->getPath() !== '/' && $parentNode->getPath() !== SiteService::SITES_ROOT_PATH && !$visibleInContext) {
                $targetContext->adoptNode($parentNode, true);
            }
        }

        $this->redirect('show', 'Frontend\\Node', 'Neos.Neos', ['node' => $targetDocument], 20);
    }

}
