(function (exports) {

  var ProgressBar = function (bar, logs) {

    var oPercentual = $('log-percentual');

    function updateProgress(iValue) {

      bar.value = iValue;

      if (!oPercentual) {

        oPercentual = document.createElement('span');
        oPercentual.id = 'log-percentual';
        logMessage('Progresso: ', oPercentual);
      }

      var nPercentual = new Number(iValue * 100 / bar.max);
      oPercentual.textContent = nPercentual.toFixed(2) + "%";

      if (nPercentual == 100) {
        oPercentual.id = '';
      }
    }

    function logMessage(sMessage, oNode) {

      var log = document.createElement('p');
      log.classList.add('item-log');
      log.textContent = '-> ' + sMessage;

      if (oNode) {
        log.appendChild(oNode);
      }

      logs.appendChild(log);
    }

    function getBar() {
      return bar;
    }

    return {
      updateProgress: updateProgress,
      logMessage: logMessage,
      getBar: getBar
    };
  };

  exports.ProgressBar = ProgressBar;
})(this);