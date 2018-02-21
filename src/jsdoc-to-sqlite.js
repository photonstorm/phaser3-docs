var fs = require('fs');
var dirTree = require('directory-tree');
var SQLite3 = require('better-sqlite3');

//  Copy the Structure DB to one we can populate
fs.copySync('./db/phaser-structure.db', './db/phaser-working.db');

//  Open the copy to work on
var db = new SQLite3('./db/phaser-working.db');

//  Open the JSON file to parse
var data = JSON.parse(require('./json/phaser.json'));

console.log('hello?');

/*
var queries = [];

var filteredTree = dirTree(rootDir, { extensions: /\.js$/ }, (item, PATH) => {

    item.path = item.path.replace('..\\phaser\\src\\', '');

    if (
        item.path.substr(-8) !== 'index.js' &&
        item.path.substr(0, 21) !== 'physics\\matter-js\\lib' &&
        item.path.substr(0, 9) !== 'polyfills'
        )
    {
        queries.push('INSERT INTO files (path) VALUES ("' + item.path + '")');
    }

});

filteredTree = beautify(filteredTree, null, 2, 100);

//  Save the JSON

fs.writeFile(outputJSON, filteredTree, function (error) {

    if (error)
    {
        throw error;
    }
    else
    {
        console.log('files.json saved');
        console.log('Running transaction (' + queries.length + ' queries)');

        db.transaction(queries).run();

        console.log('Complete. Now run \'sync\'');

        db.close();
    }

});
*/
