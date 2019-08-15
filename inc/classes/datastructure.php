<?php
//require_once( ROOTPATH . '/inc/config.php' );
class DataStructure
{
    private $lastError;
    public function getLastError()
    {
        return $this->lastError;
    }

    private function getConn()
    {
        $temp = sprintf( "DRIVER={%s};HOST=%s;PORT=%s;DB=%s;%s;",
					ODBC_DRIVER, ODBC_SERVER, ODBC_PORTNO, ODBC_DBASE, ODBC_EXTRAS );
        return odbc_connect( $temp, ODBC_USER, ODBC_PASSWD );
    } // END getConn

    public function getTables()
    {
        $conn = $this->getConn();
        if ( $conn === false ) {
            $this->lastError = 'Connection NOT Established!';
            return false;
        }
        //$tbls = [];
        $rs   = odbc_tables( $conn );
        while (odbc_fetch_row( $rs ))
        {
            $type = odbc_result( $rs, "TABLE_TYPE");
            // preg_match ?
            if (("TABLE" === $type || "VIEW" === $type))
            {
                $name = odbc_result($rs, "TABLE_NAME");
                if (strncasecmp( $name, "SYS", 3 ) !== 0)
                {
                    $schema = odbc_result($rs, "TABLE_SCHEM");
                    //$tbls[] = $name;
                    yield '"' . $schema . '"."' . $name . '"';
                }
            }
        }
        //return $tbls;
        //return true;
    } // END getTables

    public function getColumns( string $tableName )
    {
        $conn = $this->getConn();
        if ( $conn === false ) {
            $this->lastError = 'Connection NOT Established!';
            return false;
        }
        $schema = "";
        $table  = "";
        $index  = strpos( $tableName, "." );
        if ($index !== false) {
            $schema = str_replace( '"', '', substr( $tableName, 0, $index ));
            $table  = str_replace( '"', '', substr( $tableName, $index + 1 ));
        } else {
            $table  = str_replace( '"', '', $tableName );
        }
        $rs = odbc_columns ( $conn, ODBC_DBASE, $schema, $table ); //, string $column_name );
        if ( $rs === false ) {
            $this->lastError = 'Table (' . $tableName . ') NOT Found!';
            return false;
        }
        // echo '<h3>Columns for: (',
        //     htmlspecialchars( $schema ), ')(',
        //     htmlspecialchars( $table ), ')...</h3>';
        // echo '<table><tr><th>Column</th><th>Type</th></tr>';
        while (odbc_fetch_row( $rs ))
        {
            // presents all fields of the array $pages in a new line
            // until the array pointer reaches the end of array data
            yield [
                'column' => odbc_result( $rs, 'COLUMN_NAME' ),
                'type'   => odbc_result( $rs, 'TYPE_NAME' ),
                'length' => odbc_result( $rs, 'TYPE_LENGTH' ),
            ];
            // echo '<tr><td>',
            //     htmlspecialchars(odbc_result( $rs, 'COLUMN_NAME' )),
            //     '</td><td>',
            //     htmlspecialchars(odbc_result( $rs, 'TYPE_NAME' )),
            //     '</td></tr>';
        }
        echo '</table>';
    } // END getColumns
}
