
jQuery(document).ready(function($) {

    openUserModal($);
    jqueryPlugins($);
    maesterTabs($);
    openSearchPopup($);

});

/**
 * User Modal - Since: 1.0.0
 * @param $
 */
function openUserModal($) {
    $('a[href="#open_user_modal"]').on('click', function(e) {
        e.preventDefault();
        $('#open-user-modal').fadeIn();
    });
    $('.user-modal-overlay').on('click', function () {
        $('#open-user-modal').fadeOut();
    });
    $(document).keyup(function(e) {
        if (e.key === "Escape") {
            $('#open-user-modal').fadeOut();
        }
    });
}

function openSearchPopup($){
    $searchForm = $('#maester-popup-search-form');
    $('a[href="#open_search_popup"]').on('click', function(e) {
        e.preventDefault();
        $searchForm.fadeIn();
    });

    $('.maester-popup-search-overlay').on('click', function () {
        $searchForm.fadeOut();
    });


    $(document).keyup(function(e) {
        if (e.key === "Escape") {
            $('#maester-popup-search-form').fadeOut();
        }
    });
}

/**
 * Custom Tabs - Since 1.0.0
 * @param $
 */

function maesterTabs($) {
    $('.maester-tabs').each(function () {
        $that = $(this);
        $tab_link = $that.find('.tab-link');
        $tab_content = $that.find('.tab-content');
        $tab_link.on('click', function (e) {
            e.preventDefault();
            $tab_link.add($tab_content).removeClass('active');
            $that.find(".tab-link[data-tab='"+ $(this).data('tab') +"']").add($that.find('.' + $(this).data('tab'))).addClass('active');
        });
    });
}

/**
 * Active All jQuery Plugins - Since: 1.0.0
 * @param $
 */
function jqueryPlugins($) {
    if($.fn.niceSelect()){
        $('select').niceSelect();
    }
}


