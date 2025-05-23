
// load when ready
jQuery(function($) {

    var Better_Icon_Modal = $('#better-icon-modal').remodal({
        hashTracking: false,
        closeOnEscape: true
    });

    $(document).on( 'click', '.bf-icon-modal-handler', function(e){

        e.preventDefault();

        var $field_container = $(this),
            $input = $field_container.find( 'input.icon-input'),
            $modal = $( '#better-icon-modal'),
            $search_input = $modal.find('input.better-icons-search-input');

        // Summarize data
        var selected = {
            id:     $input.attr('value'),
            label:  $input.data('label')
        };

        $modal.find( '.icons-list .icon-select-option[data-value="' + selected.id + '"]').addClass( 'selected' );

        Better_Icon_Modal.$handler = $(this);

        icons_modal_reset_all_filters();

        Better_Icon_Modal.open();

        $search_input.focus();


    });


    $(document).on('closing', '.better-modal.icon-modal', function ( e ) {

        // No icon selected
        if( $(this).find('.icons-list .icon-select-option.selected').length == 0 ){
            return;
        }

        var $field_container = Better_Icon_Modal.$handler,
            $selected_container = $field_container.find( '.selected-option' ),
            $input = $field_container.find( 'input.icon-input' );

        // Summarize data
        var selected = {
            id:     $(this).find('.icons-list .icon-select-option.selected').data('value'),
            label:  $(this).find('.icons-list .icon-select-option.selected').data('label')
        };

        // Update view data
        if( selected.id != '' ){
            $selected_container.html( '<i class="bf-icon fa ' + selected.id + '"></i>' + selected.label );
        }else{
            $selected_container.html( selected.label );
        }

        // Update field data
        $input.val( selected.id );
        $input.attr( 'label', selected.label );

        $(this).find('.icon-select-option.selected').removeClass('selected');

    });

    $(document).on('click', '.better-modal.icon-modal .icons-list .icon-select-option', function () {

        $(this).closest('.icons-list').find('.icon-select-option.selected').removeClass('selected');

        $(this).toggleClass('selected');

        Better_Icon_Modal.close();
    });

    $('.better-modal.icon-modal .icons-container').mCustomScrollbar({
        theme: 'dark',
        live: true
    });


    // Category Filter
    $(document).on('click', '.better-icons-category-list .icon-category' ,function(){

        var $this = $(this),
            $modal = $( '#better-icon-modal'),
            $options_list = $modal.find('.icons-list'),
            $search_input = $modal.find('input.better-icons-search-input');

        if( $this.hasClass('selected') ){
            return;
        }

        // clear search input
        $search_input.val('').parent().removeClass('show-clean').find('.clean').addClass('fa-search').removeClass('fa-times-circle');

        $modal.find('.better-icons-category-list li.selected').removeClass('selected');

        $this.addClass('selected');

        if( $this.attr('id') === 'cat-all' ){

            $options_list.find('li').show();

        }else{

            $options_list.find('li').each(function(){

                if($(this).hasClass('default-option'))
                    return true;

                var _cats = $(this).data('categories').split(' ');

                if( _cats.indexOf($this.attr('id')) < 0){
                    $(this).hide();
                }else{
                    $(this).show();
                }

            });

        }
        return false;

    });


    // Search
    $(document).on( 'keyup', '#better-icon-modal .better-icons-search-input' ,function(){

        if( $(this).val() != '' ){
            $(this).parent().addClass('show-clean').find('.clean').removeClass('fa-search').addClass('fa-times-circle');
        }else{
            $(this).parent().removeClass('show-clean').find('.clean').addClass('fa-search').removeClass('fa-times-circle');
        }

        icons_modal_reset_cats_filter();

        icons_modal_text_filter( $(this).val() );

        return false;

    });


    $(document).on('click', '#better-icon-modal .better-icons-search .clean' ,function() {

        var $modal = $( '#better-icon-modal'),
            $search_input = $modal.find('input.better-icons-search-input');

        icons_modal_text_filter( '' );

        $search_input.val('').parent().removeClass('show-clean').find('.clean').addClass('fa-search').removeClass('fa-times-circle');

    });


        // Used for clearing all filters
    function icons_modal_reset_all_filters(){

        var $modal = $( '#better-icon-modal'),
            $search_input = $modal.find('input.better-icons-search-input');

        $search_input.val('').parent().removeClass('show-clean').find('.clean').addClass('fa-search').removeClass('fa-times-circle');

        icons_modal_text_filter( '' );

        icons_modal_reset_cats_filter();
    }


    // Used for clearing just category filter
    function icons_modal_reset_cats_filter(){

        var $modal = $( '#better-icon-modal'),
            $options_list = $modal.find('.icons-list');

        $options_list.find('.icon-select-option').show();

        $modal.find('.better-icons-category-list li').removeClass('selected');
        $modal.find('.better-icons-category-list li#cat-all').addClass('selected');
    }


    // filters element with one text
    function icons_modal_text_filter( $search_text ){

        var $modal = $( '#better-icon-modal'),
            $options_list = $modal.find('.icons-list');

        if( $search_text ){
            $options_list.find(".label:not(:Contains(" + $search_text + "))").parent().hide();
            $options_list.find(".label:Contains(" + $search_text + ")").parent().show();
        } else {
            $options_list.find("li").show();
        }

    }
});


// res : http://stackoverflow.com/questions/1766299/make-search-input-to-filter-through-list-jquery
// custom css expression for a case-insensitive contains()
(function($) {
    jQuery.expr[':'].Contains = function(a,i,m){
        return (a.textContent || a.innerText || "").toUpperCase().indexOf(m[3].toUpperCase())>=0;
    };
})(jQuery);
