function showParametersModal (module, data, src)
{
    //  Build-up the modal content
    var container = $('#paramsContainer');

    //  Clear out anything that may have been in there already
    container.empty();

    //  Build the parameters list

    for (var i = 0; i < data.parameters.length; i++)
    {
        var param = data.parameters[i];

        var div = $('<div>', { class: 'container' });
        var row = $('<div>', { class: 'row py-2' });
        var col1 = $('<div>', { class: 'col col-sm-2' });
        var col2 = $('<div>', { class: 'col col-sm-4' });
        var col3 = $('<div>', { class: 'col' });

        var label = $('<label>', { for: 'param' + i }).text(param.name);
        var input = $('<input>', { type: 'text', id: 'cp' + i, class: 'form-control', value: param.type });
        var select = getTypesList('param' + i, input, param);

        row.on('mouseover', function () {

            $(this).css('background-color', '#01FF70');

        });

        row.on('mouseout', function () {

            $(this).css('background-color', '#fff');

        });

        div.append(row);

        row.append(col1);
        row.append(col2);
        row.append(col3);

        col1.append(label);
        col2.append(select);
        col3.append(input);

        container.append(div);
    }

    if (data.hasReturn)
    {
        var typeString = '';

        if (data.returns.this)
        {
            typeString = data.className;
        }

        if (data.returns.value)
        {
            if (data.returns.this)
            {
                typeString = typeString.concat('|');
            }

            typeString = typeString.concat('[type]');
        }

        if (data.returns.null)
        {
            if (data.returns.this || data.returns.value)
            {
                typeString = typeString.concat('|');
            }

            typeString = typeString.concat('null');
        }

        var div = $('<div>', { class: 'container' });
        var row = $('<div>', { class: 'row py-2' });
        var col1 = $('<div>', { class: 'col col-sm-2' });
        var col2 = $('<div>', { class: 'col col-sm-4' });
        var col3 = $('<div>', { class: 'col' });

        var label = $('<label>', { for: 'returnValue', style: 'font-weight: bold' }).text('Returns');
        var input = $('<input>', { type: 'text', id: 'returnValue', class: 'form-control', value: typeString });
        var select = getTypesList('returnValue', input);

        row.on('mouseover', function () {

            $(this).css('background-color', '#01FF70');

        });

        row.on('mouseout', function () {

            $(this).css('background-color', '#fff');

        });

        div.append(row);

        row.append(col1);
        row.append(col2);
        row.append(col3);

        col1.append(label);
        col2.append(select);
        col3.append(input);

        container.append(div);
    }

    //  Show the modal
    $('#paramsModal').modal('show');

    //  Button save ...
    $('#generateButton').click(function() {

        //  Update the data object with the parameter settings

        for (var i = 0; i < data.parameters.length; i++)
        {
            var param = data.parameters[i];

            param.type = $('#cp' + i).val();
        }

        //  and the Return value

        if (data.hasReturn)
        {
            data.returns.type = $('#returnValue').val();
        }

        $('#paramsModal').modal('hide');

        var out = buildFunctionDocBlock(module, data, src);

        $('#output').text(out.join('\n'));

    });
}