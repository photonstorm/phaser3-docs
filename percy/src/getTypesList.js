function getTypesList (id, input, param)
{
    var types = [
        '[type]',
        'string',
        'integer',
        'float',
        'number',
        'function',
        'object',
        'Phaser.Geom.Circle'
    ];

    var select = $('<select>', { class: 'custom-select', id: id });

    for (var i = 0; i < types.length; i++)
    {
        var type = $('<option>', { value: types[i] }).text(types[i]);

        select.append(type);
    }

    select.on('change', function () {

        input.val(this.value);

    });

    return select;
}
