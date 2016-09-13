import './bootstrap';
import './shards';
import autocomplete from 'autocomplete.js'
import algoliasearch from 'algoliasearch';

(function($) {
  $('.shards').shards([239, 84, 17, 0.5], [245, 153, 113, 0.5], [255, 255, 255, 0.5], 1, 1, 1, 1, false);

  const client = algoliasearch('0OG014ESJC', '3df2cabb4a669248096f9f44ca4251a8');
  const index = client.initIndex('posts');

  let search = autocomplete('.algolia input', { hint: true }, [{
    source: autocomplete.sources.hits(index, { hitsPerPage: 5 }),
    displayKey: 'title',
    templates: {
      suggestion: function(suggestion) {
        return suggestion._highlightResult.title.value;
      }
    }
  }])

  search.on('autocomplete:selected', function (event, suggestion, dataset) {
    window.location = '/posts/' + suggestion.slug;
  });
})(jQuery);
