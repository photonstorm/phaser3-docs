const GetMarkDownLink = (text = '') => {
    const pattern = /\[[ 0-9a-z.#]{0,}\]{@link[ 0-9a-z.#]{0,}}|{@link[ 0-9a-z.#\|]{0,}}/gi;
    
    return (text !== undefined) ? text.replace(pattern, (string) => {
        let link = '';
        if (string.match(/\[[a-zA-Z]{0,}\]/i)) {
            link = string.replace('}', ')')
                .replace('{@link', '(')
                .replace('( ', '(');
            
        } else {
            const array_with_description = string.split('|');
            if (array_with_description.length > 1) {
                const description = '[' + array_with_description[1].replace('}', ']');
                const clean_link = array_with_description[0]
                    .replace('{@link', '(')
                    .replace('( ', '(') + ')';
                link = description + clean_link;
            } else {

                const separate = string.split('{@link').filter((obj) => (obj !== ''))[0];
                const clean_elements = separate.trim().replace('}', '');
                link = `[${clean_elements}](${clean_elements})`;
            }
        }
        return link;
    }) : '';
}

module.exports = GetMarkDownLink;
