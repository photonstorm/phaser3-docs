const GetPath = require('./GetPath');
const SkipBlock = require('./SkipBlock');
const HasTag = require('./HasTag');

let InsertMember = function (db, data)
{
    const memberTransaction = db.prepare(`INSERT INTO members (
        longname,
        since,
        name,
        memberof,
        description,
        type,
        defaultValue,
        readOnly,
        scope,
        metafilename,
        metalineno,
        metapath,
        webgl,
        inherited,
        inherits,
        nullable
    ) VALUES (
        @longname,
        @since,
        @name,
        @memberof,
        @description,
        @type,
        @defaultValue,
        @readOnly,
        @scope,
        @metafilename,
        @metalineno,
        @metapath,
        @webgl,
        @inherited,
        @inherits,
        @nullable
    )`);

    const insertMany = db.transaction((transaction, queries) => {
        for (const query of queries)
        {
            transaction.run(query);
        }
    });

    let memberQueries = [];

    for (let i = 0; i < data.docs.length; i++)
    {
        let block = data.docs[i];

        if (SkipBlock('member', block))
        {
            continue;
        }

        if (block.scope === 'global' && block.longname === block.name)
        {
            //  Global function skip
            continue;
        }

        memberQueries.push({
            longname: block.longname,
            since: (block.hasOwnProperty('since')) ? block.since : '3.0.0',
            name: block.name,
            memberof: block.memberof,
            description: block.description,
            type: (block.hasOwnProperty('type')) ? block.type.names.join('|') : '',
            defaultValue: (block.hasOwnProperty('defaultvalue')) ? block.defaultvalue : '',
            readOnly: (block.hasOwnProperty('readonly') && block.readonly) ? 1 : 0,
            scope: block.scope,
            metafilename: block.meta.filename,
            metalineno: block.meta.lineno,
            metapath: GetPath(block.meta.path),
            webgl: HasTag(block, 'webglOnly'),
            inherited: (block.hasOwnProperty('inherited') && block.inherited) ? 1 : 0,
            inherits: (block.hasOwnProperty('inherited') && block.inherited) ? block.inherits : '',
            nullable: (block.hasOwnProperty('nullable') && block.nullable) ? 1 : 0
        });
    }

    if (memberQueries.length)
    {
        insertMany(memberTransaction, memberQueries);
    }
};

module.exports = InsertMember;
