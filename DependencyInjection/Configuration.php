<?php

namespace rs\SmartspritesBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\NodeBuilder;
use Symfony\Component\Config\Definition\Builder\TreeBuilder;

/**
 * default config for DIC
 * 
 * @author Robert Schönthal <seroscho@googlemail.com>
 * @package rs.ProjectUtitlitiesBundle
 * @subpackage DepedencyInjection
 */
class Configuration
{
    /**
     * Generates the configuration tree.
     *
     * @return \Symfony\Component\Config\Definition\NodeInterface
     */
    public function getConfigTree($kernelDebug)
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('project_utilities', 'array');

        $rootNode
                ->arrayNode('bootstrap')->
                    variableNode('class')->
                    variableNode('file')->
                end()
                ->arrayNode('bundleloader')->
                    variableNode('class')->
                    variableNode('file')->
                end()
                ->arrayNode('configurator')->
                    variableNode('class')->
                    variableNode('setup')->
                    variableNode('dist')->
                    variableNode('config')->
                end()
                ;
                
        return $treeBuilder->buildTree();
    }
}
