const fs = require('fs-extra');
const SQLite3 = require('better-sqlite3');
const InsertClass = require('./InsertClass');

//  Copy the Structure DB to one we can populate
fs.copySync('./db/phaser-structure.db', './db/phaser-working.db');

//  Open the copy to work on
const db = new SQLite3('./db/phaser-working.db');

//  Open the JSON file to parse
const data = fs.readJsonSync('./json/phaser.json');

InsertClass(db, data);

/*
for (let i = 0; i < data.docs.length; i++)
{
    let block = data.docs[i];

    if (block.ignore)
    {
        continue;
    }

    switch (block.kind)
    {
        case 'class':
            InsertClass(db, block);
            break;

        case 'constant':
            // insertConstant(block, constantQueries);
            break;

        case 'function':
            // insertFunction(block, functionQueries);
            break;

        case 'member':
            // insertMember(block, memberQueries);
            break;

        case 'event':
            // insertEvent(block, eventQueries);
            break;

        case 'namespace':
            // insertNamespace(block, namespaceQueries);
            break;
    }
}
*/

console.log('Complete');

db.close();

fs.copySync('./db/phaser-working.db', 'G:/www/phaser.io/site/app/database/docs_v3.sqlite');
