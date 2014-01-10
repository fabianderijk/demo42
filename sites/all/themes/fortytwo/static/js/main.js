(function ( $, Drupal, window, document, undefined ) {

    /** @namespace */
    Drupal.behaviors.app = {
        /** @constructor 
         *
         * @param context
         * @param settings
         */
        attach: function ( context, settings ) {
            // Transit.js will fallback to frame based animation when transitions aren't supported
            if( !$('html').hasClass( 'csstransitions' ) ) $.fn.transition = $.fn.animate;

            // Check if the responsive layout is used and store it.
            this.constants.RESPONSIVE = $( "body" ).hasClass( 'responsive' );

            if( this.constants.RESPONSIVE ) {
                enquire.register( this.constants.MQ_MOBILE, {
                    match: function() {
                        $( ".column.sidebar.first" ).insertBefore( ".content.column" );
                    },
                    unmatch: function() {
                        $( ".column.sidebar.first" ).insertAfter( ".content.column" );
                    }
                });

            }

        },

        /** @property {object} constants                    - Holds global constants.
         * @property {constant}  constants.MQ_DESKTOP       - media query for desktop
         * @property {constant}  constants.MQ_TABLET        - media query for tablet
         * @property {constant}  constants.MQ_MOBILE        - media query for mobile
         * @property {constant}  constants.MQ_DESKTOPTABLET - media query for desktop & tablet
         * @property {constant}  constants.MQ_MOBILETABLET  - media query for mobile & tablet
         */
        constants : {
            MQ_DESKTOP: 'all and (min-width: 1248px)',
            MQ_TABLET: 'all and (min-width: 768px) and (max-width: 1247px)',
            MQ_MOBILE: 'all and (min-width: 0px) and (max-width: 767px)',
            MQ_DESKTOPTABLET: 'all and (min-width: 768px)',
            MQ_MOBILETABLET: 'all and (min-width: 0px) and (max-width: 1247px)',

            RESPONSIVE: false
        }
    };

})(jQuery, Drupal, this, this.document);
