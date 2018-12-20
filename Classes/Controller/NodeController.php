<?php
namespace Sitegeist\Babbylon\Controller;

use Neos\Flow\Annotations as Flow;
use Neos\Flow\Mvc\Controller\ActionController;
use Neos\ContentRepository\Domain\Model\NodeInterface;

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
        $targetCollection->getContext()->adoptNode($contentNode, true);
        $this->redirect('show', 'Frontend\\Node', 'Neos.Neos', ['node' => $targetDocument], 20);
    }

}
