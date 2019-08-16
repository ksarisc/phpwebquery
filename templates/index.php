<?php
define( 'PAGE_TITLE', 'PHP Web Query - Home' );

function pageBody( $page )
{
?>
<div id="tablesList">
    <ul>
    <?php
    $data = new DataStructure();
    foreach ($data.getTables() as $table) {
        echo '<li onclick="selectTable(this);">',
            htmlspecialchars( $table ),
            '</li>';
    }
    $data = null;
    ?>
    </ul>
</div>
<div id="queryBuilder">
    <textarea id="queryBuilderText" size="8"></textarea>
</div>
<div id="queryResults">
    <iframe id="queryResultsFrame" src="">
        <p>Sorry: Your browser does NOT support iFrames!</p>
    </iframe>
</div>
<?php
} // END pageBody
