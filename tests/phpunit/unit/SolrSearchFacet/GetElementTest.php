<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  solr-search
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


class SolrSearchFacetTest_GetElement extends SolrSearch_Test_AppTestCase
{


    /**
     * `getElement` should return the parent element.
     */
    public function testParentElement()
    {

        $title = $this->elementTable->findByElementSetNameAndElementName(
            'Dublin Core', 'Title'
        );

        $facet = new SolrSearchFacet($title);

        // Should return the parent element.
        $this->assertEquals($title->id, $facet->getElement()->id);

    }


    /**
     * `getElement` should return NULL when no element is defined.
     */
    public function testNoParentElement()
    {

        $facet = new SolrSearchFacet();

        // Should return NULL.
        $this->assertNull($facet->getElementSet());

    }


}