const fs = require('fs-extra');
const SQLite3 = require('better-sqlite3');
const InsertClass = require('./InsertClass');
const InsertConstant = require('./InsertConstant');
const InsertEvent = require('./InsertEvent');
const InsertFunction = require('./InsertFunction');
const InsertNamespace = require('./InsertNamespace');
const InsertMember = require('./InsertMember');
const os = require('os');

//  Copy the Structure DB to one we can populate
fs.copySync('./db/phaser-structure.db', './db/phaser-working.db');

//  Open the copy to work on
const db = new SQLite3('./db/phaser-working.db');

//  Open the JSON file to parse
const data = fs.readJsonSync('./json/phaser.json');
console.log('Start');

InsertClass(db, data);
InsertEvent(db, data);
InsertConstant(db, data);
InsertNamespace(db, data);
InsertMember(db, data);
InsertFunction(db, data);

console.log('Complete');

db.close();
if (os.userInfo().username === 'frank') {
    fs.copySync('./db/phaser-working.db', '../phaser350-docs/sqlite-db/docs_v3.sqlite');
} else {
    fs.copySync('./db/phaser-working.db', 'G:/www/phaser.io/site/app/database/docs_v3.sqlite');
}

