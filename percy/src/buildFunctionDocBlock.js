function buildFunctionDocBlock (module, data, src)
{
    //  Build the function docblock:
    var className = $('#class').val() + '.' + module;

    var docblock = [];

    docblock.push('/**');
    docblock.push(' * [description]');
    docblock.push(' *');
    docblock.push(' * @function ' + className);
    docblock.push(' * @since 3.0.0');

    if (data.parameters.length > 0)
    {
        docblock.push(' *');

        for (var i = 0; i < data.parameters.length; i++)
        {
            var param = data.parameters[i];

            docblock.push(' * @param {' + param.type + '} ' + param.name + ' - ' + param.description);
        }
    }
    
    if (data.hasReturn)
    {
        docblock.push(' *');

        var returnString = ' * @return {';

        if (data.returns.this)
        {
            returnString = returnString.concat(className);
        }

        if (data.returns.value)
        {
            if (data.returns.this)
            {
                returnString = returnString.concat('|');
            }

            returnString = returnString.concat('[type]');
        }

        if (data.returns.null)
        {
            if (data.returns.this || data.returns.value)
            {
                returnString = returnString.concat('|');
            }

            returnString = returnString.concat('null');
        }

        returnString = returnString.concat('} [description]');

        docblock.push(returnString);
    }

    docblock.push(' */');

    //  Inject the docblock into the source and put into the output

    var out = [];

    for (var i = 0; i < src.length; i++)
    {
        var line = src[i];

        if (i === data.start)
        {
            out = out.concat(docblock);
        }

        out.push(line);
    }

    return out;
}
