$('#promotions-promotion_type').on('change', function () {
    var promotionType = $(this).val();
    if (promotionType === 'direct') {
        $('#direct-fields').show();
        $('#conditional-fields').hide();
    } else if (promotionType === 'conditional') {
        $('#conditional-fields').show();
        $('#direct-fields').hide();
    } else {
        $('#direct-fields, #conditional-fields').hide();
    }
}).trigger('change');
