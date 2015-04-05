<?php
/**
 * @license   http://opensource.org/licenses/BSD-3-Clause BSD-3-Clause
 * @copyright Copyright (c) 2014 Zend Technologies USA Inc. (http://www.zend.com)
 */

namespace ZF\Doctrine\QueryBuilder\Filter\ODM;

use MongoRegex;

class Like extends AbstractFilter
{
    public function filter($queryBuilder, $metadata, $option)
    {
        $queryType = 'addAnd';
        if (isset($option['where'])) {
            if ($option['where'] === 'and') {
                $queryType = 'addAnd';
            } elseif ($option['where'] === 'or') {
                $queryType = 'addOr';
            }
        }

        $regex = '/' . str_replace('%', '.*?', $option['value']) . '/i';

        $queryBuilder->$queryType(
            $queryBuilder
              ->expr()
              ->field($option['field'])
              ->equals(new MongoRegex($regex))
        );
    }
}