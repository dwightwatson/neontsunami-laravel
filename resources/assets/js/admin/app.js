import 'selectize';
import './bootstrap';
import Vue from 'vue';
import Rails from 'rails-ujs';
import { kebabCase } from 'lodash';
import 'bootstrap-sass/assets/javascripts/bootstrap';

Rails.start();

const app = new Vue({
  el: '#app',

  mounted() {
    if ($('input[name=slug]').length && $('input[name=title], input[name=name]').length) {
      $('input[name=title], input[name=name]').on('keyup', event => {
        const slug = kebabCase(event.target.value);

        $('input[name=slug]').val(slug);
      });
    }

    $('input[name=tags]').selectize({
      plugins: ['remove_button'],
      persist: false,
      preload: true,
      valueField: 'name',
      labelField: 'name',
      searchField: 'name',
      async create(input, callback) {
        const response = await $.post('/admin/tags', { name: input });
        callback({ 'value': response.name, 'text': response.name });
      },
      async load(query, callback) {
        const response = await $.getJSON('/admin/tags', { q: query });
        callback(response);
      }
    });

    $('select[name=series_id]').selectize();
  }
});
