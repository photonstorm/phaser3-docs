const CleanFunctionName = require('./CleanFunctionName');
const CleanFunctionParent = require('./CleanFunctionParent');
const GetPath = require('./GetPath');
const SkipBlock = require('./SkipBlock');

let id = 0;

let InsertTypedefs = function (db, data)
{
    const typedefsTransaction = db.prepare(`INSERT INTO typedefs (
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

    const paramsTransaction = db.prepare(`INSERT INTO params (
        parentClass,
        parentFunction,
        name,
        position,
        description,
        type,
        optional,
        defaultValue
    ) VALUES (
        @parentClass,
        @parentFunction,
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
    let paramsQueries = [];

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

        // if (block.longname === 'Phaser.Types.Actions.CallCallback') {
        //     console.log(block);
        // }

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

        // Typedef Params: 
        if (Array.isArray(block.params) && block.params.length > 0)
        {
            for (let i = 0; i < block.params.length; i++)
            {
                let param = block.params[i];
              
                let types = param.type.names.join(' | ');
                let optional = -1;

                if (param.hasOwnProperty('optional'))
                {
                    optional = (param.optional) ? 1 : 0;
                }

                let defaultValue = (param.hasOwnProperty('defaultvalue')) ? String(param.defaultvalue) : '';

                paramsQueries.push({
                    parentClass: (block.type.names.join(' | ').toLowerCase() == 'class') ? typedefName : '',
                    parentFunction: (block.type.names.join(' | ').toLowerCase() == 'function') ? typedefName : '',
                    name: param.name,
                    position: i,
                    description: param.description,
                    type: types,
                    optional: optional,
                    defaultValue: defaultValue
                });                
            }
        }
    }

    if (typedefQueries.length)
    {
        insertMany(typedefsTransaction, typedefQueries);
    }

    if (propertiesQueries.length)
    {
        insertMany(propertiesTransaction, propertiesQueries);
    }

    if (paramsQueries.length)
    {
        insertMany(paramsTransaction, paramsQueries);
    }
};

module.exports = InsertTypedefs;
