var fs = require('fs-extra');
var dirTree = require('directory-tree');
var SQLite3 = require('better-sqlite3');

//  Copy the Structure DB to one we can populate
fs.copySync('./db/phaser-structure.db', './db/phaser-working.db');

//  Open the copy to work on
var db = new SQLite3('./db/phaser-working.db');

//  Open the JSON file to parse
var data = fs.readJsonSync('./json/phaser.json');

//  For our first test let's parse classes only

console.log('Scanning for classes ...');

var getPath = function (path)
{
    // "D:\\wamp\\www\\phaser\\src\\gameobjects\\zone"

    var i = path.indexOf('src');

    if (i === -1)
    {
        return path;
    }

    var section = path.substr(i + 4);

    return section.replace(/\\/g, '/');
};

var insertFunction = function (block, queries)
{
    var funcName = escape(block.longname);

    var query = 'INSERT INTO functions VALUES (';

    query = query.concat('"' + funcName + '",');
    query = query.concat('"' + escape(block.since) + '",');
    query = query.concat('"' + escape(block.name) + '",');
    query = query.concat('"' + escape(block.memberof) + '",');
    query = query.concat('"' + escape(block.description) + '",');
    query = query.concat('"' + escape(block.scope) + '",');

    //  Returns
    var returns = 0;
    var returnType = '';
    var returnDescription = '';

    if (Array.isArray(block.returns) && block.returns.length > 0)
    {
        //  There could be multiple return types (like object|null)
        returns = 1;


    }

/*
      "returns": [
        {
          "type": {
            "names": [
              "array"
            ],
            "parsedType": {
              "type": "NameExpression",
              "name": "array"
            }
          },
          "description": "The array of Game Objects that was passed to this Action."
        }
      ],

*/



    //  Meta
    query = query.concat('"' + escape(block.meta.filename) + '",');
    query = query.concat(escape(block.meta.lineno) + ',');
    query = query.concat('"' + escape(getPath(block.meta.path)) + '"');

    query = query.concat(')');

    queries.push(query);

    if (Array.isArray(block.params) && block.params.length > 0)
    {
        for (var i = 0; i < block.params.length; i++)
        {
            var param = block.params[i];

            var types = param.type.names.join('|');
            var optional = -1;

            if (param.hasOwnProperty('optional'))
            {
                optional = (param.optional) ? 1 : 0;
            }

            var defaultValue = (param.hasOwnProperty('defaultvalue')) ? param.defaultvalue : '';

            query = 'INSERT INTO params VALUES (';

            query = query.concat('"' + funcName + '",');
            query = query.concat('"' + escape(param.name) + '",');
            query = query.concat('"' + escape(param.description) + '",');
            query = query.concat('"' + types + '",');
            query = query.concat('"' + optional + '",');
            query = query.concat('"' + defaultValue + '"');

            query = query.concat(')');

            queries.push(query);
        }
    }

    console.log(funcName);

    return query;
};

var insertClass = function (block, queries)
{
    var className = escape(block.longname);

    var query = 'INSERT INTO class VALUES (';

    query = query.concat('"' + className + '",');
    query = query.concat('"' + escape(block.since) + '",');
    query = query.concat('"' + escape(block.name) + '",');
    query = query.concat('"' + escape(block.memberof) + '",');
    query = query.concat('"' + escape(block.classdesc) + '",');
    query = query.concat('"' + escape(block.meta.filename) + '",');
    query = query.concat(escape(block.meta.lineno) + ',');
    query = query.concat('"' + escape(getPath(block.meta.path)) + '"');

    query = query.concat(')');

    queries.push(query);

    //  Augments

    if (Array.isArray(block.augments) && block.augments.length > 0)
    {
        for (var i = 0; i < block.augments.length; i++)
        {
            query = 'INSERT INTO extends VALUES ("' + className + '", "' + escape(block.augments[i]) + '")';

            queries.push(query);
        }
    }

    //  Constructor Params

    if (Array.isArray(block.params) && block.params.length > 0)
    {
        for (var i = 0; i < block.params.length; i++)
        {
            var param = block.params[i];

            var types = param.type.names.join('|');
            var optional = -1;

            if (param.hasOwnProperty('optional'))
            {
                optional = (param.optional) ? 1 : 0;
            }

            var defaultValue = (param.hasOwnProperty('defaultvalue')) ? param.defaultvalue : '';

            query = 'INSERT INTO params VALUES (';

            query = query.concat('"' + className + '",');
            query = query.concat('"' + escape(param.name) + '",');
            query = query.concat('"' + escape(param.description) + '",');
            query = query.concat('"' + types + '",');
            query = query.concat('"' + optional + '",');
            query = query.concat('"' + defaultValue + '"');

            query = query.concat(')');

            queries.push(query);
        }
    }

    console.log(className);

    return query;
};

var queries = [];

for (var i = 0; i < data.docs.length; i++)
{
    var block = data.docs[i];

    if (block.kind === 'class')
    {
        insertClass(block, queries);
    }
}

console.log('Processing Queries: ', queries.length);

db.transaction(queries).run();

console.log('Complete.');

db.close();
