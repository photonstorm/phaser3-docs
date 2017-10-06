function getTypesList (id, input, param)
{
    var types = [
        '[type]',
        'string',
        'integer',
        'float',
        'number',
        'boolean',
        'function',
        'object',
        'array',
        'Phaser.Scene',
        'Phaser.Animations.Animation',
        'Phaser.Events.EventDispatcher',
        'Phaser.Events.Event',
        'Phaser.GameObjects.GameObject',
        'Phaser.GameObjects.Sprite',
        'Phaser.GameObjects.Image',
        'Phaser.Structs.Map',
        'Phaser.Structs.Set',
        'Phaser.Tweens.Tween',
        'Phaser.Class',
        'Phaser.Geom.Circle',
        'Phaser.Geom.Ellipse',
        'Phaser.Geom.Line',
        'Phaser.Geom.Point',
        'Phaser.Geom.Polygon',
        'Phaser.Geom.Rectangle',
        'Phaser.Geom.Triangle',
        'Phaser.Math.Vector2',
        'Phaser.Math.Vector3',
        'Phaser.Math.Vector4',
        'Phaser.Math.Matrix3',
        'Phaser.Math.Matrix4',
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
