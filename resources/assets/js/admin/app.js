(function($) {
  if ($('input[name=slug]').length && $('input[name=title], input[name=name]').length) {
    $('input[name=title], input[name=name]').on('keyup', function() {
      var slug = $(this).val()
        .toLowerCase()
        .replace(/[^\w ]+/g,'')
        .replace(/ +/g,'-');

      $('input[name=slug]').val(slug);
    });
  }

  $('input[name=tags]').selectize({
    plugins: ['remove_button'],
    persist: false,
    valueField: 'name',
    labelField: 'name',
    searchField: 'name',
    create: function(input) {
      return {
        value: input,
        text: input
      };
    },
    load: function(query, callback) {
      $.getJSON('/admin/tags', { q: query }, function(response) {
        callback(response);
      });
    }
  });

  $('select[name=series_id]').selectize();
})(jQuery);
