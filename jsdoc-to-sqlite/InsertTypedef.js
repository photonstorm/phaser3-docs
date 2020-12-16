const CleanEventName = require('./CleanEventName');
const GetPath = require('./GetPath');
const SkipBlock = require('./SkipBlock');

let id = 0;

let InsertTypedef = function (db, data)
{
    const typeTransaction = db.prepare(`INSERT INTO typedef (
        id,
        longname,
        memberof,
        name,
        description,
        type,
        defaultValue,
        metafilename,
        metalineno,
        metapath,
        since
    ) VALUES (
        @id,
        @longname,
        @memberof,
        @name,
        @description,
        @type,
        @defaultValue,
        @metafilename,
        @metalineno,
        @metapath,
        @since
    )`);

    const propertiesTransaction = db.prepare(`INSERT INTO properties (
        parentType,
        name,
        position,
        description,
        type,
        optional,
        defaultValue
    ) VALUES (
        @parentType,
        @name,
        @position,
        @description,
        @type,
        @optional,
        @defaultValue
    )`);

    const insertMany = db.transaction((transaction, queries) => {
        for (const query of queries)
        {
            transaction.run(query);
        }
    });

    let typedefQueries = [];
    let propertiesQueries = [];

    for (let i = 0; i < data.docs.length; i++)
    {
        let block = data.docs[i];

        if (SkipBlock('typedef', block))
        {
            continue;
        }
        
        if (block.scope === 'global') {
            continue;
        }

        let typedefName = block.longname;
        typedefQueries.push({
            id: ++id,
            longname: typedefName,
            memberof: block.memberof,
            since: (block.hasOwnProperty('since')) ? block.since : '3.0.0',
            name: block.name,
            description: (block.hasOwnProperty('description')) ? block.description : '',
            type: (block.hasOwnProperty('type')) ? block.type.names.join(' | ') : '',
            defaultValue: (block.hasOwnProperty('defaultvalue')) ? String(block.defaultvalue) : '',
            metafilename: block.meta.filename,
            metalineno: block.meta.lineno,
            metapath: GetPath(block.meta.path)
        });

        //  Typedef Properties
        if (Array.isArray(block.properties) && block.properties.length > 0)
        {
            for (let i = 0; i < block.properties.length; i++)
            {
                let property = block.properties[i];
                let types = property.type.names.join(' | ');
                let optional = -1;

                if (property.hasOwnProperty('optional'))
                {
                    optional = (property.optional) ? 1 : 0;
                }

                let defaultValue = (property.hasOwnProperty('defaultvalue')) ? String(property.defaultvalue) : '';

                propertiesQueries.push({
                    parentType: typedefName,
                    name: property.name,
                    position: i,
                    description: property.description,
                    type: types,
                    optional: optional,
                    defaultValue: defaultValue
                });
            }
        }
    }

    if (typedefQueries.length)
    {
        insertMany(typeTransaction, typedefQueries);
    }

    if (propertiesQueries.length)
    {
        insertMany(propertiesTransaction, propertiesQueries);
    }
};

module.exports = InsertTypedef;
