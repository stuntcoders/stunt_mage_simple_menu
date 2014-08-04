jQuery(document).ready(function($) {
    var options = {
        expandBtnHTML   : "",
        collapseBtnHTML : ""
    };

    $('.dd').nestable(options);

    $('#add-link').click(function() {
        $('#label-link').removeClass("validation-failed");
        $('#url-link').removeClass("validation-failed");
        $('.validation-advice').remove();

        var label = $('#label-link').val();
        var url = $('#url-link').val();

        if (label === '') {
            $('#label-link').addClass("validation-failed");
            $('#label-link').after('<div class="validation-advice"">This is a required field.</div>');
        }

        if (url === '') {
            $('#url-link').addClass("validation-failed");
            $('#url-link').after('<div class="validation-advice">This is a required field.</div>');
        }

        if (label !== '' && url !== '') {
            $('.dd > .dd-list').append(getLinkMenuItem(label, url));
            $('.dd').nestable(options);
            updateMenuValue();

            $('#label-link').val("");
            $('#url-link').val("");
        }
    });

    $('#add-category').click(function() {
        $('#label-category input:checkbox:checked').each(function () {
            $('.dd > .dd-list').append(getCategoryMenuItem($(this).closest("label").text(), $(this).val(), 0));
            // uncheck cbox after adding to list
            $(this).prop('checked', false);
        });
        $('.dd').nestable(options);
        updateMenuValue();
    });

    $('#add-cms').click(function() {
        $('#label-cms input:checkbox:checked').each(function () {
            $('.dd > .dd-list').append(getCmsMenuItem($(this).closest("label").text(), $(this).val()));
            // uncheck cbox after adding to list
            $(this).prop('checked', false);
        });
        $('.dd').nestable(options);
        updateMenuValue();
    });

    $('#add-special').click(function() {
        $('#label-special input:checkbox:checked').each(function () {
            $('.dd > .dd-list').append(getSpecialMenuItem($(this).closest("label").text(), $(this).val()));
            // uncheck cbox after adding to list
            $(this).prop('checked', false);
        });
        $('.dd').nestable(options);
        updateMenuValue();
    });

    $('.dd').on("click", ".dd-delete", function(e) {
        $(this).closest("li.dd-item").remove();

        e.preventDefault();
    });

    $('.dd').on("click", ".dd-edit", function(e) {
        var menuItem = $(this).closest(".dd-item");
        var hidden = menuItem.find(".dd-fields").first().is(":hidden");
        menuItem.find(".dd-fields").first().slideToggle(500);
        if(hidden) {
            // Set edit fields values to match items data values
            menuItem.find('.dd-field-label').first().val(menuItem.data("label"));

            if (menuItem.data("url")) {
                menuItem.find('.dd-field-url').first().val(menuItem.data("url"));
            }

            $(this).html(Translator.translate('Save'));
        } else {
            // Set items data values to match edit fields values
            menuItem.data("label", menuItem.find('.dd-field-label').first().val());
            if (menuItem.data("url")) {
                menuItem.data("url", menuItem.find('.dd-field-url').first().val());
            }
            // Update items text to match items label data
            menuItem.find(".dd-handle").first().html(menuItem.data("label"));
            $(this).html(Translator.translate('Edit'));
        }
        updateMenuValue();
        e.preventDefault();
    });

    $('.dd').on('change', function() {
        updateMenuValue()
    });

    function updateMenuValue() {
        var value = JSON.stringify($('.dd').nestable('serialize'));
        $('#menu-value').val(value);
    }

    function getLinkMenuItem(label, url) {
        var template = $("#menu-item-template-link").html();
        template = template.replace(new RegExp('{url}', 'g'), url);
        template = template.replace(new RegExp('{label}', 'g'), label);

        return template;
    }

    function getCmsMenuItem(label, id) {
        var template = $("#menu-item-template-cms").html();
        template = template.replace(new RegExp('{id}', 'g'), id);
        template = template.replace(new RegExp('{label}', 'g'), label);

        return template;
    }

    function getCategoryMenuItem(label, id, subcategories) {
        var template = $("#menu-item-template-category").html();
        template = template.replace(new RegExp('{id}', 'g'), id);
        template = template.replace(new RegExp('{label}', 'g'), label);
        template = template.replace(new RegExp('{subcategories}', 'g'), subcategories);

        return template;
    }

    function getSpecialMenuItem(label, id) {
        var template = $("#menu-item-template-special").html();
        template = template.replace(new RegExp('{id}', 'g'), id);
        template = template.replace(new RegExp('{label}', 'g'), label);

        return template;
    }
});