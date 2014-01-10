(function ( $ ) {

    function Prettify( options ) {

        var view = {

            defaults: {},

            init: function( options ) {
                $.extend( view.defaults, options );

                view.item = $( options.el );
                view.callback = options.callback || null;

                view._setEventHandlers();
                view._render();
            },

            activate: function() {
                view._setEventHandlers();
                view.label.show();
            },

            deactivate: function() {
                view.item.unbind( 'mouseenter blur change' );
                view.label.hide();
            },

            _setEventHandlers: function() {
                view.item.bind( "change", view._change );
                view.item.bind( "focus", view._focus );
                view.item.bind( "blur", view._blur );

                if( $( 'html' ).hasClass( 'lt-ie9' )) {
                    view.item.attr( 'data-width', view.item.outerWidth());
                    view.item.bind( 'mouseenter', view._mouseEnter );
                    view.item.bind( 'blur change', view._ieblur );
                }
            },

            _render: function() {
                view.item.wrap( "<label class='select prettify'></label>" );
                view.label = view.item.parent();

                var option = view.item.find( "option:selected" );
                var span =  $( "<span " + view._getClass( option ) + " data-val='" + option.val() + "'>" + option.text() + "</span>" );

                view.item.after( span );
                view.item.fadeTo( 0, 0 );
            },

            _change: function( event ) {
                var el = $(this);

                var option = el.find( "option:selected" );
                el.parent().find( "span" ).replaceWith( "<span " + view._getClass( option ) + " data-val='" + option.val() + "'>" + option.text() + "</span>" );

                if( _.isFunction( view.callback )) view.callback.apply( null, [ event, { url: option.attr( 'data-url' ) } ]);
            },

            _focus: function( event ) {
                view.label.addClass( "focus" );
            },

            _blur: function( event ) {
                view.label.removeClass( "focus" );
            },

            _mouseEnter: function( event ) {
                $( this ).css( 'width', 'auto' );
            },

            _ieblur: function( event ) {
                $( this ).css( 'width', $( this ).attr( 'data-width' ));
            },

            _getClass: function( option ) {
                return option.attr( 'class' ) !== undefined ? "class='" + option.attr( 'class' ) + "'" : "";
            }

        };

        view.init( options );

        return view;
    }

    $( 'select.prettify' ).each( function() { new Prettify({ el: this }); });

}( jQuery ));
