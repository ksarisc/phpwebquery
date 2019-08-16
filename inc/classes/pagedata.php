<?php
class PageData
{
    private $templateFile;
    private $pageType;

    public function __construct()
    {
        $temp = ROOTPATH . '/templates/index.php';
        if (isset( $_GET['p'] )) {
            $temp = ROOTPATH . '/templates/pages/'
                . $_GET['p'] . '.php';
        }
        $this->pageType = 0;
        if (isset( $_GET['t'] )) {
            if ($_GET['t'] === 'json') {
                $this->pageType = 1;
            } else if ($_GET['t'] === 'xml') {
                $this->pageType = 2;
            }
        }
        if (!file_exists( $temp )) {
            $temp = ROOTPATH . '/templates/404.php';
            $this->pageType = 0;
        }
        $this->templateFile = $temp;
    } // END construct

    public function renderTemplate()
    {
        require_once( $this->templateFile );
        switch ($this->pageType)
        {
            case 0:
                require_once( ROOTPATH . '/templates/html.php' );
                break;
            case 1:
                require_once( ROOTPATH . '/templates/json.php' );
                break;
            case 2:
                require_once( ROOTPATH . '/templates/xml.php' );
                break;
            default:
                require_once( ROOTPATH . '/templates/html.php' );
                break;
        }
    } // END renderTemplate

    public function title()
    {
        if (defined( 'PAGE_TITLE' )) {
            return PAGE_TITLE;
        }
        return 'PHP Web Query';
    } // END title

    public function body()
    {
        if (function_exists( 'pageBody' )) {
            pageBody( $this );
        }
        //$this->runQuery();
    } // END body

    public function query()
    {
        // get json query definition
        if (defined( 'QUERY_DEFINITION' )) {
        } else if (isset( $queryDefinition )) {
        }
        // build the query (if exists)
    } // END query
}
