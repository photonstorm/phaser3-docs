const fs = require('fs-extra');
const SQLite3 = require('better-sqlite3');
const InsertClass = require('./InsertClass');
const InsertConstant = require('./InsertConstant');
const InsertEvent = require('./InsertEvent');
const InsertFunction = require('./InsertFunction');
const InsertNamespace = require('./InsertNamespace');
const InsertMember = require('./InsertMember');

//  Copy the Structure DB to one we can populate
fs.copySync('./db/phaser-structure.db', './db/phaser-working.db');

//  Open the copy to work on
const db = new SQLite3('./db/phaser-working.db');

//  Open the JSON file to parse
const data = fs.readJsonSync('./json/phaser.json');

InsertClass(db, data);
InsertEvent(db, data);
InsertConstant(db, data);
InsertNamespace(db, data);
InsertMember(db, data);
InsertFunction(db, data);

console.log('Complete');

db.close();

fs.copySync('./db/phaser-working.db', 'G:/www/phaser.io/site/app/database/docs_v3.sqlite');
