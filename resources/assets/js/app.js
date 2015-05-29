(function($) {
    if ($('input[name=name]').length && $('input[name=slug]').length) {
        $('input[name=name]').on('keyup', function() {
            var slug = $('input[name=name]').val()
                    .toLowerCase()
                    .replace(/[^\w ]+/g,'')
                    .replace(/ +/g,'-');

            $('input[name=slug]').val(slug);
        });
    }

    $('input[name=tags]').selectize({
        plugins: ['remove_button'],
        persist: false,
        create: function(input) {
          return {
            value: input,
            text: input
          };
        }
    });

    $('select[name=series_id]').selectize();
})(jQuery);