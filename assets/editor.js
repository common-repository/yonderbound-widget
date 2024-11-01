;(function() {

  function smallCoverUrlFromOriginalUrl(url) {
    var a = document.createElement('a');
    a.href = url;
    a.search = "?ixlib=rails-1.0.0&w=60&h=38&fit=crop&crop=entropy&s=41e4f40fdd8c66ad77883f9d0b8985e5";
    return a.href;
  }

  tinymce.PluginManager.add('yonderboundshortcode', function(editor) {
    editor.addButton('yonderboundshortcode', {
      text: false,
      icon: 'yonderbound-icon',
      onclick: function() {
        editor.windowManager.open({
          width: 600,
          height: 100,
          title: 'Yonderbound Widget shortcode generator',
          body: [{
            type   : 'container',
            label  : 'Search helper (only for activities)',
            html   : '<input id="search-input" type="text" />'
          }, {
            type   : 'container',
            label  : 'Paste activity or hotel URL',
            html   : '<input id="yo-href" type="text" />'
          }],
          onsubmit: function(e) {
            var href_input = document.getElementById("yo-href");
            if (/(https:\/\/)?(www.)?yonderbound.com.*\/(activities|hotels)\//.test(href_input.value)) {
              tinyMCE.activeEditor.selection.setContent('[yo-widget href="' + href_input.value + '"]');
            } else {
              tinyMCE.activeEditor.windowManager.alert('You can only enter an activity or hotel url');
              return false;
            }
          }
        });
        var client = algoliasearch('CB9WV62MNX', '58e2695c7640fba9b958e85c9e072c17')
        var index = client.initIndex('BookableActivity');
        autocomplete('#search-input', { hint: false }, [{
          source: autocomplete.sources.hits(index, { hitsPerPage: 5 }),
          displayKey: 'title',
          templates: {
            suggestion: function(suggestion) {
              return "<div class='yo-sugg'><div class='yo-sugg-left'><img class='yo-sugg-object' src='" + smallCoverUrlFromOriginalUrl(suggestion.cover_image) + "' /></div><div class='yo-sugg-body'><p>&nbsp;" + suggestion.title + "</p></div></div>";
            }
          }
        }]).on('autocomplete:selected', function(event, suggestion, dataset) {
          document.getElementById("yo-href").value = "http://yonderbound.com/activities/" + suggestion.slug;
        });
      }
    });
  });
})();
