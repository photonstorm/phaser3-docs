window.Searcher = (function() {
    function Searcher() {
        this._index = undefined;
        this._indexContent = undefined;
    }

    Searcher.prototype.init = function(callback) {
        var self = this;
        const result = _getIndexData();

        var w = new Worker('scripts/lunr-worker.js');

        w.postMessage(result);
        w.onmessage = function (e)
        {
            self._index = lunr.Index.load(JSON.parse(e.data))
            if(callback)
                callback();
            w.terminate();
        }
    };

    Searcher.prototype.search = function(searchTerm) {
        var results = [],
                searchResults = this._index.search(searchTerm);

        for (var idx = 0; idx < searchResults.length; idx++) {
            results.push(this._indexContent[searchResults[idx].ref])
        }

        return results;
    };

    function _getIndexData() {
        const self = this;
        const data = Array.from(document.querySelectorAll("script[type='text/x-docstrap-searchdb']"));
        let result = [];

        data.forEach(x => {
            const json = JSON.parse(x.innerHTML);
            self._indexContent = json;

            for (let entry in json) {
                result.push(json[entry]);
            }
        });
        return result;
    }

    
		
    function _enableSearchBox() { 
        $('#search-input').removeClass('loading');
        $('#search-input').removeAttr('disabled');
        $('#search-submit').removeAttr('disabled');
    }

    return new Searcher();
})();