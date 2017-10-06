function findProperties (data, src)
{
    var start = data.constructor.start + 1;
    var end = data.constructor.end - 1;
    var search = '        this.';
    var scanLength = search.length;
    var props = data.constructor.properties;

    for (var i = start; i < end; i++)
    {
        var line = src[i];

        if (line.substr(0, scanLength) === search)
        {
            //  Found a property
            var property = line.substring(scanLength);

            //  Does it have an = sign?

            var type = '[type]';

            // this.name = '';
            var to = property.indexOf('=');

            if (to === -1)
            {
                // this.scene;
                to = property.indexOf(';') + 1;
                type = 'null';
            }

            property = property.substr(0, to - 1);

            props.push({
                line: i,
                name: property,
                type: type,
                description: '[description]',
                default: null,
                private: (property.charAt(0) === '_')
            });
        }
    }
}
