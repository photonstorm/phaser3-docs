function buildFunctionDocBlock (module, data, src)
{
    //  Build the function docblock:

    var className = data.className;
    // var className = $('#class').val() + '.' + module;

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
        docblock.push(' * @return {' + data.returns.type + '} [description]');
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
