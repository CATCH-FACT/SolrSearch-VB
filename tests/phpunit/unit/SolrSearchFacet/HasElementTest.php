<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  solr-search
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */


class SolrSearchFacetTest_HasElement extends SolrSearch_Test_AppTestCase
{


    /**
     * `hasElement` should return true when a parent element is provided.
     */
    public function testParentElement()
    {

        $title = $this->elementTable->findByElementSetNameAndElementName(
            'Dublin Core', 'Title'
        );

        $facet = new SolrSearchFacet($title);

        // True when a parent element exists.
        $this->assertTrue($facet->hasElement());

    }


    /**
     * `getElement` should return NULL when no element is defined.
     */
    public function testNoParentElement()
    {

        $facet = new SolrSearchFacet();

        // False when no parent element exists.
        $this->assertFalse($facet->hasElement());

    }


}