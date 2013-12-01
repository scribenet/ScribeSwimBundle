<?php
/*
 * This file is part of the Scribe World Application.
 *
 * (c) Scribe Inc. <scribe@scribenet.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Scribe\LearningBundle\Utility\Parser\Swim;

use Symfony\Component\DependencyInjection\ContainerAwareInterface,
    Symfony\Component\DependencyInjection\ContainerInterface;
use Scribe\SharedBundle\Utility\Filters\String,
    Scribe\LearningBundle\Utility\Parser\ParserInterface;

/**
 * Class SwimParserNodeLink
 */
class SwimParserNodeLink extends SwimParserObserver implements ParserInterface, ContainerAwareInterface
{
    /**
     * @param null $string
     * @return mixed|null
     */
    public function render($string = null)
    {
        @preg_match_all('#{~node:([a-z0-9-]*?)( (.*?))?}#i', $string, $nodeMatches);
        
        if (0 < count($nodeMatches[0])) {

            for ($i = 0; $i < count($nodeMatches[0]); $i++) {

                $original = $nodeMatches[0][$i];
                $key      = $nodeMatches[1][$i];
                $title    = empty($nodeMatches[3][$i]) ? $key : $nodeMatches[3][$i];
                $url      = $this->router->generate('learning_node_view', ['index' => $key]);
                $replace  = '<a class="a-internal" href="'.$url.'">'.$title.'</a>';

                $string = str_replace($original, $replace, $string);
            }
        }

        return $string;
    }
}