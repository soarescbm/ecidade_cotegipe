;(function($, global) {

  var KEY_ENTER = 13;
  var KEY_ESC = 27;
  var KEY_DOWN = 40;
  var KEY_UP = 38;
  var KEY_BACKSPACE = 8;
  var KEY_SPACE = 32;
  var KEY_DELETE = 46;

  var containerLoader = $('<div />', {'class': 'menu-search-loading'});

  var MenuSearch = function(input) {

    this.input = input;

    var options = {
      delay : 500,
      instit : null,
      onSelect : this.onSelect,
      uri: '',
      background : !(typeof Worker == 'undefined'),
      containerBounds: $()
    };

    this.options = function(option, value) {

      // invalid
      if (!option)
        return;

      // merge
      if (typeof option == 'object')
        return options = $.extend(options, option);

      // get
      if (typeof option == 'string' && typeof value == 'undefined')
        return options[option];

      // set
      return options[option] = value;
    }

  }

  MenuSearch.build = function(input) {

    var search = new MenuSearch(input);
    search.container = $('<div>', {class : 'menu-search-results'});

    input.after(search.container);
    input.on('keydown', keydown);

    return search;
  }

  MenuSearch.prototype = {

    input : null,
    container: null,

    /**
     * Total de nodes(li)
     */
    nodesLength : 0,

    /**
     * Total de nodes(li) visiveis
     */
    nodesView : 0,

    /**
     * index do node(li) selecionado atual
     */
    nodesCurrentViewIndex : 0,

    /**
     * index do ultimo node(li) selecionado
     */
    nodesLastIndex : 0,

    request : false,
    timeout : false,

    execute : function(delay) {

      /**
       * Cancela timeout anterior
       */
      if (this.timeout) {
        clearTimeout(this.timeout);
      }

      var _this = this;
      delay = typeof delay != 'undefined' ? delay : this.options('delay');

      if (delay > 0 && this.options('background')) {
        delay = 100;
      }

      this.timeout = setTimeout(function() {

        if (!$.trim(_this.input.val())) {
          return false;
        }

        _this.input.on('mousedownoutside', outside);

        if (!_this.options('instit')) {

          _this.container.empty().text('Instituição não selecionada.').show();
          return false;
        }

        if (!_this.container.is(":visible")) {
          _this.container.empty().append(containerLoader);
        }

        _this.container.show();
        _this.sendRequest();

      }, delay);
    },

    sendMessage : function() {

      if (this.background) {
        this.background.postMessage('abort');
      }

      if (!this.background)  {
        var _matchsHandler = matchsHandler.bind(this);
        this.background = new Worker(this.options('uri') + 'assets/vendors/jquery.menu-search/menu-search-worker.js');
        this.background.addEventListener('message', function(event) {
          _matchsHandler(event.data);
        }, false);
      }

      this.background.postMessage({
        term : this.input.val(),
        url: this.options('uri') + 'menu/getEstruturaMenu?instit='+ this.options('instit')
      });
    },

    sendRequest : function() {

      if (this.options('background')) {
        return this.sendMessage();
      }

      /**
       * Aborta conexao anterior
       */
      if (this.request && this.request.readystate != 4) {
        this.request.abort();
      }

      this.request = $.ajax({
        url: this.options('uri') + 'menu/search/',
        data: {term: this.input.val(), instit : this.options('instit')},
        dataType: 'JSON',
        type: 'GET',
        success: matchsHandler.bind(this)
      });
    },

    moveSelection : function(key) {

      var selectedNode = this.container.find('li.selected');
      var newSelectedNode = null;

      if (key === KEY_DOWN) {
        newSelectedNode = selectedNode.next();
      }

      if (key === KEY_UP) {
        newSelectedNode = selectedNode.prev();
      }

      if (newSelectedNode.length == 0) {
        return false;
      }

      var nodesView = this.nodesView - 1;
      var index = newSelectedNode.index();
      var padding = index + 1;
      var total = this.nodesLength;
      var scrollTop = false;

      var nodesCurrentViewIndex = this.nodesCurrentViewIndex + (index - this.nodesLastIndex);

      if (nodesCurrentViewIndex >= 0 && nodesCurrentViewIndex <= nodesView) {
        this.nodesCurrentViewIndex = nodesCurrentViewIndex;
      }

      this.nodesLastIndex = index;

      if (this.nodesCurrentViewIndex === nodesView && index !== this.nodesCurrentViewIndex) {
        scrollTop = newSelectedNode.height() * (index > nodesView ? index - nodesView : 1) + padding;
      }

      if (this.nodesCurrentViewIndex === 0) {
        scrollTop = (newSelectedNode.height() * (index - nodesView) + padding) + newSelectedNode.height() * nodesView;
      }

      if (scrollTop) {

        this.container.scrollTop(scrollTop);
        this.container.scrollator('refresh');
      }

      this.toogleSelection(newSelectedNode, selectedNode);
    },

    toogleSelection : function(newSelectedNode, selectedNode) {

      selectedNode = selectedNode || this.container.find('li.selected');
      selectedNode.removeClass('selected');
      newSelectedNode.addClass('selected');
    },

    select : function(e) {
      if (typeof this.options('onSelect') == 'function') {
        return this.options('onSelect').call(this, e, this.container.find('li.selected'));
      }
    },

    onSelect: function(e, selected) {
      e.preventDefault();

      this.input.val(selected.text())
      this.container.hide()
    }

  }

  function matchsHandler(matchs) {

    var _this = this;
    var ul = $('<ul>');
    this.container.empty().append(ul);

    if (matchs.length == 0) {
      return this.container.append($('<li>').html('Nenhum registro encontrado'));
    }

    $.each(matchs, function(indice, match) {

      var li = $('<li>');

      if (indice == 0) {
        li.addClass('selected');
      }

      li.html(match.highlight);
      li.data('context', match.context);
      ul.append(li);
    });

    ul.find('li').on('click', function(event) {
      _this.select(event);
    });

    ul.find('li').on('mousemove', function(event) {
      _this.toogleSelection($(this));
    });

    var menu = $('#menu');
    var zIndex = menu.css('zIndex') + 1;
    var height = menu.height() - this.options('containerBounds').height();
    this.container.css('maxHeight', height);
    this.container.scrollator({zIndex: zIndex});
    this.container.scrollator('refresh');
    this.container.scrollTop(0);

    var liHeigth = this.container.find('li:first').height();
    this.nodesLength = matchs.length;
    this.nodesCurrentViewIndex = 0;
    this.nodesLastIndex = 0;
    this.nodesView = Math.floor(this.container.height() / liHeigth);
  }

  function keydown(event) {

    var keyCode = getKeyCode(event);

    if (keyCode == KEY_ENTER) {

      event.preventDefault();

      if (!this.search.container.is(":visible")) {
        return this.search.execute(0);
      }

      if (this.search.container.find('li.selected').length > 0) {
        return this.search.select(event);
      }
    }

    if (keyCode == KEY_ESC) {

      this.search.container.hide();
      this.search.input.val('');
      return false;
    }

    if (keyCode == KEY_DOWN || keyCode == KEY_UP) {
      return this.search.moveSelection(keyCode);
    }

    if (isAlphanumeric(String.fromCharCode(keyCode)) || keyCode == KEY_BACKSPACE || keyCode == KEY_SPACE || keyCode == KEY_DELETE) {
      this.search.execute();
    }
  }

  function getKeyCode(event) {
    event = event || window.event;
    return event.which || event.keyCode;
  }

  function isAlphanumeric(value) {
    return /[a-z0-9]/i.test(value);
  }

  function outside(event, target) {

    if (target) {
      var target = $(target);

      if ( target.closest(this.search.container).length > 0 || target.is(this.search.input) ) {
        return;
      }

      if (target.closest('.scrollator_lane_holder').length > 0) {
        return;
      }
    }

    $(this).off('mousedownoutside');
    this.search.container.hide();
  }

  /**
   * Cria o plugin
   * @param mixed options
   * @param mixed value
   */
  $.fn.menuSearch = function(options, value) {

    /**
     * get option
     */
    if (this.length == 1 && this.get(0).search && typeof option == 'string' && typeof value == 'undefined') {
      return this.get(0).search.options(options);
    }

    this.each(function(index, input) {

      if (!input.search) {
        input.search = MenuSearch.build($(this));
      }

      input.search.options(options, value);
    });

    return this;
  }

})(jQuery, this);
