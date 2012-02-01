<?php
/**
 * Created by JetBrains PhpStorm.
 * User: jsrawan
 * Date: 1/31/12
 * Time: 1:34 AM
 * To change this template use File | Settings | File Templates.
 */
?>

<script type="text/javascript" src="/parts/jquery.jqGrid.min.js"></script>

<script type="text/javascript">
jQuery.fn.dataTableExt.oApi.fnSetFilteringDelay = function ( oSettings, iDelay ) {

    var
        _that = this,
        iDelay = (typeof iDelay == 'undefined') ? 250 : iDelay;

    this.each( function ( i ) {
        $.fn.dataTableExt.iApiIndex = i;
        var
            $this = this,
            oTimerId = null,
            sPreviousSearch = null,
            anControl = $( 'input', _that.fnSettings().aanFeatures.f );

            anControl.unbind( 'keyup' ).bind( 'keyup', function() {
            var $$this = $this;

            if (sPreviousSearch === null || sPreviousSearch != anControl.val()) {
                window.clearTimeout(oTimerId);
                sPreviousSearch = anControl.val();
                oTimerId = window.setTimeout(function() {
                    $.fn.dataTableExt.iApiIndex = i;
                    _that.fnFilter( anControl.val() );
                }, iDelay);
            }
        });

        return this;
    } );
    return this;
}

$(document).ready(function() {
    table = $('#foosballColl').dataTable( {
        "bProcessing": true,
        "bServerSide": true,
        "bSortClasses": false,
        "sDom": 'trfilp',
        "sPaginationType" : "full_numbers"
        //"sAjaxSource": "/api/getAllCampaigns.php"

    } );

    // Aviod table refresh while typing in the search box
    table.fnSetFilteringDelay(1000);

    // Make the number column non sortable
    var oSettings = table.fnSettings();
    oSettings.aoColumns[0].bSortable = false;
} );


</script>
 
