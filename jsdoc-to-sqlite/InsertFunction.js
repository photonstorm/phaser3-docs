const CleanEventName = require('./CleanEventName');
const CleanFunctionName = require('./CleanFunctionName');
const CleanFunctionParent = require('./CleanFunctionParent');
const GetPath = require('./GetPath');
const HasTag = require('./HasTag');
const SkipBlock = require('./SkipBlock');

let InsertFunction = function (db, data)
{
    const functionTransaction = db.prepare(`INSERT INTO functions (
        longname,
        since,
        name,
        memberof,
        description,
        scope,
        fires,
        signature,
        returns,
        returnstype,
        returnsdescription,
        metafilename,
        metalineno,
        metapath,
        inherited,
        inherits,
        webgl
    ) VALUES (
        @longname,
        @since,
        @name,
        @memberof,
        @description,
        @scope,
        @fires,
        @signature,
        @returns,
        @returnstype,
        @returnsdescription,
        @metafilename,
        @metalineno,
        @metapath,
        @inherited,
        @inherits,
        @webgl
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

    let functionQueries = [];
    let paramsQueries = [];

    for (let i = 0; i < data.docs.length; i++)
    {
        let block = data.docs[i];

        if (SkipBlock('function', block))
        {
            continue;
        }

        //  Function parameters
        let params = [];
        let signatureParams = [];

        if (Array.isArray(block.params) && block.params.length > 0)
        {
            for (let i = 0; i < block.params.length; i++)
            {
                let param = block.params[i];

                if (!param.type)
                {
                    console.log('>>> Parameter Error');
                    console.log(block.longname);
                    console.log(param);
                    process.exit();
                }
    
                let types = param.type.names.join('|');
                let optional = -1;

                if (param.hasOwnProperty('optional'))
                {
                    optional = (param.optional) ? 1 : 0;
                }

                let defaultValue = (param.hasOwnProperty('defaultvalue')) ? String(param.defaultvalue) : '';

                paramsQueries.push({
                    parentClass: CleanFunctionParent(block.longname),
                    parentFunction: CleanFunctionName(block.longname),
                    name: param.name,
                    position: i,
                    description: param.description,
                    type: types,
                    optional: optional,
                    defaultValue: defaultValue
                });

                //  Add to the params array (for injection to the functions table)

                let paramStr = param.name;
                
                if (optional === 1)
                {
                    paramStr += '?';
                }
                
                paramStr += ':' + types;

                signatureParams.push(paramStr);

                if (defaultValue !== '')
                {
                    paramStr += ' = ' + defaultValue;
                }

                params.push(paramStr);
            }
        }

        //  Fires
        let fires = '';

        if (Array.isArray(block.fires) && block.fires.length > 0)
        {
            for (let e = 0; e < block.fires.length; e++)
            {
                block.fires[e] = CleanEventName(block.fires[e]);
            }
    
            fires = block.fires.join(',');
        }

        //  Function signature
        let signature = signatureParams.join(',');

        //  Returns
        let returns = 0;
        let returnsType = '';
        let returnsDescription = '';

        if (Array.isArray(block.returns) && block.returns.length > 0)
        {
            //  For Phaser we only need concern ourselves with the first returns element
            if (!block.returns[0].hasOwnProperty('type'))
            {
                console.log('>>> Returns Error');
                console.log(block.longname);
                console.log(block.returns[0]);
                process.exit();
            }

            returns = 1;
            returnsType = block.returns[0].type.names.join('|');
            returnsDescription = block.returns[0].description;
        }

        //  Inherited
        let inherited = 0;
        let inherits = '';

        if (block.hasOwnProperty('inherited') && block.inherited)
        {
            inherited = 1;
            inherits = block.inherits;
        }
    
        functionQueries.push({
            longname: block.longname,
            since: block.since,
            name: block.name,
            memberof: block.memberof,
            description: block.description,
            scope: block.scope,
            fires: fires,
            signature: signature,
            returns: returns,
            returnstype: returnsType,
            returnsdescription: returnsDescription,
            metafilename: block.meta.filename,
            metalineno: block.meta.lineno,
            metapath: GetPath(block.meta.path),
            inherited: inherited,
            inherits: inherits,
            webgl: HasTag(block, 'webglOnly')
        });
    }

    if (functionQueries.length)
    {
        insertMany(functionTransaction, functionQueries);
    }

    if (paramsQueries.length)
    {
        insertMany(paramsTransaction, paramsQueries);
    }
};

module.exports = InsertFunction;
