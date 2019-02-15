const GetPath = require('./GetPath');
const SkipBlock = require('./SkipBlock');

let InsertConstant = function (db, data)
{
    const constantTransaction = db.prepare(`INSERT INTO constants (
        longname,
        since,
        name,
        memberof,
        description,
        type,
        scope,
        metafilename,
        metalineno,
        metapath
    ) VALUES (
        @longname,
        @since,
        @name,
        @memberof,
        @description,
        @type,
        @scope,
        @metafilename,
        @metalineno,
        @metapath
    )`);

    const insertMany = db.transaction((transaction, queries) => {
        for (const query of queries)
        {
            transaction.run(query);
        }
    });

    let constantQueries = [];

    for (let i = 0; i < data.docs.length; i++)
    {
        let block = data.docs[i];

        if (SkipBlock('constant', block))
        {
            continue;
        }

        constantQueries.push({
            longname: block.longname,
            since: (block.hasOwnProperty('since')) ? block.since : '3.0.0',
            name: block.name,
            memberof: block.memberof,
            description: block.description,
            type: (block.hasOwnProperty('type')) ? block.type.names.join('|') : '',
            scope: block.scope,
            metafilename: block.meta.filename,
            metalineno: block.meta.lineno,
            metapath: GetPath(block.meta.path)
        });
    }

    if (constantQueries.length)
    {
        insertMany(constantTransaction, constantQueries);
    }
};

module.exports = InsertConstant;
