<?php

namespace AppBundle\SearchRepository;

use FOS\ElasticaBundle\Repository;
use AppBundle\SearchModel\ItemModel;

/**
 * ItemRepository
 *
 * This class was generated by the Doctrine ORM. Add your own custom
 * repository methods below.
 */
class ItemRepository extends Repository
{

    public function search(ItemModel $itemModel)
    {
        // we create a query to return all the items
        // but if the criteria title is specified, we use it
        if ($itemModel->getTitle() != null && $itemModel != '') {
            $query = new \Elastica\Query\Match();
            $query->setFieldQuery('item.title', $itemModel->getTitle());
            $query->setFieldFuzziness('item.title', 0.7);
            $query->setFieldMinimumShouldMatch('item.title', '80%');
        } else {
            $query = new \Elastica\Query\MatchAll();
        }
        $baseQuery = $query;

        // then we create filters depending on the chosen criterias
        $boolQuery = new \Elastica\Query\BoolQuery();

        /*
            Dates filter
            We add this filter only the getIspublished filter is not at "false"
        */
        if ($itemModel->getDateFrom() !== false && $itemModel->getDateTo() !== false)
        {
            $dateRangeFilter = new \Elastica\Query\Range();
            $dateRangeFilter->addField('createdAt',array(
                "gte" => \Elastica\Util::convertDate($itemModel->getDateFrom()->getTimestamp()),
                "lte" => \Elastica\Util::convertDate($itemModel->getDateTo()->getTimestamp())
            ));
            $boolQuery->addMust($dateRangeFilter);
        }

        // Published or not filter
        if ($itemModel->getIsPublished() !== null) {
            $publishedFilter = new \Elastica\Query\Terms();
            $publishedFilter->setTerms('published', array($itemModel->getIsPublished()));
            $boolQuery->addMust($publishedFilter);
        }

        $filtered = new \Elastica\Query\Filtered($baseQuery, $boolQuery);

        $query = \Elastica\Query::create($filtered);

        return $this->find($query);
    }

}
