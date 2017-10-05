var fs = require('fs');
var dirTree = require('directory-tree');
var beautify = require('json-beautify');
var SQLite3 = require('better-sqlite3');

var rootDir = '../phaser/v3/src/';
var outputJSON = './percy/files.json';
var db = new SQLite3('./percy/converted.db');

var stmt = db.prepare('INSERT INTO files VALUES (?, ?)');

var filteredTree = dirTree(rootDir, { extensions: /\.js$/ }, (item, PATH) => {

    item.path = item.path.replace('..\\phaser\\v3\\src\\', '');

    //  Add to the database if not already saved

    stmt.run(item.path, 0);

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

        db.close();
    }

});
