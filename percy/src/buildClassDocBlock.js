    /**
     * [description]
     *
     * @class AnimationManager
     * @memberOf Phaser.Animations
     * @constructor
     * @since 3.0.0
     * 
     * @param {Phaser.Game} game - [description]
     */

        /**
         * [description]
         *
         * @property {Phaser.Game} game
         * @protected
         * @since 3.0.0
         */


function buildDocBlock (data, src)
{
    // {
    //     className: module,
    //     memberOf: namespace,
    //     extends: extend,
    //     constructor: {
    //         parameters: parameters,
    //         start: start,
    //         end: end,
    //         properties: []
    //     }
    // }

    var className = data.className;

    var docblock = [];

    docblock.push('    /**');
    docblock.push('     * [description]');
    docblock.push('     *');
    docblock.push('     * @class ' + className);

    if (data.extends)
    {
        docblock.push('     * @extends ' + data.memberOf + '.' + data.extends);
    }

    docblock.push('     * @memberOf ' + data.memberOf);
    docblock.push('     * @constructor');
    docblock.push('     * @since 3.0.0');

    if (data.constructor.parameters.length > 0)
    {
        docblock.push('     *');

        for (var i = 0; i < data.constructor.parameters.length; i++)
        {
            var param = data.constructor.parameters[i];

            var name = param.name;

            if (param.optional)
            {
                name = '[' + name + ']';
            }

            docblock.push('     * @param {' + param.type + '} ' + name + ' - ' + param.description);
        }
    }

    docblock.push('     */');

    //  Inject the constructor docblock into the output

        /**
         * [description]
         *
         * @property {Phaser.Game} game
         * @since 3.0.0
         * @protected
         */


    var getLine = function (lineNumber, data, src)
    {
        var props = data.constructor.properties;
        var found = false;
        var result = []

        for (var i = 0; i < props.length; i++)
        {
            var prop = props[i];

            if (prop.line === lineNumber)
            {
                result.push('');
                result.push('        /**');
                result.push('         * ' + prop.description);
                result.push('         *');
                result.push('         * @property {' + prop.type + '} ' + prop.name);
                result.push('         * @since 3.0.0');

                if (prop.private)
                {
                    result.push('         * @private');
                }

                if (prop.default !== '')
                {
                    result.push('         * @default ' + prop.default);
                }

                result.push('         */');

                break;
            }
        }

        result.push(src[lineNumber]);

        return result;
    };

    var out = [];

    for (var i = 0; i < src.length; i++)
    {
        if (i === data.constructor.start)
        {
            out = out.concat(docblock);
            out.push(src[i]);
        }
        else
        {
            out = out.concat(getLine(i, data, src));
        }
    }

    return out;
}
