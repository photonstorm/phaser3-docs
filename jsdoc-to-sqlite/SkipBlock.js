let SkipBlock = function (type, block)
{
    if (block.kind !== type || block.ignore || block.name === 'Class' || block.longname === 'Class')
    {
        return true;
    }

    if (block.hasOwnProperty('access') && block.access === 'private')
    {
        return true;
    }

    return false;
};

module.exports = SkipBlock;
