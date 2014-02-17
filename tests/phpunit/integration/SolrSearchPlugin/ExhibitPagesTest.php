<?php

/* vim: set expandtab tabstop=4 shiftwidth=4 softtabstop=4 cc=80; */

/**
 * @package     omeka
 * @subpackage  solr-search
 * @copyright   2012 Rector and Board of Visitors, University of Virginia
 * @license     http://www.apache.org/licenses/LICENSE-2.0.html
 */

class SolrSearchPluginTest_ExhibitPages extends SolrSearch_Test_AppTestCase
{


    /**
     * Install Exhibit Builder or skip the suite.
     */
    public function setUp()
    {
        parent::setUp();
        $this->_installPluginOrSkip('ExhibitBuilder');
    }


    /**
     * When a page is added to a public exhibit, it should be indexed in Solr.
     */
    public function testIndexNewPageInPublicExhibit()
    {

        // Add a public exhibit.
        $exhibit = $this->_exhibit(true);

        // Add a page to the exhibit.
        $page = $this->_exhibitPage($exhibit);

        // Should add a Solr document.
        $this->_assertRecordInSolr($page);

    }


    /**
     * When an existing exhibit is switched from private to public, a page in
     * the exhibit should be indexed in Solr.
     * @group pages
     */
    public function testIndexPageWhenExhibitSetPublic()
    {

        // Add a private exhibit.
        $exhibit = $this->_exhibit(false);

        // Add a page to the exhibit.
        $page = $this->_exhibitPage($exhibit);

        // Set exhibit public.
        $exhibit->public = true;
        $exhibit->save();

        // Should add a Solr document.
        $this->_assertRecordInSolr($page);

    }


    /**
     * When a page is added to a private exhibit, it should not be indexed.
     */
    public function testDontIndexNewPageInPrivateExhibit()
    {

        // Add a private exhibit.
        $exhibit = $this->_exhibit(false);

        // Add a page to the exhibit.
        $page = $this->_exhibitPage($exhibit);

        // Should add a Solr document.
        $this->_assertNotRecordInSolr($page);

    }


    /**
     * When an existing exhibit is switched from public to private, a page in
     * the exhibit should be removed from Solr.
     */
    public function testRemovePageWhenExhibitSetPrivate()
    {

        // Add a public exhibit.
        $exhibit = $this->_exhibit(true);

        // Add a page to the exhibit.
        $page = $this->_exhibitPage($exhibit);

        // Set exhibit private.
        $exhibit->public = false;
        $exhibit->save();

        // Should remove Solr document.
        $this->_assertNotRecordInSolr($page);

    }


    /**
     * When a public exhibit is deleted, a page in the exhibit should be
     * removed from Solr.
     */
    public function testRemovePageWhenExhibitDeleted()
    {

        // Add a public exhibit.
        $exhibit = $this->_exhibit(true);

        // Add a page to the exhibit.
        $page = $this->_exhibitPage($exhibit);

        // Delete exhibit.
        $exhibit->delete();

        // Should remove Solr document.
        $this->_assertNotRecordInSolr($page);

    }


    /**
     * The exhibit URL should be indexed.
     */
    public function testIndexUrl()
    {

        // Add a public exhibit.
        $exhibit = $this->_exhibit(true);

        // Add a page to the exhibit.
        $page = $this->_exhibitPage($exhibit);

        // Get the Solr document for the page.
        $document = $this->_getRecordDocument($page);

        // Should index the URL.
        $this->assertEquals(record_url($page, 'show'), $document->url);

    }


    /**
     * The result type should be indexed.
     */
    public function testIndexResultType()
    {

        // Add a public exhibit.
        $exhibit = $this->_exhibit(true);

        // Add a page to the exhibit.
        $page = $this->_exhibitPage($exhibit);

        // Get the Solr document for the page.
        $document = $this->_getRecordDocument($page);

        // Should index the URL.
        $this->assertEquals('Exhibit Pages', $document->resulttype);

    }


    /**
     * The title should be indexed.
     */
    public function testIndexTitle()
    {

        // Add a public exhibit.
        $exhibit = $this->_exhibit(true);

        // Add a page with a title.
        $page = $this->_exhibitPage($exhibit, 'title');

        // Get the Solr document for the page.
        $document = $this->_getRecordDocument($page);

        // Should index the URL.
        $this->assertEquals('title', $document->title);

    }


    /**
     * Text fields on child entries should be indexed.
     * @group pages
     */
    public function testIndexEntryText()
    {

        // Add a public exhibit.
        $exhibit = $this->_exhibit(true);

        // Add a page with a title.
        $page = $this->_exhibitPage($exhibit, 'title');

        // Add two entries.
        $entry1 = $this->_exhibitEntry($page, 'text1');
        $entry2 = $this->_exhibitEntry($page, 'text2');

        // Get the Solr document for the page.
        $document = $this->_getRecordDocument($page);

        // Get the name of the `text` Solr key.
        $textKey = $this->_getAddonSolrKey($page, 'text');

        // Should index the URL.
        $this->assertEquals(array('text1', 'text2'), $document->$textKey);

    }


}
