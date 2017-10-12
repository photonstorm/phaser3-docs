var fs = require('fs');
var dirTree = require('directory-tree');
var beautify = require('json-beautify');
var SQLite3 = require('better-sqlite3');

var rootDir = '../phaser/v3/src/';
var outputJSON = './percy/files.json';

var db = new SQLite3('./percy/files.db');

db.exec(`
    BEGIN TRANSACTION;
    CREATE TABLE "files" (
        'id'    INTEGER PRIMARY KEY AUTOINCREMENT,
        'path'  TEXT NOT NULL,
        'done'  INTEGER NOT NULL DEFAULT 0
    );
    COMMIT;
`);

var queries = [];

var filteredTree = dirTree(rootDir, { extensions: /\.js$/ }, (item, PATH) => {

    item.path = item.path.replace('..\\phaser\\v3\\src\\', '');

    if (item.path.substr(-8) !== 'index.js')
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
        console.log('Running transaction ...');

        db.transaction(queries).run();

        console.log('Complete');

        db.close();
    }

});
