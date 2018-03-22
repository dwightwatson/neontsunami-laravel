import Vue from 'vue';
import highlight from 'highlight.js';
import Autocomplete from './components/Autocomplete.vue';


const app = new Vue({
  el: '#app',

  components: {
    Autocomplete
  },

  mounted() {
    highlight.initHighlighting();
  }
});
