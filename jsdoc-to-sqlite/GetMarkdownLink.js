const GetMarkDownLink = (text = '') => {
    const pattern = /{@link[ 0-9a-zA-Z.#]{0,}}/g;

        return (text !== undefined) ? text.replace(pattern, (x) => {
            const separate = x.split('{@link').filter((obj) => (obj !== ''))[0];
            const clean_elements = separate.trim().replace('}', '');
            return `[${clean_elements}](${clean_elements})`
        }) : '';
}

module.exports = GetMarkDownLink;