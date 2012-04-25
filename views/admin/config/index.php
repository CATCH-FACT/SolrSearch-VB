<?php queue_js('accordion'); ?>

<?php head(array(
  'title' => 'Solr Search Configuration',
  'bodyclass' => 'primary',
  'content_class' => 'horizontal-nav')
); ?>

<h1>Configure SolrSearch Indexing</h1>

<ul id="section-nav" class="navigation">
    <li class="current">
        <a href="<?php echo html_escape(uri('solr-search/config/')); ?>">Field Configuration</a>
    </li>
    <li class="">
        <a href="<?php echo html_escape(uri('solr-search/highlight/')); ?>">Hit Highlighting Options</a>
    </li>
    <li class="">
        <a href="<?php echo html_escape(uri('solr-search/reindex/')); ?>">Index Items</a>
    </li>
</ul>

<div id="primary">

    <h2>Select Facet Fields</h2>
    <?php echo flash(); ?>
    <?php if (!empty($err)) { echo '<p class="error">' . html_escape($err) . '</p>'; } ?>

    <form id="facets-form" method="post">
    <table>
      <thead>
        <tr>
        <?php browse_headings(array(
          'Field' => null,
          'Is Displayed' => null,
          'Is Facet' => null,
          'Is Visible' => null
        )); ?>
        </tr>
      </thead>
    </table>

        <?php foreach ($form->getDisplayGroups() as $group): ?>

          <h3 class="fieldset"><a href="#"><?php echo $group->getLegend(); ?></a></h3>
          <div>
          <?php foreach ($group->getElements() as $element): ?>
            <table>
            <tr>
              <td class="element"><?php echo $element->getLabel(); ?></td>
              <?php foreach ($element->getMultiOptions() as $name => $label): ?>
                <td><input type="checkbox" name="<?php echo $element->getName(); ?>[]" value="<?php echo $name; ?>" <?php if (in_array($name, $form->getValue($element->getName()))) { echo 'checked="checked"'; } ?>/></td>
              <?php endforeach; ?>
            </tr>
            </table>
          <?php endforeach; ?>
          </div>

        <?php endforeach; ?>

    </table>
    <?php echo $form->getElement('submit'); ?>
    </form></div>

<?php foot(); ?>
