<template>
  <div class="algolia">
    <input ref="input" type="text" class="form-control" placeholder="Search...">

    <a href="https://www.algolia.com">
      <img :src="algoliaLogo" title="Search powered by Algolia">
    </a>
  </div>
</template>

<script>
import autocomplete from 'autocomplete.js'
import algoliasearch from 'algoliasearch';

export default {
  props: ['algoliaLogo'],

  mounted() {
    const client = algoliasearch('0OG014ESJC', '3df2cabb4a669248096f9f44ca4251a8');
    const index = client.initIndex('posts');

    let search = autocomplete(this.$refs.input, { hint: true }, [{
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
  }
}
</script>
