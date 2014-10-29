jQuery(document).ready(function($) {
    var options = {
        expandBtnHTML   : "",
        collapseBtnHTML : ""
    };

    $('.dd').nestable(options);
    updateMenuValue();

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
            var data = {
                type: 1,
                label: label,
                url: url
            };

            var el = $(getLinkMenuItem(data.label));
            addElement(el, data);

            $('.dd').nestable(options);
            updateMenuValue();

            $('#label-link').val("");
            $('#url-link').val("");
        }
    });

    $('#add-category').click(function() {
        $('#label-category input:checkbox:checked').each(function () {
            var data = {
                type: 2,
                label: $(this).closest("label").text(),
                subcategories: "0",
                id: $(this).val()
            };
            var el = $(getCategoryMenuItem(data.label));
            $(this).prop('checked', false);

            addElement(el, data);
        });
        $('.dd').nestable(options);
        updateMenuValue();
    });

    $('#add-cms').click(function() {
        $('#label-cms input:checkbox:checked').each(function () {
            var data = {
                type: 3,
                label: $(this).closest("label").text(),
                id: $(this).val()
            };

            var el = $(getCmsMenuItem(data.label));
            $(this).prop('checked', false);

            addElement(el, data);
        });
        $('.dd').nestable(options);
        updateMenuValue();
    });

    $('#add-special').click(function() {
        $('#label-special input:checkbox:checked').each(function () {
            var data = {
                type: 4,
                label: $(this).closest("label").text(),
                typename: $(this).closest("label").text(),
                id: $(this).val()
            };

            var el = $(getSpecialMenuItem(data.label));
            $(this).prop('checked', false);

            addElement(el, data);
        });
        $('.dd').nestable(options);
        updateMenuValue();
    });

    $('.dd').on("click", ".dd-delete", function(e) {
        $(this).closest("li.dd-item").remove();

        updateMenuValue();
        e.preventDefault();
    });

    $('.dd').on("click", ".dd-edit", function(e) {
        var menuItem = $(this).closest(".dd-item");
        var hidden = menuItem.find(".dd-fields").first().is(":hidden");
        menuItem.find(".dd-fields").first().slideToggle(500);
        if(hidden) {
            // Set edit fields values to match items data values
            menuItem.find('.dd-field-label').first().val(menuItem.data("label"));
            menuItem.find('.dd-field-url').first().val(menuItem.data("url"));
            menuItem.find('.dd-field-subcategories').first().val(menuItem.data("subcategories"));

            menuItem.find('.dd-field-id').first().html(menuItem.data("id"));
            menuItem.find('.dd-field-typename').first().html(menuItem.data("typename"));
            $(this).html(Translator.translate('Save'));
        } else {
            // Set items data values to match edit fields values
            menuItem.data("label", menuItem.find('.dd-field-label').first().val());
            menuItem.data("url", menuItem.find('.dd-field-url').first().val());
            menuItem.data("subcategories", menuItem.find('.dd-field-subcategories').first().val());

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
        $('#simplemenu-value').val(value);
    }

    function addElement(element, data)
    {
        $('.dd > .dd-list').append(element);
        element.data(data);
    }

    function getCmsMenuItem(label, id) {
        return getTemplate(label, "#menu-item-template-fields-cms");
    }

    function getSpecialMenuItem(label, id) {
        return getTemplate(label, "#menu-item-template-fields-special");
    }

    function getLinkMenuItem(label) {
        return getTemplate(label, "#menu-item-template-fields-link");
    }

    function getCategoryMenuItem(label) {
        return getTemplate(label, "#menu-item-template-fields-category");
    }

    function getTemplate(label, fieldsId)
    {
        var template = $("#menu-item-template").html();
        var fields = $(fieldsId).html();
        template = template.replace(new RegExp('{label}', 'g'), label);
        template = template.replace(new RegExp('{fields}', 'g'), fields);

        return template;
    }
});
